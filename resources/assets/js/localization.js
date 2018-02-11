var lat;
var lon;
var zip;


/**
 * 
 * d
 * 
 */
var countryObject = {
    getCountryByLanguage: function () {

        var country = $("#country_selected").val();
        if (country !== "") {
            if (country === "Estados Unidos" || country === "United States") {
                saveCountry.saveData().done(function (data) {
                    if (data) {
                        $("#select_zip").modal("show");
                        localStorage.setItem("country", country);
                        console.log(data);

                    } else {
                        $("#start_view").modal("show");
                    }
                });
            } else {
                // saveCountry.saveData().done(function (data){}
                $("#start_view").modal("show");
            }
        } else {
            $("#start_view").modal("show");
        }
    }

};

/**
 * 
 * 
 * */
$(document).ready(function () {
        let url = window.location.href;
 //$("#start_view").modal("show");
 if (APP_URL+"/"===url) {
        checkSesionVariables();
  }
  $(".loader-general").fadeOut(4000);
});



/*
 * 
 * 
 * */
var saveCountry = {
    saveData: function () {
        var browser = saveCountry.getLanguage();
        $("#language").val(browser);
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
    getLanguage: function () {
        browser = window.navigator.language || navigator.browserLanguage;

        switch (browser) {
            case "en-US":
                return "ENG";
                break;
            case "es-ES":
                return "ESP";
            case "es":
                return "ESP";
            case "en":
                return "ENG";

                break;

        }
    }
};


function checkLanguage(lenguage){
       var request = $.ajax({
            type: "GET",
            url: APP_URL+'/languages/lang/'+lenguage
        });

         return request;
}

 function checkExistLan(){
       var request = $.ajax({
            type: "GET",
            url: APP_URL+'/languages/getLan'
        });

         return request;
}
function checkSesionVariables(){    
        $(".loader-general").fadeIn("slow");
            var request = $.ajax({
            type: "GET",
            url: 'existZip'
        });
        request.done(function (data) {
            if (data !== '1') {
                var country = $("#country_selected").val();
                if (country === null || country === "") {
                    if (navigator.geolocation) {
        browser = window.navigator.language || navigator.browserLanguage;
    console.log(browser);
        let lenguage="";
        switch (browser) {
            case "en-US":
             lenguage="en";
                break;
            case "es-ES":
                lenguage="es";
                  break;
            case "es":
                   lenguage="es";
                     break;
            case "en":
                   lenguage="en";                   
                break;
            default:
                lenguage = "es";
                break;
        }
                    if (lenguage==="es") {
                    get_loc();
                    }else{
                                            checkExistLan().done(function (data){
                        if (data==="0") {                         
                              checkLanguage(lenguage).done(function (data) {       
                                   //location.reload();
                                   get_loc();
                             });
                        }
                        else{
//                      $(".loader-general").fadeOut(1000);
                        $("#start_view").modal("show");
                        }
//                     $(".loader-general").fadeOut(9000);
                    });
                    }

                    }
                } else if (country === "Estados Unidos" || country === "United States") {
                    console.log("Usted esta en Estados Unidos");
                } else {
                    $("#start_view").modal("show");
                }
    
            }
        });
        request.fail(function (data) {
        });
    
  $(".loader-general").fadeOut(5000);
}
/**
 * 
 * 
 * */

function searchLocation() {
    //var address = new google.maps.LatLng(40.81380923056958, - 82.85888671875);
    var address = new google.maps.LatLng(lat, lon);

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
                            for (var i in components) {
                                if (components[i]['types'].indexOf("country") > -1) {
                                    var countrySelected = components[i]['long_name'];
                                    if (countrySelected === "Estados Unidos" || countrySelected === "United States") {
                                        $("#country_selected").val('USA');
                                    } else {
                                        $("#country_selected").val(components[i]['long_name']);
                                    }
                                }
                                if (components[i]['types'].indexOf("administrative_area_level_1") > -1) {
                                    $("#state_selected").val(components[i]['long_name']);
                                    saveCountry.saveData().done(function (data) {
                                        if (data) {
                                            if (data.country === "USA" || data.country === "USA") {
                                                console.log("diuhskajh");
                                                $("#select_zip").modal("show");
                                            } else {
                                                $("#country_selected").val("");
                                                $("#start_view").modal("show");
                                            }
                                        }
                                    });
                                    return false;
                                }
                            }
                        });
                    } else {
                        $("#select_country").modal("show");
                        console.log(status + "Get other country");
                        getCountry().done(function (data) {
                            if (data.address.country !== "") {
                                $("#country_selected").val(data.address.country);
                                $("#select_country").modal("show");
                            }
                        });
                    }
                }

            });
}
/*
 * 
 * @returns {getCountry.request|jqXHR}
 */


function getCountry() {
    var request = $.getJSON('http://api.wipmania.com/jsonp?callback=?', function (data) {
    });
    request.fail(function () {
        console.log("Ha ocurrido un error, verifica tu conexión a internet ");
    });
    return request;
}


function hideShowModal(openModal, hideModal) {
    $("#" + openModal).modal("show");
    $('#' + hideModal).modal('hide');
}

function showPosition(posicion) {
    var latitud = posicion.coords.latitude;
    var longitud = posicion.coords.longitude;
    this.lat = latitud;
    this.lon = longitud;
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
    $("#" + error).modal("show");
}
function hideModal(modal) {
    $("#" + modal).modal("hide");

}

function showModal(modal_target, modal_close) {
    $("#" + modal_close).modal("hide");
    $("#" + modal_target).modal("show");
    $("#principal_body").removeAttr('class');
    $("#principal_body").addClass('modal-open');
    $("#" + modal_target).css("background-color", "#44f1ffa6");  
    $("#zip").focus();
}


function guardarZipCode() {

    var form = $('#form_zip_selected');
    var zip = $("#zip").val();

    if(zip === "") {
        zip = 0;
    }

    $("#zip_selected").val(zip);
    var request = $.ajax({
        type: "POST",
        url: form.attr('action'),
        data: form.serialize()
    });


    request.done(function (data) {
        if (data.zip == null) {
            var promise = getTranslate('welcome.alerts.zip_not_found', '', '').then(function (responseContent) {
                $("#message_error").text(responseContent);
            });

        } else {
            location.reload();
        }
    });
    request.fail(function (data) {
        form.empty();
    });
}

$("#zip").keyup(function () {
    $("#message_error").text("");
});


function get_loc() {
    if (navigator.geolocation) {
        try {
            navigator.geolocation.getCurrentPosition(coordenadas,MostrarErrores);
        } catch (err) {
            alert(err.message);
        }
    }
 //  $("#start_view").modal("show");
}
function coordenadas(position) {
    lat = position.coords.latitude;
    lon = position.coords.longitude;
    searchLocation();
}

function MostrarErrores(error)
  {
  $("#start_view").modal("show"); 
  }
