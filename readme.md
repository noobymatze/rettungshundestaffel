# Rescue dog squad

The goal of this project is to provide a small web application for
centralization of decentralized communication information of the members of dog squads. 
The project will be developed in close cooperation with a specific squad, 
as to get a feel for the problems they face in the communication of training
dates and other information. This is to tie the design to the needs of the
squad and have them be happy campers, when the project reaches its 1.0
release.

To get started with the project, you need a PHP server and either
[MySQL](http://www.mysql.com) or [MariaDB](https://mariadb.org). 
Also you will need to install [Composer](https://getcomposer.org/), which 
is a dependency manager for PHP and is used by [Laravel](http://laravel.com/), 
which the application is built upon.

Now clone the directory and cd into it via the command line. Run

    > composer install

which will install all the dependencies needed for the application.

Now adjust the database configuration, to be found in app/config/database.php, 
and run the following command in the root directory of the application:

    > php artisan migrate

This command should set up the database nice and clean, so you can visit
[localhost](http://localhost) and start watching around.

The whole project emerged from the required semesters project of the applied
computer science bachelors program of the [FH Flensburg](http://www.fh-flensburg.de).

