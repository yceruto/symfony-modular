# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Symfony 7.4 modular application demonstrating Domain-Driven Design (DDD) with a clean architecture approach. The project uses:
- API Platform for REST APIs
- Symfony Messenger for message handling
- Doctrine ORM with attribute-based mapping
- Open Solid CQS and Domain bundles for CQRS pattern
- Monolog for logging
- SQLite as the default database (configurable)

## Key Commands

### Development
```bash
# Run the Symfony development server
symfony server:start

# Clear cache
php bin/console cache:clear

# List all available commands
php bin/console list
```

### Database
```bash
# Create database and run migrations
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# Generate a new migration
php bin/console doctrine:migrations:diff
```

### Room Management (Example Domain)
```bash
# Create a room
php bin/console app:create-room

# List all rooms
php bin/console app:list-rooms

# Delete all rooms
php bin/console app:delete-rooms
```

### API Platform
```bash
# Export OpenAPI documentation
php bin/console api:openapi:export

# Debug API resources
php bin/console debug:api-resource
```

## Architecture

### Modular Structure

The application follows a **modular monolith** pattern with bounded contexts organized under `src/`:

```
src/
├── Catalog/              # Business domain modules
│   └── Room/             # Example: Room module
│       ├── Application/  # Use cases (Commands/Queries/Handlers)
│       ├── Domain/       # Business logic (Models/Events/Errors/Repositories)
│       ├── Infrastructure/ # Technical implementation (Persistence/Config/History)
│       └── Presentation/ # UI layer (HTTP Resources/Console Commands)
└── Shared/               # Cross-cutting concerns
    ├── Domain/           # Shared domain abstractions
    └── Infrastructure/   # Shared infrastructure (Bus/Persistence/Extensions)
```

Each module follows **4-layer architecture**:
1. **Presentation**: Primary adapters, HTTP controllers via API Platform Resources, Console commands
2. **Application**: Application logic, CQRS handlers using `#[AsCommandHandler]` and `#[AsQueryHandler]`
3. **Domain**: Core business logic, Rich domain models with behavior, domain events, value objects, repositories (interfaces)
4. **Infrastructure**: Secondary adapters, persistence implementations, event subscribers, module configuration

### Module System

Modules are self-contained via custom **Symfony Extensions**:

- Each module has a `{ModuleName}Extension` class extending `SharedExtension`
- Extensions auto-load configuration from `Infrastructure/Resources/config/packages/*.yaml`
- Configuration is module-scoped (e.g., Doctrine mappings, API Platform resources)
- Example: `src/Catalog/Room/Infrastructure/RoomExtension.php`

To add a new module:
1. Create the module directory structure under `src/{Context}/{ModuleName}/`
2. Create `{ModuleName}Extension.php` in `Infrastructure/` extending `SharedExtension`
3. Add module-specific configuration in `Infrastructure/Resources/config/packages/{package}.yaml` if necessary

### CQRS Pattern

The application uses **Command Query Responsibility Segregation**:

- **Commands**: Write operations (Create/Update/Delete)
  - Located in `Application/{Operation}/`
  - Handlers marked with `#[AsCommandHandler]`
  - Example: `CreateRoom` command → `CreateRoomHandler`

- **Queries**: Read operations (Find/Get/List)
  - Located in `Application/Find/`
  - Handlers marked with `#[AsQueryHandler]`
  - Example: `FindAllRooms` query → `FindAllRoomsHandler`
  - Custom finder interfaces for flexible queries

### Domain Events

Domain models use the `InMemoryEventStoreTrait` from OpenSolid to publish events:

```php
$this->pushDomainEvent(new RoomCreated($this->id->value));
```

Events are automatically published via Symfony Messenger after successful persistence. 
Event subscribers live in `Infrastructure/` for cross-cutting concerns like logging.

### API Platform Integration

HTTP endpoints are defined via `#[ApiResource]` attributes in `Presentation/Http/Resource/`:

- Each operation specifies custom **Providers** (read) and **Processors** (write)
- Operations map to CQRS handlers via dedicated operation classes
- Input/Output DTOs separate API contracts from domain models
- Example: `RoomResource.php` defines GET, POST, PATCH, DELETE with custom providers/processors

### Value Objects & Custom Types

The codebase uses strongly-typed value objects (e.g., `RoomId`, `RoomNumber`, `RoomStatus`) mapped to Doctrine via custom DBAL types:

- Custom types defined in `Shared/Infrastructure/Persistence/Doctrine/DBAL/Type/`
- Registered in module-specific `doctrine.yaml` configuration
- Value objects enforce domain invariants and provide type safety

### Domain Model Patterns

Domain models follow these patterns:

1. **Rich Domain Models**: Business logic and validation lives in the domain model (e.g., `Room::updateStatus()`)
2. **Invariant Protection**: Models throw domain exceptions (e.g., `InvalidRoomState`) for invalid state transitions
3. **Domain Events**: Models publish events for significant state changes
4. **Value Objects**: Immutable, self-validating domain primitives
5. **Repository Pattern**: Abstract persistence behind repository interfaces defined in Domain layer

### Error Handling

Domain errors are mapped to HTTP status codes via API Platform configuration:

```yaml
# config/packages/api_platform.yaml
exception_to_status:
    OpenSolid\Domain\Error\EntityNotFound: 404
    OpenSolid\Domain\Error\InvariantViolation: 422
```

Custom domain errors extend these base error types.

## Configuration

- Main config: `config/packages/` for global configuration
- Module config: `src/{Context}/{Module}/Infrastructure/Resources/config/packages/` for module-specific settings
- Environment: `.env` for defaults, `.env.local` for local overrides (not committed)
- Database: SQLite by default (`var/data_dev.db`), configured via `DATABASE_URL`

## Dependencies

Key libraries to understand:

- **open-solid/cqs-bundle**: Provides CQRS handler attributes and command/query bus
- **open-solid/domain-bundle**: Provides domain event infrastructure and base error types
- **API Platform**: REST API framework with automatic OpenAPI docs
- **Symfony Messenger**: Async message handling and domain event dispatching (currently sync transport)
- **Doctrine ORM**: Persistence with attribute-based mapping and custom DBAL types
