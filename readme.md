Welcome in my project BileMo API !
==
What is it ?
-
I am student at Openclassrooms and the 7th project is making an API REST to a client who wants to sell phone which are in our database.  
With this project, the client can get phone informations, create, get and delete users.  
He could also manage his customers and their informations with this API.  

What it contains ?
-
You can find in this repository a Symfony 5 skeleton structure with only the bundles require to make the API fonctionnal.  
This project contains phones and users fixtures to test the API, entities, controllers and an ExceptionListener to return a valid response in json if an exception is thrown.  

Documentation
-
You can find the documentation in these links :  
Documentation [Json](http://127.0.0.1:8000/api/doc.json "Link to doc in json")  
Documentation [HTML](http://127.0.0.1:8000/api/doc "Link to doc in html")

What do I need ? - Prerequisite
-
You must have installed at least :  
- PHP 8.0.10
- Symfony 5.3.0
- Composer
- A software like Postman to test the API

How to install the project
-
1) Clone or download this repository, create a new folder "BileMo" and place the projet in it.

2) Run `composer install` in command in the folder "BileMo".

3) Create a new database : change the value of DATABASE_URL in the file .env to match with your database parameters.

4) Run `symfony console doctrine:database:create` in command to create your database.
   
5) Run `symfony console doctrine:migrations:migrate` to apply all migrations files.

6) Generate user and phone fixtures with the command `symfony console doctrine:fixtures:load`.

Code Climate analysis
-
[![Maintainability](https://api.codeclimate.com/v1/badges/7881c04d4df0a4554aeb/maintainability)](https://codeclimate.com/github/FloryssRu/BileMo-API/maintainability "Analysis by CodeClimate")