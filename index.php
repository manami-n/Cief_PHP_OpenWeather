<?php 
error_reporting(0);

$ciudad = "Barcelona";

if ($_POST) {
    $ciudad = $_POST['ciudad'];
}

//getting url
$URL = "https://api.openweathermap.org/data/2.5/weather?q=$ciudad&appid=0897274c959147d0b72756637b74fcc6&units=metric&lang=es";
$icon_path = "https://www.imelcf.gob.pa/wp-content/plugins/location-weather/assets/images/icons/weather-icons/";
//getting string
$stringMeteo = file_get_contents($URL);
//converting it to json format
$jsonMeteo = json_decode($stringMeteo, true);


//var_dump($jsonMeteo);
$nombre = $jsonMeteo['name'];

$meteo = $jsonMeteo['weather'][0]["main"];
$descr = $jsonMeteo['weather'][0]["description"];
$icon = $jsonMeteo['weather'][0]["icon"];

$temp = $jsonMeteo['main']["temp"];
$temp_feels = $jsonMeteo['main']["feels_like"];
$temp_min = $jsonMeteo['main']["temp_min"];
$temp_max = $jsonMeteo['main']["temp_max"];
$humid = $jsonMeteo['main']["humidity"];

$wind = $jsonMeteo['wind']["speed"];
// 01 sunny 02 a bit sunny  03 cloudy 04 heavy cloud 09 rain 10 sunny/rain 11 thunder 13 snow 15 mist



?>
<!-- //////////////////////
            HTML 
    ////////////////////// -->
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City meteo</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&family=Lilita+One&display=swap');
        * { margin:0; padding: 0; 
            box-sizing: border-box; 
            font-family: "Dosis", sans-serif;
            color: #333;
            list-style: none; 
        }
        body {
            background-color: skyblue;
        }

        h1 { font-size:clamp(2vw, 20px); 
            font-family: "Lilita One", Haettenschweiler, 'Arial Narrow Bold', sans-serif; 
            text-align: center;
            line-height: 3;
        }

        main { 
            width: 600px; 
            margin: 20px auto; 
            background-color: white;
            border-radius: 10px;
            padding: 20px 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }        
        form{
            width: 500px;
            margin: 0 auto;
            padding-bottom: 10px;
            border-bottom: #eee 3px solid;
            text-align: center;
            font-size: 1.2rem;
            
            input {
                border: 1px solid #ccc;
                padding: 5px;
                margin: 0 3px;
                border-radius: 8px;
                font-size: 1.2rem;
                text-align: right;
            }

            button {
                border: none;
                background-color: skyblue;
                padding: 5px;
                border-radius: 8px;
                font-size: 1.2rem;
            }
            button:hover {
                background-color: #19bdff;
            }
        }
        h2 { font-size: 2rem;
            font-family: "Lilita One", Haettenschweiler, 'Arial Narrow Bold', sans-serif; 
            text-align: center;
            line-height: 2.5;}

        .weather{
            display: flex;
            justify-content: space-around;
            h3{
                text-align: center;
            }
            img {
                width: 250px;
                height: 200px;
            }
            div:last-child {
                align-self: center;
            }
            .thick {
                font-weight: 700;
                margin-top: 8px;
            }
        }
        .temp {
                display: flex;
                justify-content: space-around;
                flex-wrap: wrap;
            h3{
                width: 100%;
                text-align: center;
                font-size: 2rem;
                line-height: 2;
                color: steelblue;
            }
            p {
            padding-bottom: 8px;
            }
        }

        .error{
            text-align: center;
            font-size: 1.2rem;
            padding: 10px;
        }
        .temp .red {color: firebrick;}
    </style>
</head>
<?php
if (str_contains($icon, '03') || str_contains($icon, '10') || str_contains($icon, '15')): 
    echo '<body style="background-color:lightsteelblue">';
elseif (str_contains($icon, '04') || str_contains($icon, '09') || str_contains($icon, '11')):
    echo '<body style="background-color:gray">';
elseif (str_contains($icon, '13')): echo '<body style="background-color:snow">';
else: echo '<body>';
endif;
?>
    <header>
        <h1>Meteo con Open Weather</h1>
    </header>
    <main>    
        <form method="POST">
            <input type="text" name="ciudad" id="ciudad" autofocus placeholder="nombre de la ciudad">
            <button type="submit">Buscar</button>
        </form>
        <?php if ($stringMeteo) : ?>

        <h2><?= $nombre; ?></h2>
        
        <div class="weather">
            <div><h3>Clouds</h3>
                <img src="<?= $icon_path . $icon . ".svg"?>" aria-hidden="true">
            </div>
            <div>
                <p class="thick">Descripción:</p>
                <p><?= $descr ?></p>
                <p class="thick">Wind:</p> 
                <p><?= $wind; ?>m/hr </p>
            </div>
        </div>
        <div class="temp">
            
            <h3 <?php if ($temp > 20) : ?>class="red"<?php endif;?>><?= $temp; ?>℃</h3>
            <div>
                <p>Sensación térmica: <?= $temp_feels; ?>℃</p>
                <p>Humedad: <?= $humid; ?>%</p>
            </div>
            <div>
                <p>Min: <?= $temp_min; ?>℃</p>
                <p>Max: <?= $temp_max; ?>℃</p>
            </div>
        </div>
        <?php else :  ?>
            <p class="error"><?= $city ?> nombre de ciudad incorrecto.</p>
            <?php endif; ?>

    </main>
</body>
</html>