<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <form method="GET">
        <input name="pokemonId" placeholder="ID or Name">
        <button type="submit">Search</button>
    </form>
</header>

<?php

if (isset($_GET['pokemonId']) && $_GET['pokemonId'] !== '') {
    $inputVal = $_GET['pokemonId'];
    $data = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $inputVal);
    $dataArr = json_decode($data, true);

    $pokeId = $dataArr['id'];
    $pokeName =$dataArr['name'];
    $pokeImage =$dataArr['sprites']['front_default'];

    $pokeMoves = $dataArr['moves'];

    $count = count($dataArr['moves']);

    if ($count > 3) {
        $max = 4;
    }else {
        $max = $count;
    }

    $randomArrayIndexes = array_rand($dataArr['moves'], $max);
    // array_map loops through each array item and uses the current array item as a function parameter
    // and makes a new array containing the returned values of the function
    $moves = array_map(function($index) {
        global $dataArr; // global keyword allows us to access global variables that are initialize outside of the function
        return $dataArr['moves'][$index]['move']['name'];
    }, $randomArrayIndexes);


    $speciesUrl = $dataArr['species']['url'];
    $speciesDataArr = json_decode(file_get_contents($speciesUrl), true);

    $hasPrevEvolution = false;
    $previousEvolutionName = '';

    if(isset($speciesDataArr['evolves_from_species'])){
        $previousEvolutionName = $speciesDataArr['evolves_from_species']['name'];
        $hasPrevEvolution = true;

        $prevEvolutionData = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $previousEvolutionName);
        $prevEvolutionDataArr = json_decode($prevEvolutionData, true);

        $prevEvImage = $prevEvolutionDataArr['sprites']['front_default'];
    }
?>

    <div id="main">
        <div class="details">
            <h2 class="name"><span class="id"># <?php echo $pokeId ?></span> <?php echo $pokeName ?> </h2>
            <img src="<?php echo $pokeImage ?>" alt="<?php echo $pokeName ?>">
            <?php/*
        foreach ($pokeMoves as $move) {
        */?>
            <!--<p><?php //echo $move['move']['name']; ?></p>-->
            <?php/*
        }
        */?>

            <p>Moves:</p>
            <?php
            /*foreach ($pokeMoves as $move) {
                echo '<p>' . $move["move"]["name"] . '</p>';
            }*/
            foreach ($moves as $move) {
                ?>
                <p class="single-move"><?php echo $move ?></p>
                <?php
            }
            ?>
        </div>

        <?php
        //if ($hasPrevEvolution) {
        // echo '<p>' . $previousEvolutionName . '</p>';
        // echo '<img src="' . $prevEvImage . '">' . $previousEvolutionName . '</img>';
        //}
        ?>

        <?php
        if ($hasPrevEvolution) {
            ?>
            <div class="prev-evolution">
                <p>Previous evolution: <?php echo $previousEvolutionName ?></p>
                <img src="<?php echo $prevEvImage ?>" />
            </div>
            <?php
        }

        ?>

    </div>
<?php
}else {
    echo '<p>Please input an ID or name</p>';
}
?>
</body>
</html>