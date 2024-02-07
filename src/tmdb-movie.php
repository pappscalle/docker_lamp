<?php

include 'credentials.php';
include 'tmdb.php';

$query = isset($_GET['query']) ? $_GET['query'] : '';

if (empty($query)) {
    http_response_code(400);
    echo json_encode(['error' => 'Query parameter is required']);
    exit;
}

$url = "https://api.themoviedb.org/3/movie/" . urlencode($query) . "?append_to_response=credits";
$response = getTmdbApiResponse($url, $tmdbBearerToken);

http_response_code(200);
header('Content-Type: application/json');
echo $response;

?>