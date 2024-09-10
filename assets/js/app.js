// any CSS you import will output into a single css file (app.css in this case)
// import '../styles/app.css';
import $ from 'jquery';
import 'bootstrap';
import '../styles/app.css';

// Your custom JavaScript code can go here
$(document).ready(function() {
  // Added show bore button.
  $('.show-more').click(function() {
    const fullText = $(this).data('full-text');
    $(this).siblings('.message-text').text(fullText);
    $(this).hide(); // Hide the button after showing full text
  });

  // Modify the pagination links to use Ajax for loading content dynamically.
  $('.pagination .page-link').click(function(e) {
    e.preventDefault(); // Prevent default link behavior
    const url = $(this).attr('href');

    $.get(url, function(data) {
      $('.table-responsive').html($(data).find('.table-responsive').html());
      // Update the pagination controls
      $('.pagination').html($(data).find('.pagination').html());
    });
  });
});