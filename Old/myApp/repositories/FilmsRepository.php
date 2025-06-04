<?php

namespace myApp\repositories;

use GuzzleHttp\Psr7\HttpFactory;
use http\Exception\RuntimeException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

final class FilmsRepository implements FilmsRepositoryInterface
{

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

  private function createRequest(string $imdbId) : RequestInterface
  {
    $apiKey = $_ENV['OMDB_API_KEY'] ?? null;

    if (!$apiKey) {
      throw new RuntimeException('Не найден OMDB_API_KEY');
    }

    $url = "https://www.omdbapi.com/?apikey=$apiKey";
    return (new HttpFactory())->createRequest('get', "$url&i=$imdbId");
  }
}
