<!DOCTYPE html>

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/pokedex.css">
    <link rel="stylesheet" href="../css/types.css">
    <link rel="stylesheet" href="../css/report.css">
    <script src="../js/pc_box.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
</head>

<body>
    <div class="navbar">
        <a class="navbar-item" href="./pokedex.php">Pokedex</a>
        <a class="navbar-item" href="./pcbox.php">PC Box</a>
        <a class="navbar-item" href="./matchups.php">Matchups</a>
    </div>
    <form>
        <div class="row">
            <label for="sort">Sort: </label>
            <select id="sort" name="sort" class="party_title">
                <option value="Sort By" disabled>Sort By</option>
                <option value="name asc">Name Asc</option>
                <option value="name desc">Name Desc</option>
                <option value="number asc" default>Number Asc</option>
                <option value="number desc">Number Desc</option>
            </select>
            <label for="type">Type:</label>
            <select id="type" name="type" class="party_title">
                <option value="none" default>All Types</option>
                <option value=" Normal   ">Normal </option>
                <option value=" Fighting ">Fighting </option>
                <option value=" Flying   ">Flying </option>
                <option value=" Poison   ">Poison </option>
                <option value=" Ground   ">Ground </option>
                <option value=" Rock     ">Rock </option>
                <option value=" Bug      ">Bug </option>
                <option value=" Ghost    ">Ghost </option>
                <option value=" Steel    ">Steel </option>
                <option value=" Fire     ">Fire </option>
                <option value=" Water    ">Water </option>
                <option value=" Grass    ">Grass </option>
                <option value=" Electric ">Electric </option>
                <option value=" Psychic  ">Psychic </option>
                <option value=" Ice      ">Ice </option>
                <option value=" Dragon   ">Dragon </option>
            </select>
            <a class="party_title" href="./pokedex.php">View Pokedex</a>
        </div>
    </form>
    <div class="report_card">
        <table class="" id="table">
            <thead>
                <th>Number</th>
                <th>Sprite</th>
                <th>Name</th>
                <th>Type 1</th>
                <th>Type 2</th>
                <th>Evolves From</th>
                <th>Evolves Into</th>
            </thead>
            <tbody>
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

                $sql = "SELECT ps.pokemon_species_id, ps.pokemon_species_name, ps.evolves_from, ps.evolves_into, 
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
                FROM pokemon_species ps, pokemon_types pt
                WHERE pt.pokemon_species_id = ps.pokemon_species_id
                GROUP BY ps.pokemon_species_id
                ORDER BY ps.pokemon_species_id;";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $number = sprintf('%03d', $row['pokemon_species_id']);
                        echo "<tr>
                            <td class=\"table-cell\">#{$number}</td>
                            <td>
                                <img class=\"table-image\" src=\"../img/pkmn_{$number}.png\">
                            </td>
                            <td class=\"table-call\">{$row['pokemon_species_name']}</td>
                            <td class=\"table-call {$row['type_1']}\">{$row['type_1']}</td>
                            <td class=\"table-call {$row['type_2']}\">{$row['type_2']}</td>
                            <td class=\"table-call\">{$row['evolves_from']}</td>
                            <td class=\"table-call\">{$row['evolves_into']}</td>
                            </tr>";
                    }
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>