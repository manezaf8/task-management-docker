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
    $url = "https://api.openweathermap.org/data/2.5/weather?q=$cityName&appid=$apiKey";

    // Make an HTTP request to the API and parse the response
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    return $data;
}
