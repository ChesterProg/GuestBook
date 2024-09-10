// any CSS you import will output into a single css file (app.css in this case)
// import '../styles/app.css';
import $ from 'jquery';
import 'bootstrap';
import '../styles/app.css';

// Your custom JavaScript code can go here
$(document).ready(function() {
  console.log("Hello, World!");
    // Create a tooltip element
    var $tooltip = $('<div class="tooltip"></div>').appendTo('body');

    // Show the tooltip on hover
    $('.tooltip-trigger').hover(function(event) {
      var title = $(this).attr('title');
      $tooltip.text(title); // Set the tooltip text
      $tooltip.css({
        top: event.pageY + 10, // Position it below the cursor
        left: event.pageX + 10
      }).fadeIn(200); // Show the tooltip
    }, function() {
      $tooltip.fadeOut(200); // Hide the tooltip
    }).mousemove(function(event) {
      $tooltip.css({
        top: event.pageY + 10,
        left: event.pageX + 10
      }); // Follow the mouse
    });

});