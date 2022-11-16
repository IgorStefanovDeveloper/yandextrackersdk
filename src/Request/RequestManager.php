<?php

namespace Localtests\Yandextrackersdk\Request;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Localtests\Yandextrackersdk\Exception\ForbiddenException;
use Localtests\Yandextrackersdk\Exception\UnauthorizedException;
use GuzzleHttp\ClientInterface;
use RuntimeException;

class RequestManager implements RequestInterface
{
    public const BASE_PATH = 'https://api.tracker.yandex.net';

    public const AUTHORIZATION = 'Authorization';

    public const X_ORG_ID = 'X-Org-Id';

    private ClientInterface $client;

    private string $authToken;

    private string $orgId;

    public function __construct(ClientInterface $client, string $authToken, string $orgId)
    {
        $this->client = $client;
        $this->authToken = $authToken;
        $this->orgId = $orgId;
    }

    /**
     * @throws UnauthorizedException
     * @throws GuzzleException
     * @throws ForbiddenException
     */
    public function get(string $url, array $parameters = [])
    {
        return $this->request('GET', $url, $parameters);
    }

    /**
     * @throws UnauthorizedException
     * @throws GuzzleException
     * @throws ForbiddenException
     */
    public function post(string $url, array $parameters = [])
    {
        return $this->request('POST', $url, $parameters);
    }

    /**
     * @throws UnauthorizedException
     * @throws GuzzleException
     * @throws ForbiddenException
     */
    public function delete(string $url, array $parameters = [])
    {
        return $this->request('DELETE', $url, $parameters);
    }

    /**
     * @throws UnauthorizedException
     * @throws GuzzleException
     * @throws ForbiddenException
     */
    public function patch(string $url, array $parameters = [])
    {
        return $this->request('PATCH', $url, $parameters);
    }

    /**
     * @throws UnauthorizedException
     * @throws GuzzleException
     * @throws ForbiddenException
     */
    public function request(string $method, string $uri, array $options = [])
    {
        $options = array_merge([
            RequestOptions::HEADERS => [
                self::AUTHORIZATION => 'OAuth ' . $this->authToken,
                self::X_ORG_ID => $this->orgId
            ]
        ], $options);

        $response = $this->client->request(
            $method,
            self::BASE_PATH . $uri,
            $options
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode >= 200 && $statusCode < 300) {
            return json_decode($response->getBody(), true);
        }
        //Код ответа на статус ошибки "HTTP 403 Forbidden" указывает, что сервер понял запрос, но отказывается его авторизовать.
        if (403 === $statusCode) {
            throw new ForbiddenException();
        }
        //запрос не был применён, поскольку ему не хватает действительных учётных данных для целевого ресурса.
        if (401 === $statusCode) {
            $content = json_decode($response->getBody(false), true);

            throw new UnauthorizedException($content['errorMessages'][0]);
        }

        throw new RuntimeException($response->getStatusCode() . ' ' . $response->getBody(false));
    }
}


