# Skill: Create New Module

This skill generates a new module with minimal setup for a Symfony modular application following DDD principles.

## When to Use

Use this skill when the user asks to:
- Create a new module
- Add a new bounded context
- Generate module scaffolding

## Required Information

Ask the user for:
1. **Context name** (e.g., `Catalog`, `Booking`, `Auth`) - The bounded context/domain area
2. **Module name** (e.g., `Room`, `Reservation`, `Account`) - The specific module within the context
3. **Entity name** (e.g., `Room`, `Reservation`, `User`) - The main domain entity (usually same as module name)

## Directory Structure to Generate

```
src/{Context}/{Module}/
├── Application/           # Use cases (Commands/Queries) - create empty initially
├── Domain/
│   ├── Error/            # Domain exceptions - empty initially
│   ├── Event/            # Domain events - empty initially
│   ├── Model/
│   │   ├── {Entity}.php
│   │   └── {Entity}Id.php
│   └── Repository/
│       └── {Entity}Repository.php
├── Infrastructure/
│   ├── Persistence/
│   │   └── Doctrine/
│   │       └── Doctrine{Entity}Repository.php
│   └── {Module}Extension.php
└── Presentation/          # HTTP/Console - create empty initially
```

## Files to Generate

### 1. Module Extension (Required)

**File:** `src/{Context}/{Module}/Infrastructure/{Module}Extension.php`

```php
<?php

declare(strict_types=1);

namespace App\{Context}\{Module}\Infrastructure;

use OpenSolid\Shared\Infrastructure\Symfony\Module\ModuleExtension;

class {Module}Extension extends ModuleExtension
{
}
```

### 2. Entity ID (Required)

**File:** `src/{Context}/{Module}/Domain/Model/{Entity}Id.php`

```php
<?php

declare(strict_types=1);

namespace App\{Context}\{Module}\Domain\Model;

use App\Shared\Domain\Model\Uid;

class {Entity}Id extends Uid
{
}
```

### 3. Entity (Required)

**File:** `src/{Context}/{Module}/Domain/Model/{Entity}.php`

```php
<?php

declare(strict_types=1);

namespace App\{Context}\{Module}\Domain\Model;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class {Entity}
{
    #[Id, Column]
    private(set) {Entity}Id $id;

    #[Column]
    private(set) \DateTimeImmutable $createdAt;

    public function __construct({Entity}Id $id)
    {
        $this->id = $id;
        $this->createdAt = new \DateTimeImmutable();
    }
}
```

### 4. Repository Interface (Required)

**File:** `src/{Context}/{Module}/Domain/Repository/{Entity}Repository.php`

```php
<?php

namespace App\{Context}\{Module}\Domain\Repository;

use App\{Context}\{Module}\Domain\Model\{Entity};
use App\{Context}\{Module}\Domain\Model\{Entity}Id;

interface {Entity}Repository
{
    public function add({Entity} $entity): void;

    public function remove({Entity} $entity): void;

    public function ofId({Entity}Id $id): ?{Entity};

    /** @return iterable<{Entity}> */
    public function all(): iterable;
}
```

### 5. Doctrine Repository Adapter (Required)

**File:** `src/{Context}/{Module}/Infrastructure/Persistence/Doctrine/Doctrine{Entity}Repository.php`

```php
<?php

declare(strict_types=1);

namespace App\{Context}\{Module}\Infrastructure\Persistence\Doctrine;

use App\{Context}\{Module}\Domain\Model\{Entity};
use App\{Context}\{Module}\Domain\Model\{Entity}Id;
use App\{Context}\{Module}\Domain\Repository\{Entity}Repository;
use Doctrine\ORM\EntityManagerInterface;

final readonly class Doctrine{Entity}Repository implements {Entity}Repository
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function add({Entity} $entity): void
    {
        $this->entityManager->persist($entity);
    }

    public function remove({Entity} $entity): void
    {
        $this->entityManager->remove($entity);
    }

    public function ofId({Entity}Id $id): ?{Entity}
    {
        return $this->entityManager->find({Entity}::class, $id);
    }

    public function all(): iterable
    {
        return $this->entityManager->getRepository({Entity}::class)->findAll();
    }
}
```

## Post-Generation Steps

After generating the files, remind the user to:

**Create and run migration:**
```bash
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

## Example Usage

**User:** "Create a new module for managing products in the Catalog context"

**Response:** Generate files with:
- Context: `Catalog`
- Module: `Product`
- Entity: `Product`

This creates:
- `src/Catalog/Product/Application/`
- `src/Catalog/Product/Domain/Model/Product.php`
- `src/Catalog/Product/Domain/Model/ProductId.php`
- `src/Catalog/Product/Domain/Repository/ProductRepository.php`
- `src/Catalog/Product/Infrastructure/Persistence/Doctrine/DoctrineProductRepository.php`
- `src/Catalog/Product/Infrastructure/ProductExtension.php`
- `src/Catalog/Product/Presentation/`
