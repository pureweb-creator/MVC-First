# Apply the MVC model using OOP PHP

![](https://i.ibb.co/0ZDp5Lr/Screenshot-46.png)

<hr>

This mini app has
- signup system with email verification (signup,login,recovery)
- filtering goods like in stores.
- basket system

Project uses:
- PHP
- Twig (template engine)
- Phinx (db migrations)
- MVC,OOP,PDO
- JS, Vue.js, Axios.js, jQuery
- Bootstrap, HTML, SCSS, Gulp

Shortly about filesystem.
- **App/** it's a main folder. Contains basic application files.
  - **App/controllers/** - contains controllers.
  <br>Files in the root are including in index.php, useful for routing, and renders templates.
  - **App/controllers/classes/** - basic classes that contains all logic in their methods.
  - **App/controllers/inc/** - Files in this folder handles requests from Frontend.
  - **App/controllers/traits/** - Traits.
  - **App/kernel/** - contains autoload and config files.
  - **App/models/** - contains models classes. One class is one model. 
  - **App/views/** - contains view class. Loads twig engine
- **db/** folder contains phinx migration and seeding files.
- **docs/api/** folder contains documentation.
- **static/** folder contains front-end static files. SCSS, CSS, JS, Twig templates also.
- **Index.php** - This is the entry point to the app. Loads required files, and routes.

If you want to run this application in your server, change your database connection info in 
<br>*app/kernel/config.php* line 22
<br>Example:
<pre>const DB_CONNECT_INFO = [
  "host"=>"localhost",
  "db_name"=>"db_name",
  "charset"=>"utf8",
  "db_username"=>"root",
  "db_user_password"=>""
];</pre>

Specific PDO options could be changed directly in **DBh** class constructor locates in 
<br>*app/models/Dbh.php* line 73
<br>Example: 
<pre>
$this->opt = [
    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES => false
];
</pre>

>*This code does not pretend to be the best. And has a lot of places to improve. This implementation of MVC model just my point of view*
