# Vibes

[![CircleCI](https://circleci.com/gh/chadwalt/Vibes.svg?style=svg)](https://circleci.com/gh/chadwalt/Vibes)
[![Maintainability](https://api.codeclimate.com/v1/badges/ac742319b528f6728271/maintainability)](https://codeclimate.com/github/chadwalt/Vibes/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/ac742319b528f6728271/test_coverage)](https://codeclimate.com/github/chadwalt/Vibes/test_coverage)

Vibes is a Music Store Application API that will bring an upcoming artiste to the limelight. The application is built on top of the lumen framework.

## Installation Requirements

For the Vibes application to fully function the following requirements need to be installed:-

- Composer
- PHP
- Postgres

## Serving the Application

To serve the application, php has a built in development server which can be started by running this command.

```
php -S localhost:8000 -t public
```

## Configuration

All configuration for the lumen framework can be done in the `.env` file. A sample `.env.example` has been included in the repo. This has to be renamed to `.env`.

## Running Tests

To run all tests in the application run this command.

```
vendor/bin/phpunit
```

## License

The Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
