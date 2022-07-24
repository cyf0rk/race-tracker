<div class="race-tracker-wrapper">
    <h1>Edit result</h1>
    <form class="race-form edit-form" action="/test-project/edit-result" method="POST" onsubmit="return validateInput()">
        <label class="race-name-label" for="race-name" onfocusout="validateInput()">Racer full name: <span class="error"><?php if (!empty($this->errors['full_name-err'])) echo $this->errors['full_name-err']; ?></span><br/>
            <input type="text" name="full_name" id="full-name" value="<?php echo $this->result['full_name'] ?>" required>
        </label>
        <label class="date-label" for="date">Racer time: <span class="error"><?php if (!empty($this->errors['race_time-err'])) echo $this->errors['race_time-err']; ?></span><br/>
            <input type="text" name="race_time" id="race-time" value="<?php echo $this->result['race_time'] ?>" required>
        </label>
        <input type="text" name="id" id="result-id" value="<?php echo $this->result['id'] ?>" required>
        <input type="submit" name="result-edit-submit" id="submit-button" value="Submit"/>
    </form>
</div>