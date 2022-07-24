<div class="race-tracker-wrapper">
    <h1>Race results</h1>
    <form class="edit-result-request-form" action="/test-project/edit-result" method="POST">
        <input type="number" name="id" id="result-id" required>
        <div class="results-wrapper">
            <h2>Race Title: <?php echo $this->race['race_info']['race_name']; ?></h2>
            <p>Race date: <?php echo $this->race['race_info']['race_date']; ?></p>
            <h3>Medium distance</h3>
            <p>Average time: <?php echo $this->raceAvgTimes['medium_distance_avg_finish_time']; ?></p>
            <table class="results-table">
                <tr class="results-row">
                    <th>Full name</th>
                    <th>Race time</th>
                    <th>Placement</th>
                    <th></th>
                </tr>
            <?php
            foreach ($this->race['results'] as $result) {
                if ($result['distance'] === 'medium') {
                    ?>
                    <tr class="results-row">
                        <td contenteditable="false"><?php echo $result['full_name']; ?></td>
                        <td contenteditable="false"><?php echo $result['race_time']; ?></td>
                        <td><?php echo $result['placement']; ?></td>
                        <td>
                            <button class="result-edit-button" value="<?php echo $result['id']; ?>">Edit</button>
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
                    <th>Full name</th>
                    <th>Race time</th>
                    <th>Placement</th>
                    <th></th>
                </tr>
            <?php
            foreach ($this->race['results'] as $result) {
                if ($result['distance'] === 'long') {
                    ?>
                    <tr class="results-row">
                        <td contenteditable="false"><?php echo $result['full_name']; ?></td>
                        <td contenteditable="false"><?php echo $result['race_time']; ?></td>
                        <td><?php echo $result['placement']; ?></td>
                        <td>
                            <button class="result-edit-button" value="<?php echo $result['id']; ?>">Edit</button>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
            </table>
            <a class="button back-button" href="<?php echo getenv('APP_ROOT_PATH'); ?>">Import new race results</a>
        </div>
        <input type="submit" name="edit-request-submit" id="edit-request-submit" value="Edit"/>
    </form>
</div>
<script src="public/js/editResult.js" defer></script>