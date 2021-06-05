<!-- <p align="center"><img src="#" width="100" height="98"></p> -->

## About Book Rating API

This API is built with the **Laravel Framework:**.
-   API Live url: **(https://protected-sands-80968.herokuapp.com/api/book-rating/v1.0/)**
-   API Documentation url: **(http://protected-sands-80968.herokuapp.com/api/docs)**

## Cloning the project

To clone the project, simply click on this link: [My Book Rating API &rarr;](https://github.com/absyinka/bookRating):

-   Click the **Code** button on the github page
-   From the flyout menu Copy the **HTTPS** link.
-   Go to the application folder using **cd** command on your **cmd** or terminal: **git clone https://github.com/absyinka/bookRating**
-   Run **composer install** on your cmd or terminal
-   Copy the **.env.example** file to **.env** on the root folder. You can type **copy .env.example .env** if using Windows command prompt or **cp .env.example .env** if using Powershell terminal.
-   Open your **.env** file and change the following: DB_DATABASE, DB_USERNAME and DB_PASSWORD field to match your local configuration.
-   Run **php artisan key:generate**
-   Run **php artisan jwt:secret** to generate the JWT secret key for the project
-   Run **php artisan migrate**
-   Run **php artisan serve**
-   Go to localhost:8000 or 127.0.0.1:8000

## Thank you
