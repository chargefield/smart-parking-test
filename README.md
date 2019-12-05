# Smart Parking Test (Laravel)

A test project in [Laravel](https://laravel.com) for managing customer in a parking garage.

## The Scenario

A company has hired us to build an application to manage customers using their parking garage. The app is accessed from a web browser.

The customer must be able to enter the parking garage with their vehicle and be issued a ticket.

The customer is then charged for parking based on the length of their stay. When the customer leaves the parking garage, they must pay their ticket and then exit.

### Constraints

A customer arriving in their vehicle is able to request entry to the parking garage

-   If there is space available, a ticket is issued to the customer

The customer is able to pay their ticket based on the length of their stay

-   Use 1hr, 3hr, 6hr, or ALL DAY for rate levels

-   The price increases by 50% for each rate level

-   The starting rate is \$3 for 1hr

When a customer is on their way out of the garage, check that their ticket is paid/valid e. Otherwise, deny their exit

If the parking garage is full, deny entry to that customer.

## Installation

Fork or download this repository:

```
git@github.com:chargefield/smart-parking-test.git
```

In the terminal, `cd` into the folder and use [composer](https://getcomposer.org) to install the default [Laravel](https://laravel.com) packages:

```bash
composer install
```

_Note: You might need to duplicate the `.env.example` file and name it `.env`. Fill out any important values to get the application up and running._

### Database Setup

Create a database and update the `.env` file with the correct values.

**Example:**

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=secret
```

### Migrate Database

```bash
php artisan migrate:fresh
```

### Compiling Assets

For the front end to work, you'll need to run:

```bash
yarn install && yarn run dev
```

or

```bash
npm install && npm run dev
```

## Usage

### Defaults

There are some defaults to help get you started in `app/Providers/ParkingServiceProvider.php`.

```php
// add(duration in hours, amount in cents)
// max(amount in cents) duration is 24 hours
Rates::add(1, 300)
    ->add(3, 450)
    ->add(6, 675)
    ->max(1015);

// Defaults to 10 spaces
Parking::setTotalSpaces(10);

// Defaults to 15 minutes
Parking::setTicketExpiredDelay(15);
```

_You can add or change these values._

### Artisan Command

```bash
php artisan tickets:unpaid
```

and

```bash
php artisan tickets:paid
```

These are helper commands that will output a list of tickets, you can use the ticket codes to test out the app.

## Testing

You can run the tests with:

```bash
vendor/bin/phpunit
```
