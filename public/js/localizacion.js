var lat;
var lon;
window.onload = function() {
    countryObject.getCountryByLanguage();
}

/**
 * 
 * 
 * 
 */
 var countryObject = {
  getCountryByLanguage: function (){
   var country_exist=localStorage.getItem("country");
  
        if ( country_exist==="Estados Unidos" || country==="United States") {
            return false;
        }else{
            
 var country = $("#country_selected").val();
    if (country !== "") {
        if (country ==="Estados Unidos" || country==="United States") {
         saveCountry.saveData().done(function (data){
            if (data) {
                $("#select_zip").modal("show");
                localStorage.setItem("country", country);
                console.log(data);
                
            }else{
               $("#start_view").modal("show");
           }                    
       });
     } else{
           // saveCountry.saveData().done(function (data){}
           $("#start_view").modal("show");
       }
   } else{
     $("#start_view").modal("show");
 }   
        }

}

};

/**
 * 
 * 
 * */
 $(document).ready(function () {

   //var flag=null;
   var country=localStorage.getItem("country");
   if (country===null) {
         if (navigator.geolocation) {
            navigator.geolocation.
            getCurrentPosition(showPosition, showErrors, options);
            searchLocation();          
        }
   }
      
});



/*
 * 
 * 
 * */
 var saveCountry = {
   saveData: function (){
     var  browser= saveCountry.getLanguage();
     $("#language ").val(browser);
     var form = $('#form_country_selected');
     var request = $.ajax({
        type: "POST",
        url: form.attr('action'),
        data: form.serialize()
    });
     request.fail(function (xmlHttp) {
       return false;
   });
     return request;     
 },
 getLanguage: function (){
    browser = window.navigator.language || navigator.browserLanguage;  
    
    switch(browser) {
        case "en-US":
        return "ENG";
        break;
        case "es-ES":
        return "ESP";
        break;

    }
}
};


/**
 * 
 * 
 * */

 function searchLocation(){
   // var address = new google.maps.LatLng(40.81380923056958, - 82.85888671875);
    var address = new google.maps.LatLng(lat, lon);

    var mapProp = {
        center: address,
        zoom: 9
    };
    var marker = new google.maps.Marker({
        position: address,
        title: 'Address'
    });
    getAddress(address);
}
/*
 * 
 * @param {type} latLng
 * @returns {undefined}
 */
 function getAddress(latLng) {
    geocoder = new google.maps.Geocoder();
    geocoder.geocode({'latLng': latLng},
        function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                if (results.length > 0) {
                    var countries = results.reverse();
                    $.each(countries, function (key, value) {
                        var components = value['address_components'];
                        for (var i in components){
                            if (components[i]['types'].indexOf("country") > - 1){
                                $("#country_selected").val(components[i]['long_name']);
                            }
                            if (components[i]['types'].indexOf("administrative_area_level_1") > - 1) {
                                var state = components[i]['long_name'];
                                $("#state_selected").val(state);
                                return false;
                            }
                        }
                    });
                }
            } else {
                console.log(status + "Get other country");
                getCountry().done(function (data) {
                    if (data.address.country !== "") {
                        $("#country_selected").val(data.address.country);
                    }
                });
            }
        }
        );
}
            /*
             * 
             * @returns {getCountry.request|jqXHR}
             */
             
             
             function getCountry() {
                var request = $.getJSON('http://api.wipmania.com/jsonp?callback=?', function (data) {
                });
                request.fail(function() {
                    console.log("Ha ocurrido un error, verifica tu conexión a internet ");
                });
                return request;
            }

           
            function hideShowModal(openModal, hideModal){
                $("#" + openModal).modal("show");
                $('#' + hideModal).modal('hide');
            }

            function showPosition(posicion) {
                var latitud = posicion.coords.latitude;
                var longitud = posicion.coords.longitude;
                lat = latitud;
                lon = longitud;
                var precision = posicion.coords.accuracy;
                var fecha = new Date(posicion.timestamp);
            }


            function showErrors(error) {
                
        console.log(error.code);
                
            }

            var options = {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 1000
            };

            function showModal(error) {   
               $("#"+error).modal("show");
           }





