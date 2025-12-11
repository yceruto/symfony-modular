---
name: new-enum
description: Create a PHP backed enum class following DDD principles. Use when adding state/status enums.
allowed-tools: Read, Glob, Grep, Write, Edit
---

# Skill: Create Enum Class

This skill generates a new PHP backed enum class following DDD principles for value objects.

## When to Use

Use this skill when the user asks to:
- Create a new enum
- Add a state/status enum
- Generate an enum value object

## Required Information

Ask the user for:
1. **Context name** (e.g., `Catalog`, `Booking`, `Auth`) - The bounded context/domain area
2. **Module name** (e.g., `Room`, `Reservation`, `Account`) - The module within the context
3. **Enum name** (e.g., `RoomState`, `PaymentState`, `OrderType`) - The enum class name
4. **Cases** - The enum cases with their string values (e.g., `AVAILABLE => 'available'`, `PENDING => 'pending'`)
5. **State transitions** (optional) - If the enum represents states, ask if transition rules are needed

## File Location

```
src/{Context}/{Module}/Domain/Model/{EnumName}.php
```

## Template

**File:** `src/{Context}/{Module}/Domain/Model/{EnumName}.php`

```php
<?php

declare(strict_types=1);

namespace App\{Context}\{Module}\Domain\Model;

enum {EnumName}: string
{
    case {CASE_1} = '{value-1}';
    case {CASE_2} = '{value-2}';
    // ... more cases

    public function is{Case1}(): bool
    {
        return self::{CASE_1} === $this;
    }

    public function is{Case2}(): bool
    {
        return self::{CASE_2} === $this;
    }

    // ... more is*() methods for each case

    public function equals(self $other): bool
    {
        return $this === $other;
    }
}
```

## With State Transitions (Optional)

If the enum represents states with transition rules, add:

```php
    public function canTransitionTo(self $state): bool
    {
        $feasible = match ($this) {
            self::{CASE_1} => [self::{CASE_2}, self::{CASE_3}],
            self::{CASE_2} => [self::{CASE_1}],
            self::{CASE_3} => [self::{CASE_1}],
        };

        return \in_array($state, $feasible, true);
    }
```

## Pattern Guidelines

1. **Backed enums**: Always use `string` backed enums with lowercase kebab-case values
2. **Case naming**: Use UPPER_SNAKE_CASE for case names
3. **Value naming**: Use lowercase kebab-case for string values (e.g., `'under-maintenance'`)
4. **Helper methods**: Add `is{CaseName}()` method for each case
5. **Equality**: Always include an `equals(self $other)` method
6. **Transitions**: If the enum represents a state machine, include `canTransitionTo()` method

## Doctrine XML Mapping

If the enum is used as a field in an entity, add the mapping in the corresponding `.orm.xml` file:

**File:** `src/{Context}/{Module}/Infrastructure/Resources/config/doctrine/mapping/{Entity}.orm.xml`

```xml
<field name="{fieldName}"/>
```

Doctrine automatically detects the enum type from the PHP property type hint. No explicit `enumType` attribute is needed when the property is properly typed with the enum class.

### Example

For a `Property` entity with a `state` field of type `PropertyState`:

```xml
<entity name="App\Catalog\Property\Domain\Model\Property">
    <id name="id"/>
    <field name="state"/>
    <!-- other fields -->
</entity>
```

## Example Usage

**User:** "Create a PaymentState enum for the Billing/Invoice module with pending, paid, and failed states"

**Response:** Generate file with:
- Context: `Billing`
- Module: `Invoice`
- Enum: `PaymentState`
- Cases: `PENDING`, `PAID`, `FAILED`

```php
<?php

declare(strict_types=1);

namespace App\Billing\Invoice\Domain\Model;

enum PaymentState: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case FAILED = 'failed';

    public function isPending(): bool
    {
        return $this === self::PENDING;
    }

    public function isPaid(): bool
    {
        return $this === self::PAID;
    }

    public function isFailed(): bool
    {
        return $this === self::FAILED;
    }

    public function equals(self $other): bool
    {
        return $this === $other;
    }

    public function canTransitionTo(self $state): bool
    {
        $feasible = match ($this) {
            self::PENDING => [self::PAID, self::FAILED],
            self::PAID, self::FAILED => [],
        };

        return \in_array($state, $feasible, true);
    }
}
```

This creates:
- `src/Billing/Invoice/Domain/Model/PaymentState.php`
