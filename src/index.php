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

    <h1>Movie Search v3</h1>

    <form method="GET" action="">
        <label for="title">Enter Movie Title:</label>
        <input type="text" id="title" name="title" required>
        <button type="submit">Search</button>
    </form>

    <?php
    // Handle the form submission
    if (isset($_GET['title'])) {
        $title = filter_input(INPUT_GET, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        // Check if the title is empty after filtering
        if (empty($title)) {
            echo '<h2>Please enter a valid movie title</h2>';
            exit; // Stop further execution if title is empty
        }
    
        // Construct the API URL
        $apiUrl = "http://api.frenn.se/tmdb-search.php?query=" . urlencode($title);
    
        // Make the API request
        $response = file_get_contents($apiUrl);
    
        // Decode the JSON response
        $data = json_decode($response, true);
    
        // Check if the request was successful
        if (empty($data['results'])) {
            echo '<h2>No films found</h2>';
        } else {
            foreach ($data['results'] as $movie) {
                echo '<div class="movie">';
                if (isset($movie['poster_path'])) {
                    echo '<img class="image" src="https://image.tmdb.org/t/p/original/' . $movie['poster_path'] . '" alt="Movie Poster">';
                }                
                echo '<h2>' . htmlspecialchars($movie['title']) .' ('. getYearFromDate($movie['release_date']) .')</h2>';
                echo '<p><strong>Overview:</strong> ' . htmlspecialchars($movie['overview']) . '</p>';
                echo '<p><strong>Release Date:</strong> ' . htmlspecialchars($movie['release_date']) . '</p>';
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
