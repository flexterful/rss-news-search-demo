<?php

namespace App\Controller\News;

use App\Enum\News\NewsRequestParams;
use App\Kernel\Request;
use App\Kernel\Response;
use App\Services\Google\GoogleNewsService;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

// Class responsible for handling Google News RSS requests
class GoogleNewsController
{
    // GoogleNewsService for interacting with the Google News RSS feed
    private GoogleNewsService $googleNewsProxy;

    // GoogleNewsController constructor
    public function __construct(GoogleNewsService $googleNewsService)
    {
        $this->googleNewsProxy = $googleNewsService;
    }

    /**
     * Handle a Google News RSS request
     *
     * @param Request $request
     * The Request object containing the request parameters
     *
     * @return void
     * No return value. The function will output a HTTP response and exit the script.
     */
    public function index(Request $request): void
    {
        // If the request does not contain keywords, respond with an internal error and exit
        if (!$request->has(NewsRequestParams::KEYWORDS)) {
            Response::internalError('Keywords cannot be empty');
        }

        try {
            // Try to search for news using the keywords and language from the request
            $response = $this->googleNewsProxy->search(
                $request->get(NewsRequestParams::KEYWORDS),
                $request->get(NewsRequestParams::LANGUAGE, 'en-US')
            );
        } catch (GuzzleException | Exception $exception) {
            // If an exception is thrown, respond with an internal error using the exception message and exit
            Response::internalError(
                $exception->getMessage()
            );
        }

        // Respond with a JSON response containing the search results
        Response::jsonResponse($response ?? []);
    }
}
