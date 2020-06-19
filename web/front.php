<?php

use Calendar\Controller\ErrorController;
use Simplex\Framework;
use Simplex\StringResponseListener;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\ErrorListener;
use Symfony\Component\HttpKernel\EventListener\ResponseListener;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\EventListener\StreamedResponseListener;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

require_once __DIR__ . '/../vendor/autoload.php';

include __DIR__ . '/../src/app.php';        // 引入路由 Route 定义

$request = Request::createFromGlobals();
$requestStack = new RequestStack();

$context = new RequestContext();
$matcher = new UrlMatcher($routes, $context);

$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new RouterListener($matcher, $requestStack));
$dispatcher->addSubscriber(new ErrorListener(ErrorController::class . '::exception'));
$dispatcher->addSubscriber(new ResponseListener('UTF-8'));  // 在响应之前调用 Response::prepare() 方法，确保响应符合 http 规范
// $dispatcher->addSubscriber(new StreamedResponseListener()); // 支持流式响应
$dispatcher->addSubscriber(new StringResponseListener());

$framework = new Framework($dispatcher, $controllerResolver, $requestStack, $argumentResolver);
$response = $framework->handle($request);
$response->send();

