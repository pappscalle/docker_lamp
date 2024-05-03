<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Search</title>
        <style>
        .image {
            width: 150px; 
            height: auto; 
            float: left;
            margin: 0 10px 10px 0;
        }

        .movie {
            clear: both;
        }
    </style>
</head>
<body>

    <h1>Movie Search</h1>

    <form method="GET" action="">
        <label for="title">Enter Movie Title:</label>
        <input type="text" id="title" name="title" required>
        <button type="submit">Search</button>
    </form>

    <?php
    // Handle the form submission
    if (isset($_GET['title'])) {
        $title = urlencode($_GET['title']);

        // Construct the API URL
        $apiUrl = "http://api.frenn.se/tmdb-search.php?query=$title";
//echo $apiUrl;
//echo "<br/>";
        // Make the API request
        $response = file_get_contents($apiUrl);

        // Decode the JSON response
        $data = json_decode($response, true);
//var_dump($data);
        // Check if the request was successful

        if (empty($data['results'])) {
            echo '<h2>No films found</h2>';
        } else {


            foreach ($data['results'] as $movie) {
                echo '<div class="movie">';
                if (isset($movie['poster_path'])) {
                    echo '<img class="image" src="https://image.tmdb.org/t/p/original/' . $movie['poster_path'] . '" alt="Movie Poster">';
                }                
                echo '<h2>' . $movie['title'] .' ('. getYearFromDate($movie['release_date']) .')</h2>';
                echo '<p><strong>Overview:</strong> ' . $movie['overview'] . '</p>';
                echo '<p><strong>Release Date:</strong> ' . $movie['release_date'] . '</p>';
                // Add more details 
        
 
        
                echo '</div>';
            }
        }
    }

function getYearFromDate($dateString) {
    $dateTime = new DateTime($dateString);
    return $dateTime->format('Y');
}

    ?>

</body>
</html>
