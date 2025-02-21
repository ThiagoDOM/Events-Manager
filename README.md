
# Events Manager

A system for managing events, which has two types of users: Administrator, who registers events and manages registrations; and User, who views event details, registers for events, and can track payment status (payment gateway not implemented), among other features.


## Installation

Install Events-Manager with Composer and NPM

```bash
  composer install
  npm install
  
  cp .env.example .env
  php artisan key:generate
```
Configure your database and run migrations
```bash
  php artisan migrate --seed
```
## Running

To run on localhost run

```bash
  npm run dev

  php artisan serve
```


## Stack

**Front-end:** Vue.js 3 (Javascript, Node.js ^18.3)

**Back-end:** Laravel 11 (PHP ^8.2)

