const Pagination = (function() {
   const pageNumbers = [].slice.call(document.querySelectorAll('.news-page-number'));
   const cardCont    = document.querySelector('.news-cards-cont');
   let lastPage;

   pageNumbers.forEach(function(page) {
      page.addEventListener('click', function(event) {
         const clicked    = event.target;
         const pageNumber = clicked.getAttribute('data-page-number');
         const request    = new XMLHttpRequest();
         onScroll.scrollToTop();

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
})();
