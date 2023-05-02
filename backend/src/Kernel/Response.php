<?php

namespace App\Kernel;

class Response
{
    // OK response status
    public const RESPONSE_OK = 'HTTP/1.1 200 OK';

    // CORS headers
    private const CROSS_ORIGIN_HEADERS = [
        'Access-Control-Allow-Origin: %s',
        'Access-Control-Allow-Methods: GET, POST',
        'Access-Control-Allow-Headers: Content-Type',
    ];

    /**
     * Create an HTTP response containing header(s) and payload
     *
     * @param string|array|null $payload The response payload, can be a string, an array or null
     * @param array|null $headers The headers to be included in the response, can be an array or null
     *
     * @return void
     */
    public static function response($payload = null, array $headers = null): void
    {
        foreach ($headers ?? [self::RESPONSE_OK] as $header) {
            header($header);
        }

        foreach (self::CROSS_ORIGIN_HEADERS as $header) {
            header(
                sprintf(
                    $header,
                    $_ENV['CORS_HOST']
                )
            );
        }

        echo json_encode($payload ?? '');

        exit;
    }

    /**
     * Create a JSON HTTP response
     *
     * @param array $payload The response payload in array format
     *
     * @return void
     */
    public static function jsonResponse(array $payload): void
    {
        self::response(
            $payload,
            [
                self::RESPONSE_OK,
                'Content-Type: application/json',
            ]
        );
    }

    /**
     * Create a "Not Found" HTTP response
     *
     * @return void
     */
    public static function notFound(): void
    {
        self::response(
            [
                'name' => 'Not Found',
                'message' => 'Requested resource was not found',
                'code' => 0,
                'status' => 404,
            ],
            [
                "HTTP/1.1 404 Not Found",
            ]
        );
    }

    /**
     * Create an "Internal Error" HTTP response
     *
     * @param string|null $errorMessageText The error message to include in the response
     *
     * @return void
     */
    public static function internalError(string $errorMessageText = null): void
    {
        self::response(
            [
                'message' => $errorMessageText ?? 'Server encountered an unexpected condition',
                'status' => 500,
            ],
            [
                "HTTP/1.1 500 Internal Server Error",
            ]
        );
    }
}
