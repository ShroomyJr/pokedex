<!-- This page will randomly retreive a pokemon with random moves 
thereby adding a new pokemon to the DB under that trainers name-->
<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="../css/catch.css">
    <link rel="stylesheet" href="../css/types.css">
    <link rel="stylesheet" href="../css/party.css">
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

if (isset($_POST['Submit'])) {
    $genders = array("Male", "Female");
    $rand_gender = array_rand($genders);
    // Add pokemon assigned to trainer if form is submitted
    $sql = "INSERT INTO Pokemon (
        Pokemon_Name, Pokemon_Level, Pokemon_Gender, Pokemon_Health, Pokemon_Species_ID, Trainer_ID
    ) VALUES (
        \"{$_POST['pokemon_name']}\", \"{$_POST['level']}\", \"{$genders[$rand_gender]}\", 
        \"{$_POST['health']}\", \"{$_POST['pokemon_id']}\", \"{$_SESSION['trainer_id']}\"
    )";
    $result = $conn->query($sql);
    $pokemon_id = $conn->insert_id;
    // Start transaction to add to party
    $conn->autocommit(FALSE);
    $result = $conn->query("SELECT COUNT(*) FROM party_pokemon WHERE Trainer_ID = {$_SESSION['trainer_id']}");
    if ($result->num_rows < 6) {
        $slot = $result->num_rows + 1;
        $conn->query("INSERT INTO party_pokemon (Trainer_ID, Pokemon_ID, Party_Slot)  VALUES ({$_SESSION['trainer_id']}, {$pokemon_id}, {$slot})");
        $conn->commit();
    } else {
        $conn->rollback();
    }
    $conn->autocommit(TRUE);
}
?>

