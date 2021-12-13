<?php
// Handle AJAX request (start)
if( isset($_POST['ajax']) && isset($_POST['name']) ){
 echo $_POST['name'] . $_POST['pokemon_species_id'];
 exit;
}
// Handle AJAX request (end)
