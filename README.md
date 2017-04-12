# Chat RESTful API

Chat RESTful API was developed using laravel 5.4

## How To Use

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

Clone the code into your local machine and execute the following commands:

- Create .env file with your environment configuration including App Configurations and Database Connection
- Create a database named as you want for example "chat"
- Run "php artisan migration" command on terminal to create initial database structure
- Run "php artisan db:seed" command on terminal to create initial user on database
```
    'email' => 'admin@api.com'
    'password' => '123456'
```

## API Structure

All tokens provided by the API are using an implementation of JWT (JSON web token)

The current endpoints avaiable are:

### Auth

- Login
```
    This endpoint should return a JWT token as an Authorization header

    Endpoint:  [POST] http://localhost:[port]/api/auth/login
    Request:
        email    [required][attribute] string
        password [required][attribute] string
    Response:
        Authorization Token on Header
        Body

```

- Logout
```
    This endpoint should invalidate the JWT token

    Endpoint:  [GET] http://localhost:[port]/api/auth/logout    
    Request:
        Authorization Token on Header
    Response:       
        Body
```

### Users

- Create
```
    This endpoint allows users to register

    Endpoint:  [POST] http://localhost:8000/api/users
    Request:
        Authorization Token on Header
        name                  [required][attribute] string
        email                 [required][attribute] string
        password              [required][attribute] string
        password_confirmation [required][attribute] string
    Response:       
        Body    
```

### Current User

- Read
```
    This allows a user to view their own profile

    Endpoint:  [GET] http://localhost:[port]/api/users/current
    Request:
        Authorization Token on Header       
    Response:       
        Body

```

- Update
```
    This allows a user to update their own profile

    Endpoint:  [PATCH] http://localhost:[port]/api/users/current
    Request:
        Authorization Token on Header
        name                  [required][attribute] string
        email                 [required][attribute] string
        password              [required][attribute] string
        password_confirmation [required][attribute] string
    Response:       
        Body
```

### Chats

- List
```
    This endpoint allows a user to view a paginated list of all chats. Each chat have a list of users who have chatted and the last message of the chat.

    Endpoint:  [GET] http://localhost:[port]/api/chats?page=1&limit=50
    Request:
        Authorization Token on Header
        page    [required][parameter] number
        limit   [required][parameter] number
    Response:       
        Body

```

- Create
```
    This endpoint allows a user to create a chat and post the first message

    Endpoint:  [POST] http://localhost:[port]/api/chats
    Request:
        Authorization Token on Header
        name    [required][attribute] string
        message [required][attribute] string
    Response:       
        Body
```

- Update
```
    This endpoint allows the user to update a chat that they created. It throws an error if a user tries to update a chat that they have not created.

    Endpoint:  [PATCH] http://localhost:[port]/api/chats/{id}
    Request:
        Authorization Token on Header
        id    [required][parameter] number
        name  [required][attribute] string
    Response:       
        Body

```

### Chat Messages

- List
```
    This endpoint allows a user to view a paginated list of chat messages.The order of the message pagination should be DESC by the date they were created.

    Endpoint:  [GET] http://localhost:[port]/api/chats/{id}/chat_messages?page=1&limit=50
    Request:
        Authorization Token on Header
        id      [required][parameter] number
        page    [required][parameter] number
        limit   [required][parameter] number
    Response:
        Body

```

- Create
```
    This endpoint allows a user to create a new message in a chat.

    Endpoint:  [POST] http://localhost:[port]/api/chats/{1}/chat_messages
    Request:
        Authorization Token on Header
        id      [required][parameter] number
        message [required][attribute] string
    Response:       
        Body
```

## Security Vulnerabilities

If you discover a security vulnerability, please send an e-mail to José Roldán at dev.josers@gmail.com. All security vulnerabilities will be promptly addressed.

## License

The Chat API is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
