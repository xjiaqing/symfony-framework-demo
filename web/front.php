<?php

use Simplex\Framework;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../vendor/autoload.php';

include __DIR__ . '/../src/app.php';        // 引入路由 Route 定义


(new Framework($routes))->handle(Request::createFromGlobals())->send();
