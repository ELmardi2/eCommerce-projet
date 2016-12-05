$(function() {

  "use strict";
  //Hide placeholder on form focus
  $('[placeholder]').focus(function () {
    $(this).attr('data-text', $(this).attr('placeholder'));
    $(this).attr('placeholder', '');
  }).blur(function () {
    $(this).attr('placeholder', $(this).attr('data-text'));
  });
  //add star for required feild
  $('input').each(function() {
    if($(this).attr('required') === 'required'){
      $(this).after('<span class="asterisk">*</span>')
    }
  });
});
