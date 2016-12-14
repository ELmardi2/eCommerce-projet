$(function() {

  "use strict";


//Trigger SelectBoxIT
$("select").selectBoxIt();

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
  //converte password to text when hover

  var passFeild = $('.password');
          $('.show-pass').hover(function () {
            passFeild.attr('type', 'text');
          }, function(){
        passFeild.attr('type', 'password');
  });
  //confirmation Delete
  $('.confirm').click(function () {
          return confirm('Are You sure!?');
  });
  //truc js
  $('.cat h3').click(function() {
    $(this).next('.full-view').fadeToggle(1000);
  });
     $('.option span').click(function () {
       $(this).addClass('active').siblings('span').removeClass('active');
       if ($(this).data('view') === 'full') {
         $('.cat .full-view').fadeIn(300);
       }else {
         $('.cat .full-view').fadeOut(300);
       }
     });
});
