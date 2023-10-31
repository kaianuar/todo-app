 Todo API

Todo API
========

Table of Contents
-----------------

*   [Installation](#installation)
*   [Usage](#usage)
*   [Sail Commands](#sail-commands)
*   [API Documentation](#api-documentation)
    *   [Get All Todos](#get-all-todos)
    *   [Update Todo Status](#update-todo-status)

Installation
------------

To get started, first install the project dependencies:

    composer install

Then, start the Sail development server:

    ./vendor/bin/sail up

Usage
-----

You can perform various operations through the API, such as getting all todos or updating a todo status.

Sail Commands
-------------

To migrate the database:

    ./vendor/bin/sail artisan migrate

To seed data:

    ./vendor/bin/sail artisan db:seed

To run tests:

    ./vendor/bin/sail test

### Working with Queues

The application uses Laravel Queues for asynchronous tasks. Therefore, you'll need to start a queue worker. To do so, run:

    ./vendor/bin/sail artisan queue:work

### Update All Todo Statuses

The command to update all todo statuses relies on Laravel Queues. Ensure your queue worker is running before executing this command:

    ./vendor/bin/sail artisan todos:updateStatus

API Documentation
-----------------

### Get All Todos

#### Endpoint

    GET /api/v1/todos?page={page}&perPage={perPage}

#### Parameters

*   `page`: The page number (optional, default is 1)
*   `perPage`: Number of todos per page (optional, default is 15)

#### Response

    {
      "data": [...],
      "meta": {...},
      "links": {...}
    }

### Update Todo Status

#### Endpoint

    PATCH /api/v1/todos/{id}

#### Parameters

*   `id`: The Todo ID

#### Request Body

    {
      "status": "done"
    }

#### Response

    {
      "data": {
        "id": ...,
        "title": ...,
        "description": ...,
        "status": ...
      }
    }