# Laravel API Assignment

## Installation

```bash
composer install

cp .env.example .env

php artisan key:generate

php artisan migrate --seed

php artisan serve

```

## API Base URL

http://127.0.0.1:8000/api

## Endpoints

- GET /api/users
- GET /api/users/{id}
- GET /api/subscriptions
- GET /api/users/{id}/subscriptions
- POST /api/subscriptions/purchase
- GET /api/dashboard/{user_id}

## Repository Pattern

- UserRepository
- SubscriptionRepository
- PaymentRepository

## Postman Collection

Located in:
```bash
postman/Laravel Assignment api test collection.postman_collection.json
```
