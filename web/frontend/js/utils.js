;(function( $, window, undefined ) {

    $.fn.googleMap = function (options) {

        var el = this,
            x = $(el).data('x'),
            y = $(el).data('y'),
            zoom = $(el).data('zoom'),
            places = $(el).data('places'),
            o = $.extend({

              mapOptions: {
                scrollwheel: false,
                draggable:true
              },

              markerOptions: {}

            }, options);

        this.init = function () {

          if( !el[0] ) return;

          var map = new google.maps.Map(el.get(0), $.extend({
            zoom: zoom,
            center: new google.maps.LatLng(x, y)
          }, o.mapOptions));

          this.addMarkers(map, places)

          el.data('map', map);

          return el;

        };

        this.addMarkers = function(_map, _places){
          var latlngbounds = new google.maps.LatLngBounds();

          var image =
            new google.maps.MarkerImage('/assets/images/map-marker.png',
            new google.maps.Size(36, 49), //width, height
            new google.maps.Point(0, 0),
            new google.maps.Point(18, 49)); //distance to center point of marker


           var marker = new google.maps.Marker($.extend({
            position: myLatLng,
            map: _map,
            icon: image
          }, o.markerOptions));

          for (var i = 0; i < _places.length; i++) {
              var myLatLng = new google.maps.LatLng(_places[i][0], _places[i][1]);
              latlngbounds.extend(myLatLng);
              var marker = new google.maps.Marker($.extend({
                position: myLatLng,
                map: _map,
                icon: image
              }, o.markerOptions));
          }
        };


        return this;

    };


//проверка валидности и сообщение об успешной отправке
 (function(){
    $('#form').submit(function(e){
       e.preventDefault();

        var $form = $(this),
            $inputs = $form.find('.input-control, textarea:eq(0)'),
            $inputMail = $form.find('.input-mail:eq(0)'),
            hasError = false, val;

        $inputs.each(function(){
          val = $(this).val();
          if ( isBlank(val) ){
            $(this).parent().addClass('error');
            hasError = true;
            return;
          }
        });

        if( !isMail( $inputMail.val() ) ) {
          $inputMail.parent().addClass('error');
          hasError = true;
        }


        $inputs.focus(function(){
          $(this).parent().removeClass('error');
        });
        

        if (!hasError) {
            var data = $('#form').serialize();
            console.log(data);
            $.ajax({
                url: $('#form').attr("action"),
                type: 'POST',
                data: $('#form').serialize(),
                dataType: "json",
                success: function(data) {
                    if (data.response == 'yes') {
                        $.fancybox.close();

                        for (var i = 0; i <= 1; i++) {
                            $("#form")[0].reset();
                        };
                        $.fancybox({href: '#thanks'});
                    } else {
                        console.log(data.response);
                    }

                },
                error:  function(xhr, str){
                    alert('Возникла ошибка: ' + xhr.responseCode);
                }
            });

            return true;
        } else {
          return false;
        }

      });

      $(document).delegate(".thanks .form-blue-button","click",function(){
          $.fancybox.close(); 
      });

      

      function isBlank(str) {return (!str || /^\s*$/.test(str)); }
      function isMail(str) {return /^\S+@\w+\.\w{2,4}$/i.test(str); }

    })();


})(jQuery, window);

