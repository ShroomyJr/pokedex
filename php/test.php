<!DOCTYPE html>
<html>

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

$sql = "SELECT pokemon_species_name FROM pokemon_species";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo $row['pokemon_species_name']. "<br>";
  }
} else {
  echo "0 results";
}
$conn->close();
?> 
</body>

</html>