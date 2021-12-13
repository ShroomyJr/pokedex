<!DOCTYPE html>

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="../js/pc_box.js"></script>
    <link rel="stylesheet" href="../css/pc_box.css">
    <link rel="stylesheet" href="../css/types.css">
    <link rel="stylesheet" href="../css/report.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
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
print_r($_SESSION['Trainer_Name']);
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
            $sql = "SELECT p.pokemon_name, p.pokemon_level, p.pokemon_species_id
                FROM pokedex.party_pokemon pp, pokedex.pokemon p 
                WHERE pp.Trainer_ID = {$_SESSION['Trainer_ID']} AND pp.Pokemon_ID = p.Pokemon_ID";
            $result = $conn->query($sql);
            for ($i = 1; $i <= 6; $i++) {
                if ($pokemon = $result->fetch_assoc()) {
                    $number = sprintf('%03d', $pokemon['pokemon_species_id']);
                    echo "<div name=\"slot{$i}\" class=\"slot\">
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
            <form class="row">
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
                    <option default value="level asc">Level Asc</option>
                    <option value="level desc">Level Desc</option>
                    <option value="name asc">Name Asc</option>
                    <option value="name desc">Name Desc</option>
                    <option value="number asc">Number Asc</option>
                    <option value="number desc">Number Desc</option>
                </select>
                <a class="box_title" href="./pcbox.php">View Box</a>
            </form>
            <div class="report_card">
                <table class="" id="table">
                    <thead>
                        <th>Number</th>
                        <th>Sprite</th>
                        <th>Name</th>
                        <th>Level</th>
                        <th>Type 1</th>
                        <th>Type 2</th>
                        <th>Male/Female</th>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT p.pokemon_species_id, p.pokemon_name, p.pokemon_level, p.pokemon_gender,
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
                        FROM pokemon p, pokemon_species ps, pokemon_types pt
                        WHERE trainer_id = {$_SESSION['Trainer_ID']}
                        AND p.pokemon_species_id = ps.pokemon_species_id
                        AND pt.pokemon_species_id = ps.pokemon_species_id
                        GROUP BY ps.pokemon_species_id
                        ORDER BY ps.Pokemon_Species_ID");
                        if ($result->num_rows > 0) {
                            while ($pokemon = $result->fetch_assoc()) {
                                $number = sprintf('%03d', $pokemon['pokemon_species_id']);
                                $type_2 = $pokemon['type_2'] ? $pokemon['type_2'] : 'None';
                                echo "<tr>
                                        <td class=\"table-cell\">#{$number}</td>
                                        <td>
                                            <img class=\"table-image\" src=\"../img/pkmn_{$number}.png\">
                                        </td>
                                        <td class=\"table-cell\">{$pokemon['pokemon_name']}</td>
                                        <td class=\"table-cell\">{$pokemon['pokemon_level']}</td>
                                        <td class=\"table-cell {$pokemon['type_1']}  \">{$pokemon['type_1']} </td>
                                        <td class=\"table-cell {$type_2}  \">{$type_2} </td>
                                        <td class=\"table-cell\">{$pokemon['pokemon_gender']}</td>
                                    </tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>