const news = (function() {
   const searchBar   = document.querySelector('.search-input');
   const result      = document.querySelector('.result');
   const pageNumbers = [].slice.call(document.querySelectorAll('.news-page-number'));
   const dates       = [].slice.call(document.querySelectorAll('.news-card .date'));
   const cardCont    = document.querySelector('.news-cards-cont');
   const url         = window.location.href;
   let query;
   let lastPage;
   let delay         = function() {
   };

   function search() {
      const request = new XMLHttpRequest();
      query         = searchBar.value;
      // Loading...

      // On change
      request.onreadystatechange = function() {
         if (this.readyState === 4 && this.status === 200) {
            result.innerHTML = this.responseText;
         }
      };

      request.open('POST', '/inc/_ajax-news-search.php');
      request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      request.send(`query=${query}`);
   }

   if (url.indexOf('news_id') > -1) {
      fadeInEach.run('.sidebar-card', 600);
   }
   else {
      fadeInEach.run('.news-card', 600);
      pageNumbers.forEach(function(page) {
         page.addEventListener('click', function(event) {
            const clicked    = event.target;
            const pageNumber = clicked.getAttribute('data-page-number');
            const request    = new XMLHttpRequest();
            onScroll.scrollToTop();

            console.log(`Page: ${pageNumber} | Total Pages: ${pageNumbers.length}`);

            // Check if last page number
            parseInt(pageNumber) === pageNumbers.length ? lastPage = 'true' : lastPage = 'false';

            // On change
            request.onreadystatechange = function() {
               if (this.readyState === 4 && this.status === 200) {
                  cardCont.innerHTML = this.responseText;
                  fadeInEach.run('.news-card', 500);
               }
            };

            request.open('POST', '/inc/_ajax-news-pagination.php');
            request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            request.send(`page_number=${parseInt(pageNumber)}&last_page=${lastPage}`);
         });
      });
      searchBar.addEventListener('keyup', function() {
         clearTimeout(delay);

         delay = setTimeout(search, 100);
      });
   }
})();