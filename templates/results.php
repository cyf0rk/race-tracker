<?php
    require_once __DIR__.'/../src/Entity/Race.php';
    $previous = "javascript:history.go(-1)";
    $filterOptions = array('options'=>array('regexp'=>'/^[a-zA-Z0-9 ]*$/'));
    $sanitizedRaceName = htmlspecialchars($_POST['race-name']);

    if (filter_var($sanitizedRaceName, FILTER_VALIDATE_REGEXP, $filterOptions)) {
        $newRace = new Race($sanitizedRaceName, $_POST['date']);

        $newRace->processRaceResults($_FILES['csv-file']['tmp_name']);

        $mediumRace = $newRace->getMediumDistanceRace();
        $longRace = $newRace->getLongDistanceRace();

        $raceLadder = $newRace->sortRunnersByPlacement($mediumRace);

    }

    if(isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
    }

?>
<div class="results-wrapper">
    <h2>Race Title: <?php echo $newRace->getRaceName(); ?></h2>
    <p>Race date: <?php echo $newRace->getRaceDate(); ?></p>
    <h3>Medium distance</h3>
    <p>Average: <?php echo $newRace->getAvgFinishTime($mediumRace); ?></p>

    <h3>Long distance</h3>
    <p>Average: <?php echo $newRace->getAvgFinishTime($longRace); ?></p>
    <br>
    <a class="back-button" href="<?php $previous; ?>">Import race results</a>
</div>