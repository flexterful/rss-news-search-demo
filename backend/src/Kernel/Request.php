<?php

namespace App\Kernel;

// This class represents an HTTP request
class Request
{
    /**
     * @var array
     * The GET parameters of the request
     */
    private array $getParameters;

    /**
     * Request constructor
     *
     * @param array $getParameters The GET parameters of the request
     */
    public function __construct(array $getParameters)
    {
        $this->getParameters = $getParameters;
    }

    /**
     * Gets a GET parameter from the request
     *
     * @param string $key The key of the parameter
     * @param mixed $default The default value to return if the parameter does not exist
     *
     * @return mixed The value of the parameter or the default value if it does not exist
     */
    public function get(string $key, $default = null)
    {
        // Check if the key exists in the GET array. If it does, sanitize and return its value.
        // If it does not, return the default value.
        return $this->sanitize($this->getParameters[$key] ?? $default);
    }

    /**
     * Checks if a GET parameter exists in the request
     *
     * @param string $key The key of the parameter
     *
     * @return bool True if the parameter exists, false otherwise
     */
    public function has(string $key): bool
    {
        // Check if the key exists in the GET array.
        return isset($this->getParameters[$key]);
    }

    /**
     * Sanitizes data to prevent XSS attacks
     *
     * @param mixed $data The data to sanitize
     *
     * @return mixed The sanitized data
     */
    private function sanitize($data)
    {
        // If the data is a string, strip tags and special characters from the string.
        if (is_string($data)) {
            $data = htmlspecialchars($data);
        }

        return $data;
    }
}
