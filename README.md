# Implementing MVC Model.

## No frameworks used. Just PHP.

![](https://i.ibb.co/R7R1Mqt/localhost-phptutor-mvcproj.png)

<hr>

In this project except MVC model realized:
- login/signup/recovery password system with email verification
- filtration products by categories and ordering like in stores.

Project uses:
- PHP
- PDO
- Composer
- PSR-7 
- Twig (template engine)
- PHP Documentor
- Phinx (db migrations)
- Bootstrap
- Vue.js
- Axios
- HTML & CSS

Shortly about filesystem.
- **App/** it's a main folder. Contains basic application files.
  - **App/controllers/** - contains controller files.<br>Files with *-Handle-* suffix means that **frontend** sends request to this file and in this file executes logic.<br>Controllers without *-Handle-* suffix just loads desired template and other logic. 
  - **App/kernel/** - contains only one autoload file. 
  - **App/models/** - contains models classes. One class one model.<br> 
  - **App/views/** - contains view class. Loads twig engine
- **db/** folder contains phinx migration and seeding files.
- **docs/api/** folder contains documentation.
- **static/** folder contains front-end files. CSS, JS, Twig templates also.
- **Index.php** - This is the entry point to the app. Loads required files, and routes.7<br>

If you want to run this application in your PC, change your database connection info in **Dbh.php** constructor.

>*This code does not pretend to be the best. And has a lot of places to improve.*
