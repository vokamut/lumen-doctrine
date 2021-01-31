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
