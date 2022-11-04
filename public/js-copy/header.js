$('.ui.dropdown')
  .dropdown()
;

$( document ).ready(function() {
    var
      $dropdownItem1 = $('.menu .dropdown .item'),
      $popupItem1    = $('.popup.example .category-one.item'),
      $menuItem1     = $('.menu a.item, .menu .link.item').not($dropdownItem1),
      $dropdown1     = $('.menu .ui.dropdown'),

      handler1 = {
        activate: function() {
          if(!$(this).hasClass('dropdown category-one')) {
            $(this)
              .addClass('active')
              .closest('.ui.menu')
              .find('.item')
                .not($(this))
                .removeClass('active')
            ;
          }
        }

      }
    ;

    $('.category-one.item').popup({
        popup     : '.admission.popup',
        hoverable : true,
        position  : 'bottom left',
        delay     : {
          show: 300,
          hide: 800
        }
      })
    ;

    $menuItem1
      .on('click', handler1.activate)
    ;
});
