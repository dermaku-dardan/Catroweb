<?php

$_SERVER['APP_ENV'] = 'test';
require dirname(__DIR__).'/config/bootstrap.php';

use DG\BypassFinals;

BypassFinals::enable();
