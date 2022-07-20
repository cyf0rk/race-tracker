<?php
    $previous = "javascript:history.go(-1)";

    if(isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
    }
?>
<div class="results-wrapper">
    <h2>Race Title: <?php echo $race[0]['race_name']; ?></h2>
    <p>Race date: <?php echo $race[0]['race_date']; ?></p>
    <h3>Medium distance</h3>
    <p>Average: <?php echo $mediumDistanceAvgTime; ?></p>
    <table class="results-table">
        <tr class="results-row">
            <td>Full name</td>
            <td>Race time</td>
            <td>Placement</td>
            <td></td>
        </tr>
    <?php
    foreach ($results['long_distance'] as $result) {
        ?>
        <tr class="results-row">
            <td><?php echo $result['full_name']; ?></td>
            <td><?php echo $result['race_time']; ?></td>
            <td><?php echo $result['placement']; ?></td>
            <td>
                <button class="result-edit-button">Edit</button>
            </td>
        </tr>
        <?php
    }
    ?>
    </table>

    <h3>Long distance</h3>
    <p>Average: <?php echo $longDistanceAvgTime; ?></p>
    <table class="results-table">
        <tr class="results-row">
            <td>Full name</td>
            <td>Race time</td>
            <td>Placement</td>
            <td></td>
        </tr>
    <?php
    foreach ($results['long_distance'] as $result) {
        ?>
        <tr class="results-row">
            <td><?php echo $result['full_name']; ?></td>
            <td><?php echo $result['race_time']; ?></td>
            <td><?php echo $result['placement']; ?></td>
            <td>
                <button class="result-edit-button">Edit</button>
            </td>
        </tr>
        <?php
    }
    ?>
    </table>
    <a class="button save-button" id="save-button" href="<?php $previous; ?>">Save changes</a>
    <a class="button back-button" href="<?php $previous; ?>">Import new race results</a>
</div>