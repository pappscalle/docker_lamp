<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Search</title>
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
echo $apiUrl;
        // Make the API request
        $response = file_get_contents($apiUrl);

        // Decode the JSON response
        $data = json_decode($response, true);
var_dump($data);
        // Check if the request was successful
        foreach ($movieResults['results'] as $movie) {
          echo '<div>';
          echo '<h2>' . $movie['title'] . '</h2>';
          echo '<p><strong>Overview:</strong> ' . $movie['overview'] . '</p>';
          echo '<p><strong>Release Date:</strong> ' . $movie['release_date'] . '</p>';
          // Add more details if needed
  
          if (isset($movie['poster_path'])) {
              echo '<img src="' . $movie['poster_path'] . '" alt="Movie Poster">';
          }
  
          echo '</div>';
      }
    }
    ?>

</body>
</html>
