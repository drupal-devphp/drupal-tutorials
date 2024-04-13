(function($, Drupal, drupalSettings){
  'use strict';
  $(document).ready(function() {
    $('input').on('focus', function() {
      $(this).parent().next('.error').text('');
    });
  });
  
  /* 
  Drupal.behaviors.Employee = {
    attach: function (context, settings) {
      var current_user_name = drupalSettings.employee.current_user;
      
    }
  };
  */
})(jQuery, Drupal, drupalSettings);