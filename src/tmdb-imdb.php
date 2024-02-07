<?php

include 'credentials.php';
include 'tmdb.php';

$query = isset($_GET['query']) ? $_GET['query'] : '';

if (empty($query)) {
    http_response_code(400);
    echo json_encode(['error' => 'Query parameter is required']);
    exit;
}

$searchApiUrl = "https://api.themoviedb.org/3/find/" . urlencode($query) . "?external_source=imdb_id";
$searchApiResponse = getTmdbApiResponse($searchApiUrl, $tmdbBearerToken);

$searchData = json_decode($searchApiResponse, true);

if (isset($searchData['movie_results']) && !empty($searchData['movie_results'])) {
    $movieId = $searchData['movie_results'][0]['id'];
    $movieApiUrl = "https://api.themoviedb.org/3/movie/" . urlencode($movieId) . "?append_to_response=credits";
    $movieApiResponse = getTmdbApiResponse($movieApiUrl, $tmdbBearerToken);

    http_response_code(200);
    header('Content-Type: application/json');
    echo $movieApiResponse;

} else {
    http_response_code(400);
    echo json_encode(['error' => 'No movie results found.']);
}

?>

