<?php

declare(strict_types=1);

ini_set('display_errors', "1"); //WITH INI_SET WE ACCESS PHP INI FILE
ini_set('display_startup_errors', "1"); //WITH INI_SET WE ACCESS PHP INI FILE
error_reporting(E_ALL);

//$pokeName = $_GET["inputValue"];


if (empty($_GET['pokeId'])){  //IF EMPTY DEFAULT IS BULBASAUR
    $formData = file_get_contents('https://pokeapi.co/api/v2/pokemon/1');
    $formDataSpecies = file_get_contents('https://pokeapi.co/api/v2/pokemon-species/1');
}
else {
    $formData = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $_GET['pokeId']);
    $formDataSpecies = file_get_contents('https://pokeapi.co/api/v2/pokemon-species/' . $_GET['pokeId']);
}

$data = json_decode($formData, true); //associative arrays, so you can talk to indexes (instead objects)
$dataSpecies =json_decode($formDataSpecies, true);


$pokemonId = $data['id'];
$pokeName = $data['name'];
$pokeSprite = $data['sprites']['front_default']; //nested array




for($i=0; $i<4; $i++){

    $pokeMoves = $data['moves'][$i]['move']['name'];

}


$pokeType = $data['types'][0]['type']['name'];

$test = $dataSpecies['evolves_from_species'];

if(array_key_exists('name', $test)){

$previousEvolution = $test['name'];

}



$prevEvImage = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $previousEvolution);
$previousImage =json_decode($prevEvImage, true);




//function evolutions($data){
    //do {
    //}while();
//}

// function moves() {generate 4 random moves}


//var_dump($data);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>


<section class = "input-field">
    <form method ="get">
        <input id="input" type="text" name="pokeId" placeholder="ID or Name">
        <button id="button" type="submit" class="btn">Search</button>
    </form>

</section>

<!-- make pokemon information appear in browser using html and php tags -->

<div>
    # <?php echo($pokemonId); ?>
    <?php echo($pokeName); ?>

</div>

<img src = "<?php echo $pokeSprite ?>" />

<div>
    Type: <?php echo($pokeType); ?>
</div>

<div>
    Moves: <?php echo($pokeMoves); ?>
</div>


<div>
    Previous evolution: <?php echo($previousEvolution); ?>
</div>

<img src = "<?php echo $previousImage['sprites']['front_default']?>" />

</body>
</html>
