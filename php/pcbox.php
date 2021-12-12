<!DOCTYPE html>

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

if (isset($_POST['Submit']) && $_POST['Submit'] == 'create trainer') {
    $name = $_POST['name'];
    $gender = $_POST['gender'] == "male" ? "♂" : "♀";
    echo "Name: {$name}{$gender}";


    $sql = "INSERT INTO TRAINERS (Trainer_Name, Trainer_Gender) VALUES (\"{$_POST['name']}\", \"{$_POST['gender']}\")";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $trainer = $result->fetch_assoc();
        $_SESSION["Trainer_Name"] = $trainer['Trainer_Name'];
        $_SESSION["Trainer_Gender"] = $trainer['Trainer_Gender'];
        $_SESSION["Trainer_ID"] = $trainer['Trainer_ID'];
        echo "New record created successfully";
        echo ($trainer['Trainer_Name'].$trainer['Trainer_Gender']);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} elseif (isset($_POST['Submit']) && $_POST['Submit'] == 'select trainer') {
    $trainer_id = $_POST['trainer'];
    $sql = "SELECT Trainer_Name, Trainer_Gender, Trainer_ID FROM TRAINERS WHERE TRAINERS.Trainer_ID = {$_POST['trainer']} LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $trainer = $result->fetch_assoc();
        $_SESSION["Trainer_Name"] = $trainer['Trainer_Name'];
        $_SESSION["Trainer_Gender"] = $trainer['Trainer_Gender'];
        $_SESSION["Trainer_ID"] = $trainer['Trainer_ID'];
        echo ($trainer['Trainer_Name']."\t".$trainer['Trainer_Gender']);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
else {
    $trainer = $_SESSION;
    echo $_SESSION['name'];
}
?>

<body>
    <div class="navbar">
        <a class="navbar-item" href="./pokedex.html">Pokedex</a>
        <a class="navbar-item" href="./pcbox.html">PC Box</a>
        <a class="navbar-item" href="./matchups.html">Matchups</a>
    </div>
    <div class="row">
        <div class="col party">
            <div class="party_title">Party</div>
            <div name="slot1" class="slot">
                <img class="party_image" src="../img/pkmn_001.png">
                <div class="col">
                    <div class="party_pokemon_name">Bulbasoar</div>
                    <div class="lvl">Lv.30</div>
                </div>
            </div>
            <div name="slot2" class="slot">
                <img class="party_image" src="../img/pkmn_066.png">
                <div class="party_pokemon_name">Machamp</div>
                <div class="lvl">Lv.23</div>
            </div>
            <div name="slot3" class="slot">
                <img class="party_image" src="../img/pkmn_039.png">
                <div class="party_pokemon_name">Jigglypuff</div>
                <div class="lvl">Lv.1</div>
            </div>
            <div name="slot4" class="slot"></div>
            <div name="slot5" class="slot"></div>
            <div name="slot6" class="slot"></div>
        </div>
        <div class="col">
            <form class="row">
                <label for="trainer">Trainer:</label>
                <select class="box_title" name="trainer">
                    <?php
                    echo "<option value=\"{$trainer['Trainer_ID']}\">{$trainer['Trainer_Name']}</option>";
                    $sql = "SELECT Trainer_Name, Trainer_ID FROM TRAINERS WHERE Trainer_ID != {$trainer['Trainer_ID']}";
                    $result = $conn->query($sql);
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
                    <option default value="level asc">Level Asc</option>
                    <option value="level desc">Level Desc</option>
                    <option value="name asc">Name Asc</option>
                    <option value="name desc">Name Desc</option>
                    <option value="number asc">Number Asc</option>
                    <option value="number desc">Number Desc</option>
                </select>
                <a class="box_title" href="./pcbox_report.html">View Report</a>
            </form>
            <div class="card-grid">
                <div class="card">
                    <img class="box_image" src="../img/pkmn_039.png">
                </div>
                <div class="card">
                    <img class="box_image" src="../img/pkmn_057.png">
                </div>
                <div class="card">
                    <img class="box_image" src="../img/pkmn_012.png">
                </div>
                <div class="card">
                    <img class="box_image" src="../img/pkmn_024.png">
                </div>
                <div class="card">
                    <img class="box_image" src="../img/pkmn_051.png">
                </div>
                <div class="card">
                    <img class="box_image" src="../img/pkmn_076.png">
                </div>
                <div class="card">
                    <img class="box_image" src="../img/pkmn_057.png">
                </div>
                <div class="card">
                    <img class="box_image" src="../img/pkmn_094.png">
                </div>
                <div class="card">
                    <img class="box_image" src="../img/pkmn_082.png">
                </div>
                <div class="card">
                    <img class="box_image" src="../img/pkmn_078.png">
                </div>
                <div class="card">
                    <img class="box_image" src="../img/pkmn_009.png">
                </div>
                <div class="card">
                    <img class="box_image" src="../img/pkmn_045.png">
                </div>
                <div class="card">
                    <img class="box_image" src="../img/pkmn_025.png">
                </div>
                <div class="card">
                    <img class="box_image" src="../img/pkmn_063.png">
                </div>
                <div class="card">
                    <img class="box_image" src="../img/pkmn_144.png">
                </div>
                <div class="card">
                    <img class="box_image" src="../img/pkmn_148.png">
                </div>
            </div>
        </div>
    </div>
    <a class="catch_pokemon" href="./catch_pokemon.html">
        <div class="catch_text">Catch A New Pokemon!</div>
    </a>
    <ul class='context-menu'>
        <li data-action="remove">Remove from party</li>
        <li data-action="add">Add to party</li>
        <li data-action="release">Release pokemon</li>
        <li data-action="status">Check status</li>
        <li data-action="name">Change name</li>
    </ul>
</body>