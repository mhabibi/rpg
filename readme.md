# Text-based RPG game
It is a text-based role-playing game that provides a command-line interface and a RESTful API to play.
Firstly, you should create a new character, a character is identified with a name which is unique.
After that, you enter the game and start playing. In each section of the game, you are given a number of options to choose.
When you choose an option, you enter the next section of the story.

In each state, you can collect or lose GOLD coins. Number of coins is shown to you in each state.
When you move forward from one state to another, your status is automatically saved.
 
### How to play in command line
After setting up the application, run `php artisan play`, you will be asked if you continue the game or you enter as a new character. For the first time enter "no" and then enter your unique name. After that the fist step of the game will be shown to you.

in each state, if you have some options to continue the story, a list will be shown, to select one of them, type the number in front of the title which is printed inside [] and then press Enter.

In any states, press `Ctrl+C` to save the game and exit.

### How to play via webservice API
In project root directory run `php -S localhost:8000 -t public` to start the web server.

First, create a user, sample HTTP request:
```
curl -X POST -H "Content-Type: application/json" -d '{"name":"your_name_here"}' "http://localhost:8000/v1/character"
```
Response codes:
- 201 created
- 406 name already exists
- 422 validation error

Get the current status for a character:
```
curl -X GET -H "Content-Type: application/json" "http://localhost:8000/v1/your_name_here"
```
If it can not find the name you will get a 404 status code. Otherwise 200 and a response json body.

Response body sample:
```
{"character":"your_name_here","stock":0,"title":"current status title","description":"description","options":{"2":"next state title"}}
```
Notice the `options` field. You should select one id(shown on the left of each option) and send it with the next request


Move:
```
curl -X PUT -H "Content-Type: application/json" -d '{"id":2}' "http://localhost:8000/v1/your_name_here"
```
2 here is selected option id. If you have moved successfully, you will get 200 status code and a body an newly 
updated status of the character.

Other response codes:
- 404 name not found
- 400 selected id is wrong

# Requirements
- PHP >= 7
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- SQLite (sqlite3 and libsqlite3-dev)
- SQLite3 PHP Extension(php7.0-sqlite3)
- Memcached
- Memcached PHP Extension(php-memcached)

# Install
- Create a DB: `touch /path/to/database.sqlite`
- Set ENV variables:
```
DB_CONNECTION=sqlite
DB_DATABASE=/path/to/database.sqlite
```
- Run seeders: `php artisan db:seed`
_ Install packages: `composer install`

## Test
```
phpunit
```


## It can be improved by
- Using docker in order to build faster on any devices and get rid of long install processes
- Using swagger to document the Http API
- A functional test for API and command line interface
- An API to develop the story or stories
- Adding more stories instead of just one story(can be also used as different sections of one story).
- Adding more properties rather than just one(GOLD)
- Adding different classes for characters with different properties, such as spirit, health, etc.

## License

This is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)