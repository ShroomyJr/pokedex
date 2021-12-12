<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="../css/matchups.css">
    <link rel="stylesheet" href="../css/types.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>

<body>
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
    <div class="navbar">
        <a class="navbar-item" href="./pokedex.php">Pokedex</a>
        <a class="navbar-item" href="./pcbox.html">PC Box</a>
        <a class="navbar-item" href="./matchups.php">Matchups</a>
    </div>
    <header>Matchups</header>
    <table>
        <caption>Type Matchups</caption>
        <tr>
            <thead>
                <th scope="col" style="background-color: blueviolet;"> TYPE </th>
                <?php 
                $sql = "SELECT types_name FROM types";
                $result = $conn->query($sql);
                $types[] = [];
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $types[] = $row['types_name'];
                        echo "<th scope=\"col\" class=\"{$row['types_name']}\">{$row['types_name']}</th>";
                    }
                }
                ?>
            </thead>
            <tbody>
                <?php

                $sql = "
                    SELECT (
                    SELECT t.types_name
                    FROM types t
                    WHERE tm.attacking_types_id = t.types_id
                    ) AS type_1, 
                    (
                    SELECT t.types_name
                    FROM types t
                    WHERE tm.defending_types_id = t.types_id
                    ) AS type_2, 
                    tm.modifier
                    FROM types_matchups tm;";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // output data of each row
                    $row_header = "";
                    while ($row = $result->fetch_assoc()) {
                        if ($row['type_1'] != $row_header) {
                            $row_header = $row['type_1'];
                            echo "<tr><th scope=\"row\" class=\"{$row_header}\">{$row_header}</th>";
                        }
                        echo "<td>{$row['modifier']}</td>";
                    }
                }
                $conn->close();
                ?>
                <!-- <tr><th scope="row" style="background-color: #A8A77A;"> Normal   </th><td>x1</td><td class="weak">x.5</td><td class="strong">x2</td><td class="none">x0</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td>x1</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td></tr>
            <tr><th scope="row" style="background-color: #C22E28;"> Fighting </th><td>x1</td><td class="weak">x.5</td><td class="strong">x2</td><td class="none">x0</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td>x1</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td></tr>
            <tr><th scope="row" style="background-color: #A98FF3;"> Flying   </th><td>x1</td><td class="weak">x.5</td><td class="strong">x2</td><td class="none">x0</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td>x1</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td></tr>
            <tr><th scope="row" style="background-color: #A33EA1;"> Poison   </th><td>x1</td><td class="weak">x.5</td><td class="strong">x2</td><td class="none">x0</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td>x1</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td></tr>
            <tr><th scope="row" style="background-color: #E2BF65;"> Ground   </th><td>x1</td><td class="weak">x.5</td><td class="strong">x2</td><td class="none">x0</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td>x1</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td></tr>
            <tr><th scope="row" style="background-color: #B6A136;"> Rock     </th><td>x1</td><td class="weak">x.5</td><td class="strong">x2</td><td class="none">x0</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td>x1</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td></tr>
            <tr><th scope="row" style="background-color: #A6B91A;"> Bug      </th><td>x1</td><td class="weak">x.5</td><td class="strong">x2</td><td class="none">x0</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td>x1</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td></tr>
            <tr><th scope="row" style="background-color: #735797;"> Ghost    </th><td>x1</td><td class="weak">x.5</td><td class="strong">x2</td><td class="none">x0</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td>x1</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td></tr>
            <tr><th scope="row" style="background-color: #B7B7CE;"> Steel    </th><td>x1</td><td class="weak">x.5</td><td class="strong">x2</td><td class="none">x0</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td>x1</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td></tr>
            <tr><th scope="row" style="background-color: #EE8130;"> Fire     </th><td>x1</td><td class="weak">x.5</td><td class="strong">x2</td><td class="none">x0</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td>x1</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td></tr>
            <tr><th scope="row" style="background-color: #6390F0;"> Water    </th><td>x1</td><td class="weak">x.5</td><td class="strong">x2</td><td class="none">x0</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td>x1</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td></tr>
            <tr><th scope="row" style="background-color: #7AC74C;"> Grass    </th><td>x1</td><td class="weak">x.5</td><td class="strong">x2</td><td class="none">x0</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td>x1</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td></tr>
            <tr><th scope="row" style="background-color: #F7D02C;"> Electric </th><td>x1</td><td class="weak">x.5</td><td class="strong">x2</td><td class="none">x0</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td>x1</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td></tr>
            <tr><th scope="row" style="background-color: #F95587;"> Psychic  </th><td>x1</td><td class="weak">x.5</td><td class="strong">x2</td><td class="none">x0</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td>x1</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td></tr>
            <tr><th scope="row" style="background-color: #96D9D6;"> Ice      </th><td>x1</td><td class="weak">x.5</td><td class="strong">x2</td><td class="none">x0</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td>x1</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td></tr>
            <tr><th scope="row" style="background-color: #6F35FC;"> Dragon   </th><td>x1</td><td class="weak">x.5</td><td class="strong">x2</td><td class="none">x0</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td>x1</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td><td class="weak">x.5</td><td>x1</td><td class="strong">x2</td></tr> -->
            </tbody>
    </table>
</body>