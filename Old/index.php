<?php

use App\Repositories\FilmsOmdbRepository;
use App\Services\OmdbFilmsService;
use GuzzleHttp\Client;

require_once './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$client = new Client();
$repository = new FilmsOmdbRepository($client);

$service = new OmdbFilmsService($repository);

$data = $service->getFilm('tt0111161');
var_dump($data);

echo '<pre>';
print_r($data);
echo '</pre>';
