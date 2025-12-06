# Contributing to Laravel Wasl

First off, thank you for considering contributing to Laravel Wasl! It's people like you that make Laravel Wasl such a great package.

## Code of Conduct

This project adheres to a Code of Conduct that all contributors are expected to follow. Please read [CODE_OF_CONDUCT.md](.github/CODE_OF_CONDUCT.md) before contributing.

## How Can I Contribute?

### Reporting Bugs

Before creating bug reports, please check the issue list as you might find out that you don't need to create one. When you are creating a bug report, please include as many details as possible:

- **Use a clear and descriptive title**
- **Describe the exact steps to reproduce the problem**
- **Provide specific examples to demonstrate the steps**
- **Describe the behavior you observed after following the steps**
- **Explain which behavior you expected to see instead and why**
- **Include screenshots and animated GIFs if applicable**
- **Include the package version, PHP version, and Laravel version**

### Suggesting Enhancements

Enhancement suggestions are tracked as GitHub issues. When creating an enhancement suggestion, please include:

- **Use a clear and descriptive title**
- **Provide a step-by-step description of the suggested enhancement**
- **Provide specific examples to demonstrate the steps**
- **Describe the current behavior and explain which behavior you expected to see instead**
- **Explain why this enhancement would be useful**

### Pull Requests

- Fill in the required template
- Do not include issue numbers in the PR title
- Include screenshots and animated GIFs in your pull request whenever possible
- Follow the PHP and Laravel coding standards
- Include thoughtfully-worded, well-structured tests
- Document new code based on the Documentation Styleguide
- End all files with a newline

## Development Process

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Make your changes
4. Ensure all tests pass (`composer test`)
5. Ensure code style is correct (`composer format`)
6. Ensure static analysis passes (`composer analyse`)
7. Commit your changes (`git commit -m 'Add some amazing feature'`)
8. Push to the branch (`git push origin feature/amazing-feature`)
9. Open a Pull Request

## Coding Standards

This package follows the [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standard and Laravel's coding conventions.

### PHP 8.3+ Features

We use modern PHP 8.3+ features:

- Strict typing (`declare(strict_types=1)`)
- Readonly properties where applicable
- Typed properties
- Enums for finite states
- Constructor property promotion

### Code Style

We use [Laravel Pint](https://laravel.com/docs/pint) for code formatting:

```bash
composer format
```

### Static Analysis

We use [PHPStan](https://phpstan.org/) for static analysis:

```bash
composer analyse
```

## Testing

- Write tests for new features
- Ensure all existing tests pass
- Aim for high test coverage

Run tests with:

```bash
composer test
```

## Documentation

- Update the README.md if needed
- Add PHPDoc comments for new classes and methods
- Update the CHANGELOG.md for user-facing changes
- Keep code comments clear and concise

## Commit Messages

- Use the present tense ("Add feature" not "Added feature")
- Use the imperative mood ("Move cursor to..." not "Moves cursor to...")
- Limit the first line to 72 characters or less
- Reference issues and pull requests liberally after the first line

## Questions?

Feel free to open an issue for any questions you might have.

Thank you for contributing to Laravel Wasl! 🎉

