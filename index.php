<?php

use GuzzleHttp\Client;
use myApp\FilmsService;
use myApp\repositories\FilmsRepository;

require_once './vendor/autoload.php';

require "myApp/repositories/FilmsRepositoryInterface.php";
require "myApp/repositories/FilmsRepository.php";
require "myApp/FilmsService.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$client = new Client();
$repository = new FilmsRepository($client);
$service = new FilmsService($repository);

$data = $service->getFilm('tt0111161');

echo '<pre>';
print_r($data);
echo '</pre>';
