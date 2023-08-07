<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>


<section>
    <div class="search">
        <h2 text-align="center">Weather forecast</h2>
        <form action="index.php" method="post">
            <input type="text" name="city" id="city" placeholder="CityName">
            <input type="submit" id="submit" value="search" >
        </form>
    </div>
</section>




<?php


if($_SERVER["REQUEST_METHOD"] === "POST"){
    $cityName =$_POST['city'];


$apiKey = 'd34334452229fa3c36f1edde52fd8efb';

$apiEndpoint = 'http://api.openweathermap.org/data/2.5/forecast';




$url = "{$apiEndpoint}?q={$cityName}&appid={$apiKey}";


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "Error: " . curl_error($ch);
    exit;
}

curl_close($ch);

$forecastData = json_decode($response, true);


if ($forecastData['cod'] === '200') {
    echo '<div class="weather">';
    echo '<div class="weather-container">';
   
    foreach ($forecastData['list'] as $forecast) {
        $date = date('Y-m-d H:i:s', $forecast['dt']);
        $temperature = $forecast['main']['temp'] - 273.15; 
        $weatherDescription = $forecast['weather'][0]['description'];

        echo '<div class="weather-data">';
        echo "<h2>"."City:{$cityName}\n"."</h2>";
        echo '<br>';
        echo "Date: {$date}\n";
        echo '<br>';
        echo "Temperature: {$temperature} °C\n";
        echo '<br>';
        echo "Weather Description: {$weatherDescription}\n";
        echo '</div>';
        echo '<br>';
    }
    echo '</div>';
    echo '</div>';
} else {
    echo "Error: Unable to fetch weather forecast. Please check your API key and city name.";
}

}

?>  



</body>
</html>



