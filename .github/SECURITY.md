# Security Policy

## Supported Versions

We actively support the following versions of `laravel-wasl` with security updates:

| Version | Supported          |
| ------- | ------------------ |
| 1.0.x   | :white_check_mark: |
| < 1.0   | :x:                |

## Reporting a Vulnerability

We take the security of `laravel-wasl` seriously. If you believe you have found a security vulnerability, please report it to us as described below.

### Please do NOT:

- Open a public GitHub issue
- Discuss the vulnerability publicly
- Share the vulnerability with others until it has been resolved

### Please DO:

1. **Email us directly** at: mohamedhabibwork@gmail.com
2. Include the following information:
   - Type of vulnerability
   - Full paths of source file(s) related to the vulnerability
   - The location of the affected source code (tag/branch/commit or direct URL)
   - Step-by-step instructions to reproduce the issue
   - Proof-of-concept or exploit code (if possible)
   - Impact of the vulnerability, including how an attacker might exploit it

### What to Expect:

- **Acknowledgment**: We will acknowledge receipt of your report within 48 hours
- **Initial Assessment**: We will provide an initial assessment within 7 days
- **Updates**: We will keep you informed of our progress every 7-10 days
- **Resolution**: We will work to resolve the issue as quickly as possible

### Disclosure Policy

- We will credit you for the discovery (unless you prefer to remain anonymous)
- We will coordinate public disclosure with you
- We will not take legal action against security researchers acting in good faith

## Security Best Practices

When using this package:

1. **Keep your dependencies updated**: Regularly update `laravel-wasl` to the latest version
2. **Protect your credentials**: Never commit your Wasl API credentials to version control
3. **Use environment variables**: Store sensitive configuration in `.env` files
4. **Validate input**: Always validate user input before passing it to the package
5. **Use HTTPS**: Ensure all API communications use HTTPS
6. **Monitor logs**: Regularly review application logs for suspicious activity

## Known Security Considerations

- This package handles sensitive API credentials - ensure proper environment variable management
- API responses may contain personal information - handle with appropriate data protection measures
- Rate limiting should be implemented at the application level to prevent abuse

## Security Updates

Security updates will be released as patch versions (e.g., 1.0.1, 1.0.2) and will be documented in the [CHANGELOG](CHANGELOG.md).

Thank you for helping keep `laravel-wasl` and its users safe!

