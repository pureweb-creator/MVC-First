<?php
require_once "autoload.php";

const SITEPATH = "http://localhost/phptutor/mvcproj";

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