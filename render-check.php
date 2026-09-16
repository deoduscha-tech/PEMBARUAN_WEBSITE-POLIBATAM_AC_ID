<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create($argv[1] ?? '/', 'GET');
$response = $kernel->handle($request);
file_put_contents($argv[2], $response->getContent());
echo "STATUS=" . $response->getStatusCode() . " BYTES=" . strlen($response->getContent()) . PHP_EOL;
