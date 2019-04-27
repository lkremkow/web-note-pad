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

$data = new SQLite3('data.sqlite', SQLITE3_OPEN_READWRITE);

if ( $note_id == "" ) {

  $created_timestamp = time();
  $updated_timestamp = $created_timestamp;

  $note_id = $created_timestamp . random_int(10000, 99999);

  $insert_new_note_statement = $data->prepare('INSERT INTO notes ("id", "name", "text", "created", "updated") VALUES (?, ?, ?, ?, ?)');
  
  $insert_new_note_statement->bindValue(1, $note_id);
  $insert_new_note_statement->bindValue(2, $name);
  $insert_new_note_statement->bindValue(3, $text);
  $insert_new_note_statement->bindValue(4, $created_timestamp);
  $insert_new_note_statement->bindValue(5, $updated_timestamp);
  
  $insert_new_contact_result = $insert_new_note_statement->execute();
  $insert_new_contact_result->finalize();

} elseif (is_numeric($note_id)) {

  $updated_timestamp = time();

  $update_note_statement = $data->prepare('UPDATE notes SET "name" = ?, "text" = ?, "updated" = ? WHERE id = ?');
  
  $update_note_statement->bindValue(1, $name);
  $update_note_statement->bindValue(2, $text);
  $update_note_statement->bindValue(3, $updated_timestamp);
  $update_note_statement->bindValue(4, $note_id);
  
  $update_contact_result = $update_note_statement->execute();
  $update_contact_result->finalize();

}

$data->close();

include 'header.php';

include 'navigation.php';

echo "<h1>Saved <a href=\"note-view.php?id=" . $note_id . "\">" . $name . "</a></h1>";

include 'footer.php';

?>
