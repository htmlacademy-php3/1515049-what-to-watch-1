<?php

namespace App\Repositories;

use Exception;
use GuzzleHttp\Psr7\HttpFactory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Throwable;

class FilmsOmdbRepository implements FilmsOmdbRepositoryInterface
{
    private string $error;

    public function __construct(private ClientInterface $httpClient)
    {
    }

    /**
     * @throws Exception
     */
    public function getFilmById(string $imdbId): ?array
    {
        try {
            $response = $this->httpClient->sendRequest($this->createRequest($imdbId));
            $body = $response->getBody()->getContents();
        } catch (Throwable $e) {
            $this->error = 'Ошибка при запросе информации с удаленного сервера';
            return null;
        }

        return json_decode($body, true);
    }

    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @throws Exception
     */
    private function createRequest(string $imdbId): RequestInterface
    {
        $apiKey = $_ENV['OMDB_API_KEY'] ?? null;

        if (!$apiKey) {
            throw new Exception('Не найден OMDB_API_KEY');
        }

        $url = "https://www.omdbapi.com/";
        return new HttpFactory()->createRequest('get', "$url?i=$imdbId&apikey=$apiKey");
    }
}
