# Contributing

Thanks for wanting to help! This document explains the contribution workflow and how to run tests and tools locally.

## Getting started

1. Fork the repository and create a branch per feature/fix.
2. Run composer to install dev dependencies:
   ```
   composer install
   ```

## Running tests

- Run unit tests:
  ```
  composer test
  ```
  or
  ```
  vendor/bin/phpunit
  ```

- Run static analysis:
  ```
  composer run analyse
  ```

- Run code style fixes (if enabled):
  ```
  composer run cs
  ```

## Coding standards

- Follow PSR-12 coding style.
- Use `declare(strict_types=1);` in PHP files.
- Add type hints and return types to public APIs.
- Add tests for all bug fixes and new features.

## Pull request process

- Ensure tests pass locally.
- Rebase on the latest main before creating PR.
- Provide a clear description of the change and reference related issues.

## Issue & PR templates

Please add useful context, reproducible steps, and tests where applicable.