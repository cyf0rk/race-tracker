<?php
    require_once __DIR__.'/../src/Entity/Race.php';
    $filterOptions = array('options'=>array('regexp'=>'/^[a-zA-Z0-9 ]*$/'));
    $sanitizedRaceName = htmlspecialchars($_POST['race-name']);

    if (filter_var($sanitizedRaceName, FILTER_VALIDATE_REGEXP, $filterOptions)) {
        $newRace = new Race($sanitizedRaceName, $_POST['date']);

        $newRace->processRaceResults($_FILES['csv-file']['tmp_name']);
    }

?>
<div class="results-wrapper">
    <h2>Race Title: <?php echo $newRace->getRaceName(); ?></h2>
    <p>Race date:  <?php echo $newRace->getRaceDate(); ?></p>
    <h3>Medium distance</h3>
    <p>Average: </p>

    <h3>Long distance</h3>
    <p>Average: </p>
</div>