<?php

/**
 * @package   Task Management
 * @author    Ntabethemba Ntshoza
 * @date      11-10-2023
 * @copyright Copyright © 2023 VMP By Maneza
 */

// Function to fetch current weather data from OpenWeatherMap API
function getCurrentWeather($cityName, $apiKey)
{
    try {
        $url = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($cityName) . "&appid=" . $apiKey . "&units=metric";

        // Make an HTTP request to the API and get the response headers
        $context = stream_context_create(['http' => ['ignore_errors' => true]]);
        $response = file_get_contents($url, false, $context);
        $headers = $http_response_header;
    
        // Check the HTTP status code
        if (strpos($headers[0], '200 OK') === false) {
            return ["error" => "City not found or invalid"];
        }
    
        $data = json_decode($response, true);
    
        return $data;
        
    } catch (Exception $e) {
        //throw $th;
        echo "An error occurred while fetching weather data.";
    }
}