<body>
    <div class="navbar">
        <a class="navbar-item" href="./pokedex.php">Pokedex</a>
        <a class="navbar-item" href="./pcbox.php">PC Box</a>
        <a class="navbar-item" href="./matchups.php">Matchups</a>
    </div>
    <div class="row">
        <form class="col" action="" method="POST">
            <?php
            $sql = "SELECT ps.pokemon_species_id, ps.pokemon_species_name, 
            FLOOR(RAND()*(100-1)+1) AS Level, 
            FLOOR(RAND()*(100-1)*2+1) AS Health,
            (
            SELECT t.types_name
            FROM types t
            WHERE pt.type_slot = 1
            AND pt.types_id = t.types_id
            ) AS type_1, 
            Max((
            SELECT t.types_name
            FROM types t
            WHERE pt.type_slot = 2
            AND pt.types_id = t.types_id
            )) AS type_2
            FROM (
                SELECT * FROM pokemon_species
                ORDER BY RAND()
                LIMIT 1
            ) as ps, pokemon_types pt
            WHERE pt.pokemon_species_id = ps.pokemon_species_id
            ORDER BY RAND() LIMIT 1;";
            $result = $conn->query($sql);
            $pokemon = $result->fetch_assoc();
            $number = sprintf('%03d', $pokemon['pokemon_species_id']);
            ?>
            <div class="battle_arena">
                <img src="../img/pkmn_<?php echo $number ?>.png" class="pokemon_image">
                <div class="pokemon_tag">
                    <?php
                    if ($result->num_rows > 0) {
                        echo "<div class=\"pokemon_name\">{$pokemon['pokemon_species_name']}</div>
                        <div class=\"lv\">Lv.{$pokemon['Level']}</div>
                        <div class=\"row\">
                            <div class=\"type {$pokemon['type_1']}\">{$pokemon['type_1']}</div>
                            <div class=\"type {$pokemon['type_2']}\">{$pokemon['type_2']}</div>
                        </div>
                        <input hidden name=\"pokemon_id\" value=\"{$pokemon['pokemon_species_id']}\">
                        <input hidden name=\"pokemon_name\" value=\"{$pokemon['pokemon_species_name']}\">
                        <input hidden name=\"health\" value=\"{$pokemon['Health']}\">
                        <input hidden name=\"level\" value=\"{$pokemon['Level']}\">
                        ";
                    }
                    ?>
                </div>
            </div>
            <div class="moves_box">
                <?php
                $sql = "SELECT m.moves_id, m.move_name, m.move_pp, t.types_id, t.types_name
                    FROM moves m, types t
                    WHERE m.Types_ID = t.types_ID
                    AND (t.types_name = \"Psychic\" OR t.types_name = \"Water\")
                    ORDER BY RAND()
                    LIMIT 4;";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // output data of each row
                    $row = $result->fetch_assoc();
                    echo "<div class=\"row\">
                            <div class=\"move\">
                                <div class=\"name\">{$row['move_name']}</div>
                                <div class=\"pp\">PP. {$row['move_pp']}</div>
                                <div class=\"move_type {$row['types_name']}\">{$row['types_name']}</div>
                            </div>
                            <input hidden name=\"moves_id[]\" value=\"{$row['moves_id']}\">";
                    $row = $result->fetch_assoc();
                    echo "<div class=\"move\">
                            <div class=\"name\">{$row['move_name']}</div>
                            <div class=\"pp\">PP. {$row['move_pp']}</div>
                            <div class=\"move_type {$row['types_name']}\">{$row['types_name']}</div>
                            </div>
                        </div>
                        <input hidden name=\"moves_id[]\" value=\"{$row['moves_id']}\">";
                    $row = $result->fetch_assoc();
                    echo "<div class=\"row\">
                            <div class=\"move\">
                                <div class=\"name\">{$row['move_name']}</div>
                                <div class=\"pp\">PP. {$row['move_pp']}</div>
                                <div class=\"move_type {$row['types_name']}\">{$row['types_name']}</div>
                            </div>
                            <input hidden name=\"moves_id[]\" value=\"{$row['moves_id']}\">";
                    $row = $result->fetch_assoc();
                    echo "<div class=\"move\">
                                <div class=\"name\">{$row['move_name']}</div>
                                <div class=\"pp\">PP. {$row['move_pp']}</div>
                                <div class=\"move_type {$row['types_name']}\">{$row['types_name']}</div>
                            </div>
                            </div>
                            <input hidden name=\"moves_id[]\" value=\"{$row['moves_id']}\">";
                }
                ?>
                <input type="submit" name="Submit" value="Add to Party">
            </div>
        </form>
        <div class="col">
            <div class="party_title"><?php echo $_SESSION['name'] ?>'s Party</div>
            <div class="party">
                <?php
                $sql = "SELECT p.pokemon_name, p.pokemon_level, p.pokemon_health, p.pokemon_species_id
                FROM pokedex.party_pokemon pp, pokedex.pokemon p 
                WHERE pp.Trainer_ID = {$_SESSION['trainer_id']} AND pp.Pokemon_ID = p.Pokemon_ID";
                $party_pokemon = $conn->query($sql);
                ?>
                <div class="col">
                    <div name="slot1" class="slot">
                        <?php
                        if ($party_pokemon->num_rows >= 1) {
                            $pokemon = $party_pokemon->fetch_assoc();
                            $number = sprintf('%03d', $pokemon['pokemon_species_id']);
                            echo "<img src=\"../img/pkmn_{$number}.png\">
                            <div class=\"party_pokemon_name\">{$pokemon['pokemon_name']}</div>
                            <div class=\"lvl\">Lv.{$pokemon['pokemon_level']}</div>
                            <progress id=\"health\" value=\"{$pokemon['pokemon_health']}\" ></progress>
                            <div class=\"health\"> {$pokemon['pokemon_health']} / {$pokemon['pokemon_health']}</div>";
                        }
                        ?>
                    </div>
                    <div name="slot3" class="slot">
                        <?php
                        if ($party_pokemon->num_rows >= 3) {
                            $pokemon = $party_pokemon->fetch_assoc();
                            $number = sprintf('%03d', $pokemon['pokemon_species_id']);
                            echo "<img src=\"../img/pkmn_{$number}.png\">
                            <div class=\"party_pokemon_name\">{$pokemon['pokemon_name']}</div>
                            <div class=\"lvl\">Lv.{$pokemon['pokemon_level']}</div>
                            <progress id=\"health\" value=\"{$pokemon['pokemon_health']}\" ></progress>
                            <div class=\"health\"> {$pokemon['pokemon_health']} / {$pokemon['pokemon_health']}</div>";
                        }
                        ?>
                    </div>
                    <div name="slot5" class="slot">
                        <?php
                        if ($party_pokemon->num_rows >= 5) {
                            $pokemon = $party_pokemon->fetch_assoc();
                            $number = sprintf('%03d', $pokemon['pokemon_species_id']);
                            echo "<img src=\"../img/pkmn_{$number}.png\">
                            <div class=\"party_pokemon_name\">{$pokemon['pokemon_name']}</div>
                            <div class=\"lvl\">Lv.{$pokemon['pokemon_level']}</div>
                            <progress id=\"health\" value=\"{$pokemon['pokemon_health']}\" ></progress>
                            <div class=\"health\"> {$pokemon['pokemon_health']} / {$pokemon['pokemon_health']}</div>";
                        }
                        ?>
                    </div>
                </div>
                <div class="col">
                    <div class="spacer"></div>
                    <div name="slot2" class="slot">
                        <?php
                        if ($party_pokemon->num_rows >= 2) {
                            $pokemon = $party_pokemon->fetch_assoc();
                            $number = sprintf('%03d', $pokemon['pokemon_species_id']);
                            echo "<img src=\"../img/pkmn_{$number}.png\">
                            <div class=\"party_pokemon_name\">{$pokemon['pokemon_name']}</div>
                            <div class=\"lvl\">Lv.{$pokemon['pokemon_level']}</div>
                            <progress id=\"health\" value=\"{$pokemon['pokemon_health']}\" ></progress>
                            <div class=\"health\"> {$pokemon['pokemon_health']} / {$pokemon['pokemon_health']}</div>";
                        }
                        ?>
                    </div>
                    <div name="slot4" class="slot">
                        <?php
                        if ($party_pokemon->num_rows >= 4) {
                            $pokemon = $party_pokemon->fetch_assoc();
                            $number = sprintf('%03d', $pokemon['pokemon_species_id']);
                            echo "<img src=\"../img/pkmn_{$number}.png\">
                            <div class=\"party_pokemon_name\">{$pokemon['pokemon_name']}</div>
                            <div class=\"lvl\">Lv.{$pokemon['pokemon_level']}</div>
                            <progress id=\"health\" value=\"{$pokemon['pokemon_health']}\" ></progress>
                            <div class=\"health\"> {$pokemon['pokemon_health']} / {$pokemon['pokemon_health']}</div>";
                        }
                        ?>
                    </div>
                    <div name="slot6" class="slot">
                        <?php
                        if ($party_pokemon->num_rows >= 6) {
                            $pokemon = $party_pokemon->fetch_assoc();
                            $number = sprintf('%03d', $pokemon['pokemon_species_id']);
                            echo "<img src=\"../img/pkmn_{$number}.png\">
                            <div class=\"party_pokemon_name\">{$pokemon['pokemon_name']}</div>
                            <div class=\"lvl\">Lv.{$pokemon['pokemon_level']}</div>
                            <progress id=\"health\" value=\"{$pokemon['pokemon_health']}\" ></progress>
                            <div class=\"health\"> {$pokemon['pokemon_health']} / {$pokemon['pokemon_health']}</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>