<?php
   require_once '_inc-db.php';
   $get_rows   = mysqli_query($conn, "SELECT news_id FROM vacall_news");
   $total_rows = mysqli_num_rows($get_rows);

   $page_number     = mysqli_real_escape_string($conn, $_POST["page_number"]);
   $last_page       = mysqli_real_escape_string($conn, $_POST["last_page"]);
   $start_from      = $page_number * 10;
   $end             = $start_from - 10;
   $initial_set_end = $total_rows - 10;
   $news_data       = '';

   // First page
   if ((int)$_POST["page_number"] === 1) {
      $query = "SELECT * FROM vacall_news WHERE news_id BETWEEN $initial_set_end AND $total_rows ORDER BY news_id DESC";
   }
   // Last page
   else if ($last_page === 'true') {
      $query = "SELECT * FROM vacall_news WHERE news_id BETWEEN $start_from AND $total_rows";
   }
   // Between pages
   else {
      $query = "SELECT * FROM vacall_news WHERE news_id BETWEEN $end AND $start_from ORDER BY news_id DESC";
   }

   $loop_news = mysqli_query($conn, $query);
   while($news_data = mysqli_fetch_array($loop_news)) {
      $imgPath = 'img/news/news-' . $news_data["news_id"];
      $img     = glob($imgPath . ".*");
      echo '
            <div class="news-card flex dw-75">
               <div class="red-bar"></div>
               <div class="content">
                  <p class="date">' . htmlspecialchars(date("F m, Y", strtotime($news_data["news_date"]))) . '</p>
                  <h1>' . ucwords(htmlspecialchars($news_data["news_title"])) . '</h1>
                  <div class="flex-spread">
                     <div class="img-cont dw-10">
                        <img src="' . $img[0] . '" alt="' . htmlspecialchars($news_data["news_title"]) . '">
                     </div>
                     <p class="small-par dw-85">' . htmlspecialchars($news_data["news_desc"]) . '</p>
                  </div>
                  <div class="read-more-bg">
                     <a class="read-more" href="news.php?news_id=' . htmlspecialchars($news_data["news_id"]) . '">READ MORE&nbsp;&nbsp;
                        <i class="ion-android-arrow-dropright"></i>
                     </a>
                  </div>
               </div>
            </div>
         ';
   }

