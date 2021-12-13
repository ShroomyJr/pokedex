<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="../css/status.css">
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
$sql = "
Select
tr.Trainer_Name,
p.Pokemon_Name,
p.Pokemon_Level,
p.Pokemon_Gender,
ps.Pokemon_Species_Name,
ps.Pokemon_Species_Description,
ps.Pokemon_Species_ID,
(
    SELECT
        t.types_name
    FROM
        types t
    WHERE
        pt.type_slot = 1
        AND pt.types_id = t.types_id
) AS type_1,
Max(
    (
        SELECT
            t.types_name
        FROM
            types t
        WHERE
            pt.type_slot = 2
            AND pt.types_id = t.types_id
    )
) AS type_2,
(
    Select
        Concat(m.Move_Name, ';', m.Move_PP, ';', t.types_Name)
    From
        Pokemon_moves pm,
        Moves m,
        Types t
    WHERE
        pm.Move_Slot = 1
        AND pm.Pokemon_ID = p.Pokemon_ID
        AND pm.Moves_ID = m.Moves_ID
        AND t.Types_ID = m.Types_ID
) AS move_1,
(
    Select
        Concat(m.Move_Name, ';', m.Move_PP, ';', t.types_Name)
    From
        Pokemon_moves pm,
        Moves m,
        Types t
    WHERE
        pm.Move_Slot = 2
        AND pm.Pokemon_ID = p.Pokemon_ID
        AND pm.Moves_ID = m.Moves_ID
        AND t.Types_ID = m.Types_ID
) AS move_2,
(
    Select
        Concat(m.Move_Name, ';', m.Move_PP, ';', t.types_Name)
    From
        Pokemon_moves pm,
        Moves m,
        Types t
    WHERE
        pm.Move_Slot = 3
        AND pm.Pokemon_ID = p.Pokemon_ID
        AND pm.Moves_ID = m.Moves_ID
        AND t.Types_ID = m.Types_ID
) AS move_3,
(
    Select
        Concat(m.Move_Name, ';', m.Move_PP, ';', t.types_Name)
    From
        Pokemon_moves pm,
        Moves m,
        Types t
    WHERE
        pm.Move_Slot = 4
        AND pm.Pokemon_ID = p.Pokemon_ID
        AND pm.Moves_ID = m.Moves_ID
        AND t.Types_ID = m.Types_ID
) AS move_4
FROM
Pokemon p,
Pokemon_Species ps,
pokemon_types pt,
Trainers tr
WHERE
p.Pokemon_ID = {$_GET['pokemon-id']}
AND p.Pokemon_Species_ID = ps.Pokemon_Species_ID
AND pt.pokemon_species_id = ps.pokemon_species_id
AND p.Trainer_ID = tr.Trainer_ID
GROUP BY
ps.pokemon_species_id
ORDER BY
ps.pokemon_species_id
LIMIT
1;";
$result = $conn->query($sql);
$pokemon = $result->fetch_assoc();
$number = sprintf('%03d', $pokemon['Pokemon_Species_ID']);
print_r($result->fetch_assoc());
?>

<body>
    <div class="navbar">
        <a class="navbar-item" href="./pokedex.php">Pokedex</a>
        <a class="navbar-item" href="./pcbox.php">PC Box</a>
        <a class="navbar-item" href="./matchups.php">Matchups</a>
    </div>
    <div class="row">
        <div class="col sprite_col">
            <div class="lvl">Lv.<?php echo $pokemon['Pokemon_Level'] ?></div>
            <div class="name"><?php echo $pokemon['Pokemon_Name'] ?></div>
            <div class="sprite_box">
                <img src="../img/pkmn_<?php echo $number ?>.png">
            </div>
        </div>
        <div class="col moves_col">
            <div class="move_slot">
                <?php list($move_1_name, $move_1_pp, $move_1_type) = explode(";", $pokemon['move_1']); ?>
                <div class="move_name"><?php echo $move_1_name ?></div>
                <div class="move_pp">PP <?php echo $move_1_pp ?></div>
                <div class="move_type <?php echo $move_1_type ?>"><?php echo $move_1_type ?></div>
            </div>
            <div class="move_slot">
                <?php list($move_2_name, $move_2_pp, $move_2_type) = explode(";", $pokemon['move_2']); ?>
                <div class="move_name"><?php echo $move_2_name ?></div>
                <div class="move_pp">PP <?php echo $move_2_pp ?></div>
                <div class="move_type <?php echo $move_2_type ?>"><?php echo $move_2_type ?></div>
            </div>
            <div class="move_slot">
                <?php list($move_3_name, $move_3_pp, $move_3_type) = explode(";", $pokemon['move_3']); ?>
                <div class="move_name"><?php echo $move_3_name ?></div>
                <div class="move_pp">PP <?php echo $move_3_pp ?></div>
                <div class="move_type <?php echo $move_3_type ?>"><?php echo $move_3_type ?></div>
            </div>
            <div class="move_slot">
                <?php list($move_4_name, $move_4_pp, $move_4_type) = explode(";", $pokemon['move_4']); ?>
                <div class="move_name"><?php echo $move_4_name ?></div>
                <div class="move_pp">PP <?php echo $move_4_pp ?></div>
                <div class="move_type <?php echo $move_4_type ?>"><?php echo $move_4_type ?></div>
            </div>
        </div>
    </div>
    <div class="info_box">
        <div class="row">
            <div class="col">
                <div class="info">
                    <div class="info_tag">No: </div>
                    <div class="info_text">#<?php echo $number ?></div>
                </div>
                <div class="info">
                    <div class="info_tag">Name:</div>
                    <div class="info_text"><?php echo $pokemon['Pokemon_Name'] ?></div>
                </div>
                <div class="info">
                    <div class="info_tag">Type 1:</div>
                    <div class="info_text"><?php echo $pokemon['type_1'] ?></div>
                </div>
            </div>
            <div class="col">
                <div class="info">
                    <div class="info_tag">Trainer: </div>
                    <div class="info_text"><?php echo $pokemon['Trainer_Name'] ?></div>
                </div>
                <div class="info">
                    <div class="info_tag">Gender:</div>
                    <div class="info_text"><?php echo $pokemon['Pokemon_Gender'] ?></div>
                </div>
                <div class="info">
                    <div class="info_tag">Type 2:</div>
                    <div class="info_text"><?php echo $pokemon['type_2'] ?></div>
                </div>
            </div>
        </div>
        <div class="description">
            <?php echo $pokemon['Pokemon_Species_Description'] ?>
        </div>
    </div>
</body>