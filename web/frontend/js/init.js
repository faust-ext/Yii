$(document).ready(function() {

    /********************** Global *********************/

    $('input, textarea').placeholder({
        color : '#8f8f8f'
    });

    $('.fancybox').fancybox({
      helpers : {
        title : {
          type : 'inside'
        }
      }
    });

    $('.fancybox-modal').fancybox({
        closeBtn:false
    });

    $('.js-bxslider').bxSlider({
    });

    $('.tabs-on').tabslet({
        autorotate: true,
        delay: 6000,
        animation: true
    });

    //$('#map_canvas').googleMap().init();
    //
    //$('#map_canvas').gmap('addMarker', { /*id:'m_1',*/ 'position': '59.959725,30.281485', 'bounds': true } );

    var mapOptions = {
        center: new google.maps.LatLng(59.959725, 30.281485),
        zoom: 14,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    var latlngbounds = new google.maps.LatLngBounds();
    var myLatLng = new google.maps.LatLng(59.959725, 30.281485);

    latlngbounds.extend(myLatLng);
    var marker = new google.maps.Marker({
            position: myLatLng,
    map: map
});






  $(".input-phone").inputmask({
    mask: "+7 (999) 999-99-99",
    greedy: false,
    showMaskOnHover: false,
    clearIncomplete: true
  });

  // источник http://stackoverflow.com/questions/11340789/make-an-element-visible-only-when-scrolled-down-to-px
  // кнопка прокручивания на вверх
  $('.up').hide();
  var isVisible = false;
  // при указанной высоте появляться (скролл вниз), и исчезать (скролл вверх)
  $(window).scroll(function(){
       var shouldBeVisible = $(window).scrollTop()>550;
       if (shouldBeVisible && !isVisible) {
            isVisible = true;
            $('.up').fadeIn(250);
       } else if (isVisible && !shouldBeVisible) {
            isVisible = false;
            $('.up').fadeOut(250);
      }

      var footerTop = $(".footer").offset().top -115;
      var upPlase = $('.up__child').offset().top + $('.up__child').height();
      var ww = $(window).scrollTop() +$(window).height()/2 ;
      if(upPlase>=footerTop && ww>=footerTop){
        $('.up').css({'top':(footerTop)+'px', 'position':'absolute'});
      } else {
        $('.up').css({'top':'50%', 'position':'fixed'});
      }
  });

// источник http://css-tricks.com/snippets/jquery/smooth-scrolling/
  $('.product-preview__menu-item a, .up__child').click(function(e) {
    e.preventDefault();

    var target = $(this).attr("href");
    console.log(target+" target");
      $('html,body').animate({
        scrollTop: $(target).offset().top}, 500);
  });







    
      
      

    function ellips(){
      var $ellWrap = $(".col-6 .text-block__content");

      var $elText = $ellWrap.find("p:eq(0)");
      $elText.addClass("ellipsis");

      $(".ellipsis").dotdotdot({
        ellipsis  : '... '
      });
    }
    ellips();

     $(window).on('resize', ellips);


});



