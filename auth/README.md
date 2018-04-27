auth  Tasos Adamopoulos
====

.::Author : Tasos Adamopoulos

.::Description : 

	Build a Symfony PHP project that we can run on a local domain, and has the following specifications

	• it must use Symfony and Doctrine

	• there are users and api keys stored in mysql tables

	• every time a user makes a call, the call details are logged in a table called Log

	• given an api key that belongs to user 1, we can make a call (e.g. with Postman) to /user/1 
	and get a JSON back with the user 1 details. API key can be inserted in a header or in a cookie.

	• users should only be able to access their own user with their key. All attempts to access 
	another user return an error

	• All errors are handled nicely. e.g. wrong api key, no api key, non existing users, non 
	existing resources

	That's all. You can also include a setup SQL (that includes users 1 and 2 and keys) 
	and some instructions of how to set up.


.::Info
	
	This symfony app is simple User Authentication JSON Endpoint . A user can make a call 
	through postman or curl . An API key should exist at requests header as 'user info'  .
	App has been tested with curl through a bash script (client calls tested on MacOSX 11.11.04).
	You can find Server's specs bellow :

.::System Specs:

	Linux   : ARCH 2017 
	Apache  : 2.4.25
	MySQL   : 10.1.24-MariaDB 
	PHP     : 7.1.6 

	Symfony : 3.3.2

.::User / API key pairs:

	Assume that 2 users are stored in our system , (1) George Best and (2) Michael Schumacher
	Every user has an API key that has to be included at calls header .

user 1 / b48d0416-bc38-467d-8066-cd14bb7ead5e
user 2 / b71fe516-efc2-479f-a986-4c58ae7b2ea8


.::SQL CODE : 

	-Our app's DB configuartion :

	database php driver : mysqli -( MODULE SHOULD BE ACTIVATED AT php.ini ! )
	database host: 127.0.0.1
    database port: null
    database name: authentication
    database user: auth
    database password: 123456


    -The following MySQL code should be executed to create the DB we need :


	CREATE DATABASE authentication;

	USE authentication;

	CREATE USER 'auth'@'localhost' IDENTIFIED BY '123456';

	GRANT ALL PRIVILEGES ON authentication . * TO 'auth'@'localhost';

	CREATE TABLE log (id INT AUTO_INCREMENT NOT NULL,
					 userid INT NOT NULL, 
					 success TINYINT(1) NOT NULL, 
					 info VARCHAR(255) NOT NULL,
					 created_at DATETIME NOT NULL, 
					 PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

	CREATE TABLE user_details (id INT AUTO_INCREMENT NOT NULL, 
							   name VARCHAR(255) NOT NULL, 
							   last_name VARCHAR(255) NOT NULL, 
							   created_at DATETIME NOT NULL, 
							   PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

	CREATE TABLE secret (id INT AUTO_INCREMENT NOT NULL, 
						 userid INT NOT NULL, 
						 apikey VARCHAR(40) NOT NULL, 
						 UNIQUE INDEX UNIQ_5CA2E8E5F132696E (userid), 
						 UNIQUE INDEX UNIQ_5CA2E8E5B84757A1 (apikey), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;


	INSERT INTO user_details (name,last_name,created_at) VALUES ('George','Best',NOW());

	INSERT INTO user_details (name,last_name,created_at) VALUES ('Michael','Schumacher',NOW());

	INSERT INTO  secret(userid,apikey) VALUES ('1','b48d0416-bc38-467d-8066-cd14bb7ead5e');

	INSERT INTO  secret(userid,apikey) VALUES ('2','b71fe516-efc2-479f-a986-4c58ae7b2ea8');


	-Our DataBase should look like this :

	SHOW TABLES;

	+--------------------------+
	| Tables_in_authentication |
	+--------------------------+
	| log                      |
	| secret                   |
	| user_details             |
	+--------------------------+

	SELECT * FROM log;

	Empty set (0.00 sec)



	SELECT * FROM secret;

	+----+--------+--------------------------------------+
	| id | userid | apikey                               |
	+----+--------+--------------------------------------+
	|  1 |      1 | b48d0416-bc38-467d-8066-cd14bb7ead5e |
	|  2 |      2 | b71fe516-efc2-479f-a986-4c58ae7b2ea8 |
	+----+--------+--------------------------------------+


	SELECT * FROM user_details;

	+----+---------+------------+---------------------+
	| id | name    | last_name  | created_at          |
	+----+---------+------------+---------------------+
	|  1 | George  | Best       | 2017-06-29 20:20:37 |
	|  2 | Michael | Schumacher | 2017-06-29 20:20:57 |
	+----+---------+------------+---------------------+


.::Execution and Deployment Tutorial

	At current time app is at Development mode and our service could be accessed through auth/web/app_dev.php
	For security reasons servers and clients ip should be stored as "trusted" at auth/web/app_dev.php @ line 15
	by default .

	To turn to Production mode you can follow this tutorial : https://symfony.com/doc/current/deployment.html

	To make a call using curl :

	curl <URL: xxx/auth/web/app_dev.php/user/{id}> -u <API KEY>:

	Our service responds with a JSON that contains ERROR messages if credentials does not match or users
	details if authenticated successfully . For more info about service's response : test/test.txt

.::TEST CALLS :

	I used curl to test the service in an automated way (bash script)

	curl 192.168.1.55/symfony/auth/auth/web/app_dev.php/user/1
	curl 192.168.1.55/symfony/auth/auth/web/app_dev.php/user/2
	curl 192.168.1.55/symfony/auth/auth/web/app_dev.php/user/5
	curl 192.168.1.55/symfony/auth/auth/web/app_dev.php/user/1 -u b48d0416-bc38-467d-8066-cd14bb7ead5e:
	curl 192.168.1.55/symfony/auth/auth/web/app_dev.php/user/2 -u b48d0416-bc38-467d-8066-cd14bb7ead5e:
	curl 192.168.1.55/symfony/auth/auth/web/app_dev.php/user/5 -u b48d0416-bc38-467d-8066-cd14bb7ead5e:
	curl 192.168.1.55/symfony/auth/auth/web/app_dev.php/user/1 -u b71fe516-efc2-479f-a986-4c58ae7b2ea8:
	curl 192.168.1.55/symfony/auth/auth/web/app_dev.php/user/2 -u b71fe516-efc2-479f-a986-4c58ae7b2ea8:
	curl 192.168.1.55/symfony/auth/auth/web/app_dev.php/user/5 -u b71fe516-efc2-479f-a986-4c58ae7b2ea8:


	- automated test could be found at test/test.sh

	- test results could be found at test/test.txt


.::Tutorials that I used :
	
	Symfony and HTTP Fundamentals
	https://symfony.com/doc/current/introduction/http_fundamentals.html

	Controller
	https://symfony.com/doc/current/controller.html

	Place API key in Headers or URL
	https://stackoverflow.com/questions/5517281/place-api-key-in-headers-or-url

	Doctrine
	https://symfony.com/doc/current/doctrine.html







