## Installation

It's necessary to run `composer install`

## Available URLS and HTTPs Methods

| METHODS  | URLS |  ABOUT  | Entrance  | Token |
| ------------- | ------------- | ------------- | ------------- | ------------- |
| POST  | /users  | Create an user | email, password, name | No |
| GET  | /users  | Get all users |  | Yes |
| GET  | /users/:iduser    | Get a specific user |  | Yes |
| PUT  | /users/:iduser  | Get upfate an user | email, name, password | Yes |
| DELETE  | /users/:iduser  | Delete an user |  | Yes |
| POST  | /users/:iduser/drink  | Add quantity a user drink | drink_ml | Yes |
| POST  | /login  | Make login |  email, password | Yes |
| POST  | /logout  | Make logout |  | Yes |
| GET  | /water_quantity/:iduser  | Get history of user |  | Yes |
| GET  | /ranking  | Get ranking of users |  | Yes |


In Header send `Authorization {$token}`
