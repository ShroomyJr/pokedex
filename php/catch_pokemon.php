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
?>

<body>
    <div class="navbar">
        <a class="navbar-item" href="./pokedex.html">Pokedex</a>
        <a class="navbar-item" href="./pcbox.html">PC Box</a>
        <a class="navbar-item" href="./matchups.html">Matchups</a>
    </div>
    <div class="row">
        <div class="col">
            <?php
            $sql = "SELECT ps.pokemon_species_id, ps.pokemon_species_name, FLOOR(RAND()*(100-1)+1) AS Level,
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
                        </div>";
                    }
                    ?>
                </div>
            </div>
            <div class="moves_box">
                <?php
                $sql = "SELECT m.move_name, m.move_pp, t.types_id, t.types_name
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
                            </div>";
                    $row = $result->fetch_assoc();
                    echo "<div class=\"move\">
                            <div class=\"name\">{$row['move_name']}</div>
                            <div class=\"pp\">PP. {$row['move_pp']}</div>
                            <div class=\"move_type {$row['types_name']}\">{$row['types_name']}</div>
                            </div>
                            </div>";
                    $row = $result->fetch_assoc();
                    echo "<div class=\"row\">
                                <div class=\"move\">
                                <div class=\"name\">{$row['move_name']}</div>
                                <div class=\"pp\">PP. {$row['move_pp']}</div>
                                <div class=\"move_type {$row['types_name']}\">{$row['types_name']}</div>
                                </div>";
                    $row = $result->fetch_assoc();
                    echo "<div class=\"move\">
                                <div class=\"name\">{$row['move_name']}</div>
                                <div class=\"pp\">PP. {$row['move_pp']}</div>
                                <div class=\"move_type {$row['types_name']}\">{$row['types_name']}</div>
                                </div>
                                </div>";
                }
                ?>
                <input type="submit" value="Add to Party">
            </div>
        </div>
        <div class="col">
            <div class="party_title">Red's Party</div>
            <div class="party">
                <div class="col">
                    <div name="slot1" class="slot">
                        <img src="../img/pkmn_001.png">
                        <div class="party_pokemon_name">Bulbasoar</div>
                        <div class="lvl">Lv.30</div>
                        <progress id="health" value="80" max="112"></progress>
                        <div class="health"> 80 / 112</div>
                    </div>
                    <div name="slot3" class="slot">
                        <img src="../img/pkmn_039.png">
                        <div class="party_pokemon_name">Jigglypuff</div>
                        <div class="lvl">Lv.1</div>
                        <progress id="health" value="15" max="15"></progress>
                        <div class="health"> 15 / 15</div>
                    </div>
                    <div name="slot5" class="slot"></div>
                </div>
                <div class="col">
                    <div class="spacer"></div>
                    <div name="slot2" class="slot">
                        <img src="../img/pkmn_066.png">
                        <div class="party_pokemon_name">Machamp</div>
                        <div class="lvl">Lv.23</div>
                        <progress id="health" value="36" max="89"></progress>
                        <div class="health"> 36 / 89</div>
                    </div>
                    <div name="slot4" class="slot"></div>
                    <div name="slot6" class="slot"></div>
                </div>
            </div>
        </div>
    </div>
</body>