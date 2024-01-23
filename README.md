# Restaurant Reservation

## Features

- Automated Table Selection: The system dynamically assigns tables based on availability, optimizing seating arrangements for an efficient use of restaurant space.
- Timeslot Booking: Customers can book reservations during available timeslots, ensuring a balanced distribution of guests throughout the dining hours.

## Development Setup

How to run the app on your local:

1. Create a new database on your local machine
2. Copy .env.example and rename to .env
3. Set up the databse connection in .env file
4. Run `composer install`
5. Run `php artisan key:generate`
6. Run `php artisan migrate`
7. Run `php artisan db:seed`
8. Run `php artisan serve` to run the app

## Login staff

- url: http://localhost:8000/login
- email: email: staff@example.com
- pass: password

## API documentation

Run `php artisan l5-swagger:generate` to generate the documentation.
API documentation is using swagger and can be accessed at [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

## Unit Tests

1. Create a new database for testing on your local machine
2. Set up the test databse connection in .env.testing file
3. Run `./vendor/bin/pest` to run the test

