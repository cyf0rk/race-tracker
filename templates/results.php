<?php
    $previous = "javascript:history.go(-1)";

    if(isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
    }
?>
<div class="results-wrapper">
    <h2>Race Title: <?php echo $this->race['race_name']; ?></h2>
    <p>Race date: <?php echo $this->race['race_date']; ?></p>
    <h3>Medium distance</h3>
    <p>Average time: <?php echo $this->raceAvgTimes['medium_distance_avg_finish_time']; ?></p>
    <table class="results-table">
        <tr class="results-row">
            <td>Full name</td>
            <td>Race time</td>
            <td>Placement</td>
            <td></td>
        </tr>
    <?php
    foreach ($this->race['0'] as $result) {
        if ($result['distance'] === 'medium') {
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
    }
    ?>
    </table>

    <h3>Long distance</h3>
    <p>Average time: <?php echo $this->raceAvgTimes['long_distance_avg_finish_time']; ?></p>
    <table class="results-table">
        <tr class="results-row">
            <td>Full name</td>
            <td>Race time</td>
            <td>Placement</td>
            <td></td>
        </tr>
    <?php
    foreach ($this->race['0'] as $result) {
        if ($result['distance'] === 'long') {
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
    }
    ?>
    </table>
    <a class="button save-button" id="save-button" href="<?php $previous; ?>">Save changes</a>
    <a class="button back-button" href="<?php $previous; ?>">Import new race results</a>
</div>