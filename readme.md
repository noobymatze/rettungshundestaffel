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
Follow up with cloning the repository, set the root of your chosen server to
the public directory of our application and cd into the directory. Now
adjust the database configuration, and run the following command in the root
directory of the application:

    > php artisan migrate

This command should set up the database nice and clean, so you can visit
[localhost](http://localhost) and start watching around.

The whole project emerged from the required semester project of the applied
computer science bachelors program of the [FH Flensburg](http://www.fh-flensburg.de).

