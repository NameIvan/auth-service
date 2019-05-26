<?php
/* Generate documentation */
require __DIR__ . '/../vendor/autoload.php';
$openapi = \OpenApi\scan(__DIR__ . '/../controllers/api');
header('Content-Type: application/x-json');
file_put_contents(__DIR__ . '/../web/docs/swagger.json', $openapi->toJson());
