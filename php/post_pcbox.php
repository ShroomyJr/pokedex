<?php
// Handle AJAX request (start)
if (isset($_POST['ajax']) && isset($_POST['action'])) {

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

    $action = $_POST['action'];
    if ($action == 'name' && isset($_POST['new_name'])) {
        echo $_POST['new_name'];
    } elseif ($action == 'release') {
        $sql = "DELETE FROM pokemon WHERE trainer_id = {$_SESSION['Trainer_ID']} AND  pokemon_id = {$_POST['pokemon_id']};";
        if ($conn->query($sql) == TRUE && $con->affected_rows > 0) {
            echo "Pokemon Released";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    } elseif ($action == 'add') {
        $conn->autocommit(FALSE);
        $result = $conn->query("SELECT COUNT(*) AS slots FROM party_pokemon WHERE Trainer_ID = {$_SESSION['Trainer_ID']}");
        $slots = $result->fetch_assoc()['slots'];
        if ($slots < 6) {
            $slot = $slots + 1;
            $conn->query("INSERT INTO party_pokemon (Trainer_ID, Pokemon_ID, Party_Slot)  VALUES ({$_SESSION['Trainer_ID']}, {$_POST['pokemon_id']}, {$slot})");
            $conn->commit();
        } else {
            $conn->rollback();
        }
        $conn->autocommit(TRUE);
    } elseif ($action == 'remove') {
        $sql = "DELETE FROM party_pokemon WHERE trainer_id = {$_SESSION['Trainer_ID']} AND  pokemon_id = {$_POST['pokemon_id']}";
        if ($conn->query($sql) == TRUE && $con->affected_rows > 0) {
            echo "Party Pokemon Deleted";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
    echo $_POST['action'] . $_POST['pokemon_id'];
    exit;
}
// Handle AJAX request (end)
