# Test task for mintos.com

## Task

Your task is to create simple RSS reader web application with following views:
1) User registration - form with e-mail and password fields + e-mail verification using ajax.
Existence of already registered e-mail should be checked “on the fly” via ajax call when writing e-mail address and before submitting form.
2) Login form with e-mail address and password
3) RSS feed view (Feed source: ​https://www.theregister.co.uk/software/headlines.atom​)
*) After successful login in top section display 10 most frequent words with their respective counts in the whole feed excluding top 50 English common words (taken from here https://en.wikipedia.org/wiki/Most_common_words_in_English​)
*)Underneath create list of feed items. 

## Technologies used:
* PHP 7.2
* MySQL 5.7
* Symfony 4.3 (with Encore)
* React 16.9.0

## Installation
* clone https://github.com/boehpyk/mintos-test.git
* go to the project directory
* run `cp .env.template .env`
* set MySQL connection in `.env` file 
* run `composer install`
* run `yarn install`
* run `php bin/console doctrine:migrations:migrate` to create MySQL tables
* run `php bin/console doctrine:fixtures:load` to load common English words list into database
* run `yarn run build`

On local machine:

* run `php bin/console server:run` 
* go to `http://127.0.0.1:8000`


