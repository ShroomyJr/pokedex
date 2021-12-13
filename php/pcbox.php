<!DOCTYPE html>
<?php
// Handle AJAX request (start)
if (isset($_POST['ajax']) && isset($_POST['name'])) {
    echo $_POST['name'];
    exit;
}
// Handle AJAX request (end)
?>

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../js/pc_box.js"></script>
    <link rel="stylesheet" href="../css/pc_box.css">
    <link rel="stylesheet" href="../css/types.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>

<?php
session_start();
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
if (isset($_POST['Submit']) && $_POST['Submit'] == 'Create Trainer') {
    $name = $_POST['name'];
    $gender = $_POST['gender'] == "male" ? "♂" : "♀";
    echo "Name: {$name}{$gender}";


    $create = "INSERT INTO TRAINERS (Trainer_Name, Trainer_Gender) VALUES (\"{$_POST['name']}\", \"{$_POST['gender']}\")";
    $create_result = $conn->query($create);
    $trainer_id = $conn->insert_id;

    $result = $conn->query("SELECT Trainer_Name, Trainer_Gender, Trainer_ID FROM TRAINERS WHERE TRAINERS.Trainer_ID = {$trainer_id} LIMIT 1");
    if ($result->num_rows > 0) {
        session_unset();
        $trainer = $result->fetch_assoc();
        $_SESSION["Trainer_Name"] = $trainer['Trainer_Name'];
        $_SESSION["Trainer_Gender"] = $trainer['Trainer_Gender'];
        $_SESSION["Trainer_ID"] = $trainer['Trainer_ID'];
        echo "New record created successfully";
        // echo ($trainer['Trainer_Name'] . $trainer['Trainer_Gender']);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} elseif (isset($_POST['Submit']) && $_POST['Submit'] == 'Select Trainer') {
    $trainer_id = $_POST['trainer'];
    $sql = "SELECT Trainer_Name, Trainer_Gender, Trainer_ID FROM TRAINERS WHERE TRAINERS.Trainer_ID = {$_POST['trainer']} LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        session_unset();
        $trainer = $result->fetch_assoc();
        $_SESSION["Trainer_Name"] = $trainer['Trainer_Name'];
        $_SESSION["Trainer_Gender"] = $trainer['Trainer_Gender'];
        $_SESSION["Trainer_ID"] = $trainer['Trainer_ID'];
        // echo ($trainer['Trainer_Name'] . "\t" . $trainer['Trainer_Gender']);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
}
$sort_orders = [
    'level asc' => 'pokemon_level ASC',
    'level desc' => 'pokemon_level DESC',
    "name asc" => 'pokemon_name ASC',
    "name desc" => 'pokemon_name DESC',
    "number asc" => 'pokemon_species_id ASC',
    "number desc" => 'pokemon_species_id DESC'
];
if (isset($_POST['sort'])) {
    // print_r($_POST['sort']);
    $order = $sort_orders[$_POST['sort']];
} else {
    $order = $sort_orders['level asc'];
};

// print_r($order);
// print_r($_SESSION['Trainer_Name']);
?>

<body>
    <div class="navbar">
        <a class="navbar-item" href="./pokedex.php">Pokedex</a>
        <a class="navbar-item" href="./pcbox.php">PC Box</a>
        <a class="navbar-item" href="./matchups.php">Matchups</a>
    </div>
    <div class="row">
        <div class="col party">
            <div class="party_title">Party</div>
            <?php
            $sql = "SELECT p.pokemon_name, p.pokemon_level, p.pokemon_species_id, p.pokemon_id
                FROM pokedex.party_pokemon pp, pokedex.pokemon p 
                WHERE pp.Trainer_ID = {$_SESSION['Trainer_ID']} AND pp.Pokemon_ID = p.Pokemon_ID";
            $result = $conn->query($sql);
            for ($i = 1; $i <= 6; $i++) {
                if ($pokemon = $result->fetch_assoc()) {
                    $number = sprintf('%03d', $pokemon['pokemon_species_id']);
                    echo "<div name=\"slot{$i}\" class=\"slot\" data-id=\"{$pokemon['pokemon_id']}\">
                    <img class=\"party_image\" src=\"../img/pkmn_{$number}.png\">
                    <div class=\"col\">
                        <div class=\"party_pokemon_name\">{$pokemon['pokemon_name']}</div>
                        <div class=\"lvl\">Lv.{$pokemon['pokemon_level']}</div>
                    </div>
                </div>";
                } else {
                    echo " <div name=\"slot{$i}\" class=\"slot\"></div>";
                }
            }
            ?>
        </div>
        <div class="col">
            <form class="row" action="" method="POST">
                <label for="trainer">Trainer:</label>
                <select class="box_title" name="trainer">
                    <?php
                    echo "<option value=\"{$_SESSION['Trainer_ID']}\">{$_SESSION['Trainer_Name']}</option>";
                    $sql = "SELECT Trainer_Name, Trainer_ID FROM TRAINERS WHERE Trainer_ID != {$_SESSION['Trainer_ID']}";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=\"{$row['Trainer_ID']}\">{$row['Trainer_Name']}</option>";
                        }
                    }
                    ?>
                </select>
                <label for="sort">Sort:</label>
                <select id="sort" name="sort" class="box_title">
                    <option value="Sort By" disabled>Sort By</option>
                    <?php
                    foreach ($sort_orders as $key => $value) {
                        $capitalized = ucwords($key);
                        if ($value == $order) {
                            echo "<option default selected value=\"{$key}\">{$capitalized}</option>";
                        } else {
                            echo "<option value=\"{$key}\">{$capitalized}</option>";
                        }
                    }
                    ?>
                </select>
                <input class="box_title" type="submit" name="Submit" value="Select Trainer">
                <a class="box_title" href="./pcbox_report.php">View Report</a>
            </form>
            <div class="card-grid">
                <?php
                $result = $conn->query("SELECT pokemon_species_id, pokemon_id FROM pokemon p WHERE trainer_id = {$_SESSION['Trainer_ID']}
                    AND NOT EXISTS (SELECT * FROM party_pokemon pm WHERE pm.pokemon_id = p.pokemon_id) ORDER BY {$order}");
                if ($result->num_rows > 0) {
                    while ($pokemon = $result->fetch_assoc()) {
                        $number = sprintf('%03d', $pokemon['pokemon_species_id']);
                        echo "<div class=\"card\" data-id=\"{$pokemon['pokemon_id']}\">
                            <img class=\"box_image\" src=\"../img/pkmn_{$number}.png\">
                        </div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <a class="catch_pokemon" href="./catch_pokemon.php">
        <div class="catch_text">Catch A New Pokemon!</div>
    </a>
    <ul class='context-menu'>
        <li data-action="remove">Remove from party</li>
        <li data-action="add">Add to party</li>
        <li data-action="release">Release pokemon</li>
        <li data-action="status">Check status</li>
        <li data-action="rename">Change name</li>
    </ul>
</body>