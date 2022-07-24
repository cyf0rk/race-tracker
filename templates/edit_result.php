<div class="race-tracker-wrapper">
    <h1>Edit result</h1>
    <form class="race-form edit-form" action="/test-project/display-results" method="POST" onsubmit="return validateInput()">
        <label class="race-name-label" for="race-name" onfocusout="validateInput()">Racer full name:<br/>
            <input type="text" name="full-name" id="full-name" value="<?php echo $this->result['full_name'] ?>" required>
        </label>
        <label class="date-label" for="date">Racer time:<br/>
            <input type="text" name="race-time" id="race-time" value="<?php echo $this->result['race_time'] ?>" required>
        </label>
        <input type="text" name="result-id" id="result-id" value="<?php echo $this->result['id'] ?>" required>
        <input type="submit" name="result-edit-submit" id="submit-button" value="Submit"/>
    </form>
</div>