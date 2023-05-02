<?php

namespace App\Services\Proxies\Google;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use SimpleXMLElement;

class GoogleNewsProxy
{
    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var string
     */
    private string $googleNewsBaseUrl;

    /**
     * GoogleNewsProxy constructor
     */
    public function __construct()
    {
        $this->client = new Client();
        $this->googleNewsBaseUrl = $_ENV['GOOGLE_NEWS_URL'] ?? '';
    }

    /**
     * Sends a search request to Google News and returns an array of news items
     *
     * @param string $keywords
     * @param string $language
     * @return array
     * @throws GuzzleException
     * @throws Exception
     */
    public function search(string $keywords, string $language): array
    {
        // Change the case for the request
        $language = mb_strtolower($language);
        $country = mb_strtoupper($language);

        // Send a GET request to the Google News API with the given keywords and language
        $response = $this->client->get($this->googleNewsBaseUrl, [
            'query' => [
                'q' => $keywords,
                'hl' => $language,
                'gl' => $country,
                'ceid' => "$country:$language"
            ],
        ]);

        // Parse the XML response from Google News and return an array of news items
        return $this->parseXmlResponse($response);
    }

    /**
     * Parses the response from Google News and returns an array of news items
     *
     * @param ResponseInterface $response
     * @return array
     * @throws Exception
     */
    private function parseXmlResponse(ResponseInterface $response): array
    {
        // Get the response body as a string and create a SimpleXMLElement object from it
        $body = $response->getBody();
        $xml = new SimpleXMLElement($body);

        // Parse the XML to extract the relevant data for each news item and add it to an array
        $items = [];
        foreach ($xml->channel->item as $item) {
            $items[] = $this->cherryPickValues($item);
        }

        // Return the array of news items
        return $items;
    }

    /**
     * Extracts the relevant data from a SimpleXMLElement object representing a news item
     *
     * @param SimpleXMLElement $item
     * @return array
     */
    private function cherryPickValues(SimpleXMLElement $item): array
    {
        return [
            'link' => (string) $item->link,
            'description' => (string) $item->description,
            'source' => (string) $item->source,
            'pubDate' => (string) $item->pubDate,
        ];
    }
}
