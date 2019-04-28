<?php

date_default_timezone_set('UTC');

if (isset($_POST["note_id"])) {
  $note_id=htmlspecialchars($_POST["note_id"]);
} else {
  $note_id="";
}

if (isset($_POST["name"])) {
  $name=htmlspecialchars($_POST["name"]);
} else {
  $name="";
}

if (isset($_POST["text"])) {
  $text=htmlspecialchars($_POST["text"]);
} else {
  $text="";
}

include 'db-secrets.php';
$data = new mysqli($hostname, $username, $password, $db_name);

if ( $note_id == "" ) {

  $created_timestamp = time();
  $updated_timestamp = $created_timestamp;

  $note_id = $created_timestamp . random_int(10000, 99999);

  $insert_new_note_statement = $data->prepare('INSERT INTO notes (id, name, text, created, updated) VALUES (?, ?, ?, ?, ?)');
  
  $insert_new_note_statement->bind_param('issii', $note_id, $name, $text, $created_timestamp, $updated_timestamp);
  $insert_new_note_statement->execute();
  $insert_new_note_statement->close();

} elseif (is_numeric($note_id)) {

  $updated_timestamp = time();

  $update_note_statement = $data->prepare('UPDATE notes SET name = ?, text = ?, updated = ? WHERE id = ?');
  
  $update_note_statement->bind_param('ssii', $name, $text, $updated_timestamp, $note_id);
  $update_note_statement->execute();
  $update_note_statement->close();

}

$data->close();

include 'header.php';

include 'navigation.php';

echo "<h1>Saved <a href=\"note-view.php?id=" . $note_id . "\">" . $name . "</a></h1>";

include 'footer.php';

?>
