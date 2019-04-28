<?php

include 'db-secrets.php';
$data = new mysqli($hostname, $username, $password, $db_name);

$fetch_notes_statement = $data->prepare('SELECT * FROM notes ORDER BY LOWER(name) ASC, created ASC');
$fetch_notes_statement->execute();
$fetch_notes_statement_result = $fetch_notes_statement->get_result();
$all_note_data = $fetch_notes_statement_result->fetch_all(MYSQLI_ASSOC);
$fetch_notes_statement_result->free();
$fetch_notes_statement->close();
$data->close();


$page_title = "Notes";

include 'header.php';

include 'navigation.php';

echo "<h1>Notes</h1>";

foreach($all_note_data as $note_row) {
  echo "<p><a href=\"note-view.php?id=" . $note_row["id"] . "\">" . $note_row["name"] . "</a></p>";

}

include 'footer.php';

?>
