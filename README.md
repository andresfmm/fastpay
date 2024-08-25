<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Project

 This project is a test of work for backend developer position, The purpose of this technical test is to assess your PHP development skills, specifically using the Laravel framework, as well as your skills in good programming practices, API design, and security. You will be challenged to create a simple API for a payment system.

 ## Requeriments
1. php version  8.1 or major
2. [Composer](https://getcomposer.org/)
3. docker (optional)
3. mysql (db) 
5. phpmyadmin (recomended)
6. postman (recomended)
7. git
8. git flow (recomended)

## Install Project
for install the project run the next commands

##### Clone project
```bash
 git clone https://github.com/andresfmm/fastpay.git
 ```

 ##### Install dependencies
```bash
 composer install
 ```
 
 ## Enviroment
 in the file .env.encrypted is the configuration for connection db and others keys configuration.

 ##### Decrypt file
```bash
 php php artisan env:decrypt --key=your-here
 ```
 


## Database
 >**Note**  you can use docker compose for run the database but this is **optional** or you can use phpmyadmin or laragon feel free use your choose

 ## With Docker
 laravel has several options for docker but in this case and simplicity we are going to use the file docker-compose.yml

 **first** create volume  **db_data** or change it's name in docker-compose.yml file. feel free put it inside .env


##### Intall images and up container
 ```bash
 docker compose up
 ```

## Without Docker
  if you don't use docker configure normal

##### run the migrations
 ```bash
 php artisan run migrations
 ```

##### run seeders
 ```bash
 php artisan db:seed
 ```

 after run sedders create 3 users 

 **user 1**
 email: test1@example.com
 password: 123

 **user 2**
 email: test2@example.com
 password: 456

 **user 3**
 email: test3@example.com
 password: 789



## Table codes response


| code    | Description                                          
|-------- | ---------------------------------------------------- 
|PS-01    | Proccess was complete.    
|PS-02    | Proccess was complete but data not found.            
|PS-03    | Proccess was complete but the payment already proccessed.     
|PS-04    | Unauthenticated.             
|PS-05    | Authorization Token not found or invalid.                       
|PS-06    | Some  data is misión or nvalid.           
|ES-07    | Error internal serve.      

 ##### command for run project
```bash
 php artisan serve
```

 ## Test Api
 import the collections located in folder postman in root of project, in this file you will find 3 collection payments, users and enviroment, all is configure to use automatic when loggin get the token and put un header same witl id after create payment you don't need configure any thing


 ## Unit Tests
 the test are located in folder test inside root project, in this case we are using test type feature file call **PaymentTest.php** located inside ``test/Feature`` for run the test use the command on console inside the project.
 >**IMPORTANT**
  this routes are protected by **jwt** so for test you need be logued with seeders by default the user is test1@example.com
  you change in .env file with name USER_TEST_UNIT='test1@example.com'

```bash
 php artisan test --testsuite=Feature --stop-on-failure
```

or  
```bash
 ./vendor/bin/phpunit
```



## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


## Congratulations! :tada:

You've successfully run the project. :partying_face:

 


Made  with 🧠 and ❤️ by Andres meza amezadeveloper@gmail.com or 
andres230687@hotmail.com
