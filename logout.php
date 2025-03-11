<?php
require_once 'ooplr/core/init.php';
$user = new User();
$user -> logout();

Redirect::to('index.php');