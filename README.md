<p align="center">
<a href="https://github.styleci.io/repos/332420872"><img src="https://github.styleci.io/repos/332420872/shield?branch=master" alt="StyleCI"></a>
<a href="https://travis-ci.org/vokamut/lumen-doctrine"><img src="https://travis-ci.org/vokamut/lumen-doctrine.svg?branch=master" alt="Build Status"></a>
<a href="https://phpstan.org/"><img src="https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat" alt="PHPStan Enabled"></a>
<a href="https://psalm.dev/"><img src="https://img.shields.io/badge/Psalm-enabled-brightgreen.svg?style=flat" alt="Psalm Enabled"></a>
</p>

# Lumen PHP Framework with Doctrine ORM

## Install

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan doctrine:schema:create
```

## Run

```bash
php -S localhost:8000 -t public
```

## Requests

```bash
# Get all customers
curl http://localhost:8000/customers

# Get a customer with id = 1 
curl http://localhost:8000/customers/1
```

## Commands

```bash
# Import 100 customers
php artisan import:customers:from:randomuser
```

## Tests

```bash
./vendor/bin/phpunit
```
