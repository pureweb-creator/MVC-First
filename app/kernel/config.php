<?php
require_once "autoload.php";

$site_path = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

const ERROR_MSG = [
	"wrongData"=> "There's no user with this login or password.",
	"notValidLogin"=> "You can use a-z, A-Z, 0-9, underscores and dots. Minimum length is 5 and maximum is 20 characters accordingly.",
	"noLogin"=> "Please, type login.",
	"noEmail"=> "Please, type email.",
	"noPassword"=> "Please, type your password.",
	"noPasswordRepeat"=> "Please, repeat your password.",
	"wrongEmail"=> "Wrong email.",
	"notEqualPassword"=> "Passwords not equal.",
	"wrongPassword"=> "Password shouldn't be longer than 60 symbols",
	"noUserExists"=> "There's no user with this email",
	"productAlreadyAdded"=> "This product already in cart",
	"serverError"=>"Sorry, something went wrong. Try again later",
	"noProducts"=>"No products or failed to load"
];

const DB_CONNECT_INFO = [
	"host"=>"localhost",
	"db_name"=>"mvcproj_development",
	"charset"=>"utf8",
	"db_username"=>"root",
	"db_user_password"=>""
];