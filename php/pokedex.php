<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="../css/pokedex.css">
    <link rel="stylesheet" href="../css/types.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
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
            <a class="party_title" href="./pokedex_report.php">View Report</a>
        </div>
    </form>
    <div class="card-grid">
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

        $sql = "SELECT ps.pokemon_species_name, ps.pokemon_species_id, t.types_name 
            FROM pokemon_species ps, pokemon_types pt, types t 
            WHERE pt.pokemon_species_id = ps.pokemon_species_id
            AND t.types_id = pt.types_id
            AND pt.type_slot = 1
            ORDER BY ps.pokemon_species_id;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $number = sprintf('%03d', $row['pokemon_species_id']);
                echo "<div class=\"card {$row['types_name']}   \">
                <div class=\"pokemon_name\">{$row['pokemon_species_name']}</div>
                <div class=\"number\">#{$number}</div>
                <img class=\"pokemon_image\" src=\"../img/pkmn_{$number}.png\">
            </div>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
    </div>
</body>