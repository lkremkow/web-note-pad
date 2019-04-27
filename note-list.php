<?php

$data = new SQLite3('data.sqlite', SQLITE3_OPEN_READONLY);

$fetch_notes_statement = $data->prepare('SELECT * FROM "notes" ORDER BY "name" COLLATE NOCASE ASC, "created" ASC');
$notes_result = $fetch_notes_statement->execute();

$page_title = "Notes";

include 'header.php';

include 'navigation.php';

echo "<h1>Notes</h1>";

if ( $notes_result->numColumns() > 0 ) {
  while( $note_row = $notes_result->fetchArray(SQLITE3_ASSOC) ) {
    echo "<p><a href=\"note-view.php?id=" . $note_row["id"] . "\">" . $note_row["name"] . "</a></p>";
  }
} else {
  echo "<p>0 results</p>";
}

$notes_result->finalize();

$data->close();

include 'footer.php';

?>
