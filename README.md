# test_technique
To run this project after cloning on your computer please follow the following steps.

1 : cd test_technique

2 : run `docker-compose up --build`

3 : run `docker exec -it test_technique_php-fpm_1 php bin/console make:migration`

4 : run `docker exec -it test_technique_php-fpm_1 php bin/console doctrine:migrations:migrate`

5 : open localhost in your browser

6 : adminer : localhost:8080 :

                    - server : database

                    - user : root

                    - password : root

                    - database : test_technique
