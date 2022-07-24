<div class="race-tracker-wrapper">
    <h1>Check race results</h1>
    <form class="race-form import-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" onsubmit="return validateInput()">
        <p>* required field</p>
        <label class="race-name-label" for="race-name" onfocusout="validateInput()">Race name *: <span class="error"><?php if (!empty($this->errors['race-name-err'])) echo $this->errors['race-name-err']; ?></span><br/>
            <input type="text" name="race-name" id="race-name" value="<?php echo htmlspecialchars($_POST['race-name']); ?>"><br/>
        </label>
        <label class="date-label" for="date">Choose race date *: <span class="error"><?php if (!empty($this->errors['date-err'])) echo $this->errors['date-err']; ?></span><br/>
            <input type="date" name="date" id="date" min="2000-01-01" max="<?php echo date('Y-m-d'); ?>" value="<?php echo htmlspecialchars($_POST['date']); ?>"><br/>
        </label>
        <label class="csv-file-label" for="csv-file">Upload csv file *: <span class="error"><?php if (!empty($this->errors['file-err'])) echo $this->errors['file-err']; ?></span><br/>
            <input type="file" name="csv-file" id="csv-file"><br/>
        </label>
        <input type="submit" name="submit" id="submit-button" value="Submit"/>
    </form>
</div>