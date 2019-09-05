# Test task for mintos.com 

Technologies used:
* PHP 7.2
* MySQL 5.7
* Symfony 4.3 (with Encore)
* React 16.9.0

## Installation
* clone https://github.com/boehpyk/mintos-test.git
* go to the project directory
* run `composer install`
* run `yarn install`
* set MySQL connection in `.env` file
* run `php bin/console doctrine:migrations:migrate` to create MySQL tables
* run `php bin/console doctrine:fixtures:load` to load common English words list into database
* run `yarn run build`

On local machine:

* run `php bin/console server:run` 
* go to `http://127.0.0.1:8000`


