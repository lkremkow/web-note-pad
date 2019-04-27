<?php

if (isset($_GET["id"])) {
  $note_id=htmlspecialchars($_GET["id"]);  
}
if (isset($_GET["name"])) {
  $note_name=urldecode(htmlspecialchars($_GET["name"]));  
}

$data = new SQLite3('data.sqlite', SQLITE3_OPEN_READWRITE);

if (is_numeric($note_id)) {
  $delete_note_statement = $data->prepare('DELETE FROM "notes" WHERE "id" = ? AND "name" = ?');

  $delete_note_statement->bindValue(1, $note_id);
  $delete_note_statement->bindValue(2, $note_name);

  $delete_note_result = $delete_note_statement->execute();
  $delete_note_result->finalize(); 
}

$data->close();

include 'header.php';

include 'navigation.php';

echo "<h1>Deleted " . $note_name . "</h1>";

include 'footer.php';

?>
