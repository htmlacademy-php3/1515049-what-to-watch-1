<?php

namespace App\Repositories\Films;

use App\Interfaces\FilmsOmdbRepositoryInterface;
use Exception;
use GuzzleHttp\Psr7\HttpFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Override;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Throwable;

/**
 * Репозиторий для получения информации о фильмах из внешнего API OMDb.
 *
 * @template TModel of Model
 */
class FilmsOmdbRepository implements FilmsOmdbRepositoryInterface
{
    /**
     * Сообщение об ошибке при запросе данных с удалённого сервера.
     *
     * @return string|null
     */
    private ?string $error = null;

    #[Override]
    public function getError(): ?string
    {
        return $this->error;
    }

    /**
     * @psalm-suppress PossiblyUnusedMethod
     * Laravel DI автоматически вызывает этот конструктор
     */
    public function __construct(private readonly ClientInterface $httpClient)
    {
    }

    /**
     * Получает информацию о фильме по его IMDb ID.
     *
     * @param string $imdbId IMDb ID фильма (например, tt0111161)
     * @return array|null Ассоциативный массив с данными о фильме или null при ошибке
     *
     * @throws Exception Если не задан API-ключ или запрос не может быть создан
     */
    #[Override]
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

    /**
     * Создаёт HTTP-запрос для получения информации о фильме по IMDb ID.
     *
     * @param string $imdbId IMDb ID фильма
     * @return RequestInterface Запрос для клиента
     *
     * @throws Exception Если не указан OMDB_API_KEY в окружении
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
