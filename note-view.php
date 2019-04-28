<?php

include 'db-secrets.php';
$data = new mysqli($hostname, $username, $password, $db_name);

$fetch_note_statement = $data->prepare('SELECT * FROM notes WHERE id = ?');

if (isset($_GET["id"])) {
  $note_id=htmlspecialchars($_GET["id"]);
  if (is_numeric($note_id)) {
    $fetch_note_statement->bind_param('i', $note_id);
    $fetch_note_statement->execute();
    $fetch_note_statement_result = $fetch_note_statement->get_result();
    $note_data = $fetch_note_statement_result->fetch_all(MYSQLI_ASSOC);
    $fetch_note_statement_result->free();
    $fetch_note_statement->close();
    $data->close();
  } else {
    $note_id = 0;
  };
} else {
  $note_id = 0;
}

if ( ($note_id > 0) && ($note_data[0]["id"] == $note_id) ) {
  $page_title = "Note: " . $note_data[0]["name"];
  include 'header.php';
  include 'navigation.php';

  echo "<h1>XXX</h1>";



  echo "<h1>" . $note_data[0]["name"] . "</h1>";

  echo "<p>[<a href=\"note-edit.php?id=" . $note_id . "\">edit</a>]</p>";

  echo "<p>[<a href=\"note-delete.php?id=" . $note_id . "&name=" . urlencode($note_data[0]["name"]) . "\">delete</a>]</p>";  

  echo "<p>" . nl2br($note_data[0]["text"]) . "</p>";

  date_default_timezone_set('UTC');

  $created_timestamp = new DateTime();
  $created_timestamp -> setTimestamp($note_data[0]["created"]);

  $updated_timestamp = new DateTime();
  $updated_timestamp -> setTimestamp($note_data[0]["updated"]);

  date_timezone_set($created_timestamp, timezone_open('Europe/Paris'));
  date_timezone_set($updated_timestamp, timezone_open('Europe/Paris'));

  echo "<p>created: " . date_format($created_timestamp, 'F jS, Y \a\t H:i') . "</p>";
  echo "<p>updated: " . date_format($updated_timestamp, 'F jS, Y \a\t H:i') . "</p>";

  include 'footer.php';
}

?>