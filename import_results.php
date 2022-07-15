<?php ?>
<form action="results.php" method="post" enctype="multipart/form-data">
    <label for="race-name">Race name:<br/></label>
    <input type="text" name="race-name" required><br/>
    <label for="date">Choose race date:<br/></label>
    <input type="date" name="date" required><br/>
    <label for="csv-file">Upload csv file:<br/></label>
    <input type="file" name="csv-file" required><br/>
    <input type="submit" name="submit" value="Submit" />
</form>