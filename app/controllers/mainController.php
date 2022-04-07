<?php
use models\Model;

function is_logged(){
    $request = new Model();
    $cookies = $request->getCookieParams();
    return isset($cookies['logged_user']) ? unserialize($cookies['logged_user']) : ['is_logged_out' => 'true'];
}
