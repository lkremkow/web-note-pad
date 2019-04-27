<?php

$data = new SQLite3('data.sqlite', SQLITE3_OPEN_READONLY);

$fetch_note_statement = $data->prepare('SELECT * FROM notes WHERE id = ?');

if (isset($_GET["id"])) {
  $note_id=htmlspecialchars($_GET["id"]);
  if (is_numeric($note_id)) {
    $fetch_note_statement->bindValue(1, $note_id);
    $note_result = $fetch_note_statement->execute();
    if ( $note_result->numColumns() > 0 ) {
      $note_row = $note_result->fetchArray(SQLITE3_ASSOC);
    }
    $note_result->finalize();
  } else {
    $note_id = 0;
  };
} else {
  $note_id = 0;
}

if ( ($note_id > 0) && ($note_row["id"] == $note_id) ) {
  $page_title = "Note: " . $note_row["name"];
  include 'header.php';
  include 'navigation.php';
  echo "<h1>" . $note_row["name"] . "</h1>";

  echo "<p>[<a href=\"note-edit.php?id=" . $note_id . "\">edit</a>]</p>";

  echo "<p>[<a href=\"note-delete.php?id=" . $note_id . "&name=" . urlencode($note_row["name"]) . "\">delete</a>]</p>";  

  echo "<p>" . nl2br($note_row["text"]) . "</p>";

  date_default_timezone_set('UTC');

  $created_timestamp = new DateTime();
  $created_timestamp -> setTimestamp($note_row["created"]);

  $updated_timestamp = new DateTime();
  $updated_timestamp -> setTimestamp($note_row["updated"]);

  date_timezone_set($created_timestamp, timezone_open('Europe/Paris'));
  date_timezone_set($updated_timestamp, timezone_open('Europe/Paris'));

  echo "<p>created: " . date_format($created_timestamp, 'F jS, Y \a\t H:i') . "</p>";
  echo "<p>updated: " . date_format($updated_timestamp, 'F jS, Y \a\t H:i') . "</p>";

  include 'footer.php';
}

$data->close();

?>