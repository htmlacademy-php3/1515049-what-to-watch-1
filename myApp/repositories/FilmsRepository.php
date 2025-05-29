<?php

namespace myApp\repositories;

use GuzzleHttp\Psr7\HttpFactory;
use http\Exception\RuntimeException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

final class FilmsRepository implements FilmsRepositoryInterface
{

//  private string $apiKey;
//  private string $baseUrl = 'https://www.omdbapi.com/';
//
//  public function __construct(string $apiKey)
//  {
//    $this->apiKey = $apiKey;
//  }
//
//    public function getFilmById(string $imdbId) : array
//    {
//      $url = $this->baseUrl . "?i=" . $imdbId . "&apikey=" . $this->apiKey;
//      $response = file_get_contents($url);
//
//      if (!$response) {
//        throw new RuntimeException("Ошибка при запросе к OMDB API");
//      }
//
//      $data = json_decode($response, true);
//
//      if (!isset($data['Response']) || $data['Response'] === 'False') {
//        throw new RuntimeException("Фильм не найден: " . ($data['Error'] ?? 'Неизвестная ошибка'));
//      }
//
//      return $data;
//    }

  public function __construct(private readonly ClientInterface $httpClient)
  {
  }

  /**
   * @throws ClientExceptionInterface
   */
  public function getFilmById(string $imdbId) : ?array
  {
    $response = $this->httpClient->sendRequest($this->createRequest($imdbId));

    return json_decode($response->getBody()->getContents(), true);
  }

  private function createRequest(string $imdbId)
  {
    $apiKey = $_ENV['OMDB_API_KEY'] ?? null;

    if (!$apiKey) {
      throw new RuntimeException('Не найден OMDB_API_KEY');
    }

    $url = "https://www.omdbapi.com/?apikey=$apiKey";
    return new HttpFactory()->createRequest('get', "$url&i=$imdbId");
  }
}
