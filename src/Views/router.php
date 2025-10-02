<?php
$uri = $_SERVER['REQUEST_URI']; // ex: /secao
$uri = parse_url($uri, PHP_URL_PATH); // garante que query strings sejam ignoradas
$uri = trim($uri, '/'); // remove barras no começo e no fim

$pagina = $uri ?: 'home';

$rotas = [
    'home' => '../src/Views/home/home.php',
];

if (array_key_exists($pagina, $rotas)) {
    include $rotas[$pagina];
} else {
    include '../src/Views/errors/404.php';
}
