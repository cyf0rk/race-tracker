<?php
    $previous = "javascript:history.go(-1)";

    if(isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
    }
?>
<div class="results-wrapper">
    <h2>Race Title: <?php echo $newRace->getRaceName(); ?></h2>
    <p>Race date: <?php echo $newRace->getRaceDate(); ?></p>
    <h3>Medium distance</h3>
    <p>Average: </p>

    <h3>Long distance</h3>
    <p>Average: </p>
    <br>
    <a class="back-button" href="<?php $previous; ?>">Import race results</a>
</div>