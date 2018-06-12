<?php
   require_once 'db.php';

   $get_rows   = mysqli_query($conn, "SELECT news_id FROM TABLE");
   $total_rows = mysqli_num_rows($get_rows);

   $page_number     = mysqli_real_escape_string($conn, $_POST["page_number"]);
   $last_page       = mysqli_real_escape_string($conn, $_POST["last_page"]);
   $start_from      = $page_number * 10;
   $end             = $start_from - 10;
   $initial_set_end = $total_rows - 10;
   $news_data       = '';

   // Create dynamic page numbers -> call function where you want the page numbers to go
   function getPageNumber() {
      for($i = 0; $i < $total_rows[0]; $i++) {
         if ($i > 0) {
            if ($i % 10 === 0) {
               $page_number = $i / 10;
               echo '<p data-page-number=' . $page_number . '>' . $page_number . '</p>';
            }
         }
      }
   }

   // First page
   if ((int)$_POST["page_number"] === 1) {
      $query = "SELECT * FROM TABLE WHERE ID BETWEEN $initial_set_end AND $total_rows ORDER BY news_id DESC";
   }
   // Last page
   else if ($last_page === 'true') {
      $query = "SELECT * FROM TABLE WHERE ID BETWEEN $start_from AND $total_rows";
   }
   // Between pages
   else {
      $query = "SELECT * FROM TABLE WHERE ID BETWEEN $end AND $start_from ORDER BY ID DESC";
   }

   $loop_news = mysqli_query($conn, $query);
   while($news_data = mysqli_fetch_array($loop_news)) {
     // ACTION
   }

