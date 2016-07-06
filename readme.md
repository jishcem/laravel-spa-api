# Laravel API built for Single Page Applications.

This is a Laravel API boilerplate for kickstarting the developement.

  - Only intended for API - I have not written any other routes
  - Uses Dingo for API https://github.com/dingo/api
  - Uses JWT for token based authentication https://github.com/tymondesigns/jwt-auth

Requirements:
    Any laravel developement envirornment

Insallation:

```sh
$ git clone https://github.com/jishcem/laravel-spa-api.git
$ cd laravel-spa-api.git
$ composer install
```

Create a `.env` file in the project root. And copy the contents of the `.env-example` to the newly created file.

I preffered using mysql in this, if you want to follow the same,
Create a new database, and assign the database credentials and name to the DB_DATABASE, DB_USERNAME, DB_PASSWORD

If you want to see the emails in action, sign up for https://mailtrap.io/ and get the smtp credentials from the inbox page of mailtrap. And also update the MAIL_USERNAME and MAIL_PASSWORD

Now run these commands in the project root,

```sh
$ php artisan key:generate
$ php artisan migrate
```

Assuming you start the web server and have the URL http://laravel-spa-api.dev working, you are ready with the API.

If you go to the the url http://laravel-spa-api.dev/api/task and see

```json
{"error":"token_not_provided"}
```

We have finished setting up the API.


