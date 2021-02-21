# test_technique
To run this project after cloning on your computer please follow the following steps.

1 : cd test_technique

2 : configure the .env file with your own database informations

3 : run `composer install`

4 : run `php bin/console doctrine:database:create`

5 : run `php bin/console make:migration`

6 : run `php bin/console doctrine:migrations:migrate`

7 : run `symfony server:start`
