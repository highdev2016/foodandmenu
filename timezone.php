<?php
//echo getTimezone("10001 South IH 35 Austin  TX  78747");
echo getTimezone("1440 San Marco Blvd Jacksonville FL 32207");
function getTimezone($location)
{
	$location = urlencode($location);
	$url = "http://maps.googleapis.com/maps/api/geocode/json?address={$location}&sensor=false";
	$data = file_get_contents($url);
	
	// Get the lat/lng out of the data
	$data = json_decode($data);
	if(!$data) return false;
	if(!is_array($data->results)) return false;
	if(!isset($data->results[0])) return false;
	if(!is_object($data->results[0])) return false;
	if(!is_object($data->results[0]->geometry)) return false;
	if(!is_object($data->results[0]->geometry->location)) return false;
	if(!is_numeric($data->results[0]->geometry->location->lat)) return false;
	if(!is_numeric($data->results[0]->geometry->location->lng)) return false;
	$lat = $data->results[0]->geometry->location->lat;
	$lng = $data->results[0]->geometry->location->lng;
	
	// get the API response for the timezone
	$timestamp = time();
	$timezoneAPI = "https://maps.googleapis.com/maps/api/timezone/json?location={$lat},{$lng}&sensor=false&timestamp={$timestamp}";
	$response = file_get_contents($timezoneAPI);
	if(!$response) return false;
	$response = json_decode($response);
	if(!$response) return false;
	if(!is_object($response)) return false;
	if(!is_string($response->timeZoneId)) return false;
	
	return $response->timeZoneId;
}