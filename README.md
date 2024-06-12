## Installation

- Run composer install
- Set DB credentials in .env file
- Run migrations `php artisan migrate`
- Run web server `php artisan serve`
- Run Queue Worker  `php artisan queue:work`



## Test endpoint example

- Run curl request `curl -X POST http://127.0.0.1:8000/api/submit \
  -H "Content-Type: application/json" \
  -d '{
  "name": "Test name",
  "email": "email@example.com",
  "message": "This is a test message."
  }'`

## Run unit tests

- `php artisan test`
