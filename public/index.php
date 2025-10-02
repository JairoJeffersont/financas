<?php

use Illuminate\Database\Capsule\Manager as Capsule;

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// --- MINIFY START ---
function minify_output($html) {
    $html = preg_replace('/<!--(?!\[if).*?-->/s', '', $html);
    $html = preg_replace('/\s+/', ' ', $html);
    $html = preg_replace('/>\s+</', '><', $html);
    return $html;
}
ob_start('minify_output');
// --- MINIFY END ---

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => $_ENV['DB_DRIVER'],
    'host'      => $_ENV['DB_HOST'],
    'database'  => $_ENV['DB_DATABASE'],
    'username'  => $_ENV['DB_USERNAME'],
    'password'  => $_ENV['DB_PASSWORD'],
    'charset'   => $_ENV['DB_CHARSET'],
    'collation' => $_ENV['DB_COLLATION']
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

// Inclui o layout/base da aplicação
include('../src/Views/base/baseLayout.php');

// Envia saída minificada
ob_end_flush();
