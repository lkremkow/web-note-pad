<?php

include 'db-secrets.php';
$data = new mysqli($hostname, $username, $password, $db_name);

$fetch_note_statement = $data->prepare('SELECT * FROM notes WHERE id = ?');

if (isset($_GET["id"])) {

  $note_id=htmlspecialchars($_GET["id"]);

  if (is_numeric($note_id)) {
    if ( $note_id > 0 ) {

      $fetch_note_statement->bind_param('i', $note_id);
      $fetch_note_statement->execute();
      $fetch_note_statement_result = $fetch_note_statement->get_result();
      $note_data = $fetch_note_statement_result->fetch_all(MYSQLI_ASSOC);
      $fetch_note_statement_result->free();
      $fetch_note_statement->close();
      $data->close();

    } else {
      // the id argument we go was is a negative numeber, set to 0
      $note_id = 0;
    }

  } else {
    // the id argument we got was not a numer, set it to 0
    $note_id = 0;
  };
} else {
  // no id argument was passed at all, setting it to 0
  $note_id = 0;
}

include 'header.php';

include 'navigation.php';

if ($note_id == 0) {

  echo "<h1>New Note</h1>";
  echo "<form action=\"note-save.php\" method=\"post\">";
  echo "<p>Name: <input type=\"text\" name=\"name\" value=\"\"></p>";
  echo "<p>Text: <textarea name=\"text\" rows=\"10\" cols=\"30\"></textarea></p>";

  echo "<input type=\"submit\" value=\"Save\">";
  echo "</form>";

} elseif ($note_id > 0) {

  echo "<h1>Edit Note</h1>";

  echo "<form action=\"note-save.php\" method=\"post\">";
  echo "<p>Name: <input type=\"text\" name=\"name\" value=\"" . $note_data[0]["name"] . "\"></p>";
  
  echo "<p>Text: <textarea name=\"text\" rows=\"10\" cols=\"30\">" . $note_data[0]["text"] . "</textarea></p>";

  echo "<input type=\"hidden\" name=\"note_id\" value=\"" . $note_data[0]["id"] . "\">";
  echo "<input type=\"submit\" value=\"Save\">";
  echo "</form>";

} else {
  echo "<h1>Error</h1>";
}

include 'footer.php';

?>
