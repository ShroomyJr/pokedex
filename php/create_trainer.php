<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/types.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>

<?php
$servername = "localhost";
$username = "user";
$password = "#DigitalMonsters1";
$dbname = "pokedex";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<body>
    <h1>Select a Trainer...</h1>
    <form action="pcbox.php" method="POST">
        <label for="trainer">Trainer:</label>
        <select name="trainer" class="box_title">
            <?php
            $sql = "SELECT Trainer_Name, Trainer_ID FROM TRAINERS";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<option value=\"{$row['Trainer_ID']}\">{$row['Trainer_Name']}</option>";
                }
            }
            ?>
            <!-- <option value="red">Red's Pokemon</option>
            <option value="jake">Jake's Pokemon</option>
            <option value="luke">Luke's Pokemon</option> -->
        </select>
        <input type="submit" name="Submit" value="select trainer">
    </form>
    <h1>or Create a Trainer!</h1>
    <form action="pcbox.php" method="POST">
        <label for="name">First, what is your name?</label><br>
        <input type="text" id="name" name="name"><br><br>
        <label>Do you want to be a ...</label>
        <div class="row">
            <div class="col">
                <img src="../img/hero.png"><br>
                <input type="radio" id="male" name="gender" value="male" checked>
                <label for="male">Boy</label>
            </div>
            <div class="col">
                <img src="../img/heroine.png"><br>
                <input type="radio" id="female" name="gender" value="female">
                <label for="female">Girl</label>
            </div>
        </div>
        <br>
        <input type="submit" name="Submit" value="create trainer">
    </form>
</body>