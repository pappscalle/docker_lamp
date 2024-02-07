<?php

function getTmdbApiResponse($url, $bearerToken) {
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => "Content-Type: application/json\r\n" .
                        "Authorization: Bearer {$bearerToken}\r\n",
        ],
    ]);

    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        http_response_code(500);
        echo json_encode(['error' => 'Error connecting to TMDb API']);
        exit;
    }

    return $response;
}

?>
