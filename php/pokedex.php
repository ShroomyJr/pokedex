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


$sort_orders = [
    "name asc" => 'pokemon_species_name ASC',
    "name desc" => 'pokemon_species_name DESC',
    "number asc" => 'pokemon_species_id ASC',
    "number desc" => 'pokemon_species_id DESC'
];
if (isset($_POST['sort'])) {
    // print_r($_POST['sort']);
    $order = $sort_orders[$_POST['sort']];
} else {
    $order = $sort_orders['number asc'];
};

if (isset($_POST['type']) && $_POST['type'] != 'All Types') {
    $type_filter = $_POST['type'];
    print_r($type_filter);
}

$types = $conn->query("SELECT types_name FROM types");
?>

<body>
    <div class="navbar">
        <a class="navbar-item" href="./pokedex.php">Pokedex</a>
        <a class="navbar-item" href="./pcbox.php">PC Box</a>
        <a class="navbar-item" href="./matchups.php">Matchups</a>
    </div>
    <form action="" method="POST">
        <div class="row">
            <label for="sort">Sort:</label>
            <select id="sort" name="sort" class="party_title">
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
            <label for="type">Type:</label>
            <select id="type" name="type" class="party_title">
                <option>All Types</option>
                <?php
                while ($type = $types->fetch_assoc()) {
                    if (isset($type_filter) && $type_filter == $type['types_name']) {
                        echo "<option default selected value=\"{$type['types_name']}\">{$type['types_name']}</option>";
                    } else {
                        echo "<option value=\"{$type['types_name']}\">{$type['types_name']}</option>";
                    }
                }
                ?>
            </select>
            <input class="party_title" type="submit" name="Submit" value="Select Filters">

            <a class="party_title" href="./pokedex_report.php">View Report</a>
        </div>
    </form>
    <div class="card-grid">
        <?php
        $type_filter_query = isset($type_filter) ? "AND t.types_name = \"{$type_filter}\"" : "";
        $sql = "SELECT ps.pokemon_species_name, ps.pokemon_species_id, t.types_name 
            FROM pokemon_species ps, pokemon_types pt, types t 
            WHERE pt.pokemon_species_id = ps.pokemon_species_id
            AND t.types_id = pt.types_id
            AND pt.type_slot = 1
            {$type_filter_query}
            ORDER BY ps.{$order};";
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