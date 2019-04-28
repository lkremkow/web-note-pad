<?php

if (isset($_GET["id"])) {
  $note_id=htmlspecialchars($_GET["id"]);  
}
if (isset($_GET["name"])) {
  $note_name=urldecode(htmlspecialchars($_GET["name"]));  
}

include 'db-secrets.php';
$data = new mysqli($hostname, $username, $password, $db_name);

if (is_numeric($note_id)) {

  $delete_note_statement = $data->prepare('DELETE FROM notes WHERE id = ? AND name = ?');
  
  $delete_note_statement->bind_param('is', $note_id, $note_name);
  $delete_note_statement->execute();
  $delete_note_statement->close();

}

$data->close();

include 'header.php';

include 'navigation.php';

echo "<h1>Deleted " . $note_name . "</h1>";

include 'footer.php';

?>
