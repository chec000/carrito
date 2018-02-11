$(function(){

	setTimeout(function(){
		$('.s1').slick({
			slidesToShow: 4,
			autoplay: true,
			autoplaySpeed: 300000,
			prevArrow: '<p class="ic left-arrow a-left control-c prev slick-prev"></p>',
			nextArrow: '<p class="ic right-arrow a-right control-c next slick-next"></p>',
			responsive: [
			{
			  breakpoint: 1024,
			  settings: {
			    slidesToShow: 4,
			    slidesToScroll: 4,
			    infinite: true,
			    dots: true
			  }
			},
			{
			  breakpoint: 600,
			  settings: {
			    slidesToShow: 1,
			    slidesToScroll: 1
			  }
			},
			{
			  breakpoint: 480,
			  settings: {
			    slidesToShow: 1,
			    slidesToScroll: 1
			  }
			}
			]
		});

		$("#menu-movil").click(function (e) {
		  e.preventDefault();
		  $("#menu-movil-general").slideToggle();
		  $("#box-movil-settings").hide();
		  $("#box-movil-cart").hide();
		  $("#box-movil-login").hide();
		});

		$("#menu-movil-login").click(function (e) {
		  e.preventDefault();
		  $("#menu-movil-general").hide();
		  $("#box-movil-settings").hide();
		  $("#box-movil-cart").hide();
		  $("#box-movil-login").slideToggle();
		});

		$("#menu-movil-settings").click(function (e) {
		    e.preventDefault();
		    $("#menu-movil-general").hide();
		    $("#box-movil-login").hide();
		    $("#box-movil-cart").hide();
		    $("#box-movil-settings").slideToggle();
		});

		$("#menu-movil-cart").click(function (e) {
		    e.preventDefault();
		    $("#menu-movil-general").hide();
		    $("#box-movil-login").hide();
		    $("#box-movil-settings").hide();
		    $("#box-movil-cart").slideToggle();
		});

		$(".btn-c").click(function () {
		    var video = "https://www.youtube.com/embed/mpLByue07c4";
		    $("#c-video").attr("src", "");
		    $("#c-video").attr("src", video);
		});

		$("#check-box input[type='checkbox']").change(function () {
		    if ($('#checkbox-2').is(':checked') && $('#checkbox-1').is(':checked') && $('#checkbox-3').is(':checked')) {
		        $('#form-prev').prop('disabled', false).css('cursor', 'pointer');
		        $('#form-next').prop('disabled', false).css('cursor', 'pointer');
		    } else if ($('#checkbox-2').not(':checked') || $('#checkbox-1').not(':checked') || $('#checkbox-3').not(':checked')) {
		        $('#form-prev').prop('disabled', true);
		        $('#form-next').prop('disabled', true);
		    }
		});

		$('#m-cancel').click(function () {
		    $('#form-next').prop('disabled', true);
		    document.getElementById("checkbox-1").checked = false;
		});
		$('#m-accept').click(function () {
		    $("#checkbox-1").prop("checked", true);
		     if ($('#checkbox-2').is(':checked') && $('#checkbox-1').is(':checked') && $('#checkbox-3').is(':checked')) {
		        $('#form-prev').prop('disabled', false).css('cursor', 'pointer');
		        $('#form-next').prop('disabled', false).css('cursor', 'pointer');
		    } else if ($('#checkbox-2').not(':checked') || $('#checkbox-1').not(':checked') || $('#checkbox-3').not(':checked')) {
		        $('#form-prev').prop('disabled', true);
		        $('#form-next').prop('disabled', true);
		    }
		});

		/*$('#form-next').click(function () {
		    $('#form-reg').hide("fast");
		    $('#form-title').text('Selecciona tu kit').wrapInner("<b />");
		    $('#kit-part').show("slow");
		});*/

		$('#m-terms').bind('scroll', function(){
    		if($(this).scrollTop() + $(this).innerHeight()>=$(this)[0].scrollHeight){
      			$('#m-btn').show("slow");
    		}
  		});
		$(".btn-c").click(function(){
			var video = "https://www.youtube.com/embed/mpLByue07c4";
			$("#c-video").attr("src","");
			$("#c-video").attr("src",video);
		});

		$(".addProduct").click(function(){
			
			addProduct($.parseJSON($(this).parent().find('.product').text()));
		});

		$("#zip").focus();
		$(".imageContainer").hover(function(){
			$(".productsCart").show();
			hideCartMenu();
		});

		$("#drop-login").hover(function(){
			$(".productsCart").hide();
		});

		$(".closeProductsCart").click(function(){
			$(".productsCart").hide();
		});

		$(".productsCart").mouseleave(function(){
			$(".productsCart").hide();
		});
            $(".letters").keypress(function(event){
	        	var node = $(this);
    			node.val(node.val().replace(/[^a-zA-Z áéíóúÁÉÍÓÚñÑ]/g,'') );
	    	});
		$("#upload-photo").change(function () {
		    var file = $('#upload-photo')[0].files[0];
		    if ($("#upload-photo").length) {
		        $("#file-button").text(file.name);
		    }
		});
		var valor = $('#subMenu').val();  
		switch(valor) {
		    case "1":
			    $('#information').removeClass('azult').addClass('green-icon');
			break;
			case "2":
				$('#kit').removeClass('azult').addClass('green-icon');
			break;
			case "3":
			    $('#payment').removeClass('azult').addClass('green-icon');
			break;
			case "4":
				$('#confirmation').removeClass('azult').addClass('green-icon');
			break;
		}
		/*$("#find-sponsor").click(function(){
			var value = $('#sponsorCode').val();
			$.get("/inscription/getSponsor",{ sponsor_code: value }, function(data, status){
				if (data){
					$('#sponsor-reg').hide('slow');
					$('#form-reg').show('slow');
				}else{
					alert('No se encontro al patrocionador');
				}
			});
		});*/         
		$("#cards").click(function(){
    		$('html, body').animate({
        		scrollTop: $("#pay").offset().top
   	 		}, 1500);
		});
		 $(".loader").fadeOut("slow");                                       
                                       //     formatProducts();
		 $('#getpdf').eq(0).click();
		 $('#sponsorModal').modal('show');
		 setTimeout(function(){ $('#pdfModal').modal('show'); }, 500);
	}, 4000);
	setTimeout(function(){
	 	beforeLoadInscription();
	 	detectIE();
		$('#rad1').prop('checked', true);
		$( "input:radio[name=radioSpons]" ).change(function() {
  			var value = $(this).val();
  			console.log(value);
  			$('#searchSponsorModal').hide();
  			if (value == 2) {
  				$('#sponsorCode').hide();
  				$('#sponsorModal').modal('hide');
            	searchSponsor(false);
  			}else{
  				main.sessions.sponsor.eo_name = "";
  				$('#searchSponsorModal').show();
  				$('#sponsorCode').show();
  				//$('#sponsorModal').modal('show');
  			}
  			$('#form-reg').show("fast");
		});
		if ($("#sponsorCode").val()){
			$( "#searchSponsorModal" ).prop( "disabled", false);
    	}
	}, 500);
    $('.carousel').carousel({
  interval: 3000
	});
});
function formatProducts(){
     $("[name ^= productPrice-]").each(function () {
         var r = $(this);
      var price = $(this).children('input').val(); 
     var priceFormated= currency(price,2, [',', "'", '.']);
      var $priceCorrect = $('<b >$ '+priceFormated+ '</b>');              
      r.append($priceCorrect);
     });
}

function currency(value, decimals, separators) {
    decimals = decimals >= 0 ? parseInt(decimals, 0) : 2;
    separators = separators || ['.', "'", ','];
    var number = (parseFloat(value) || 0).toFixed(decimals);
    if (number.length <= (4 + decimals))
        return number.replace('.', separators[separators.length - 1]);
    var parts = number.split(/[-.]/);
    value = parts[parts.length > 1 ? parts.length - 2 : 0];
    var result = value.substr(value.length - 3, 3) + (parts.length > 1 ?
        separators[separators.length - 1] + parts[parts.length - 1] : '');
    var start = value.length - 6;
    var idx = 0;
    while (start > -3) {
        result = (start > 0 ? value.substr(start, 3) : value.substr(0, 3 + start))
            + separators[idx] + result;
        idx = (++idx) % 2;
        start -= 3;
    }
    return (parts.length === 3 ? '-' : '') + result;
}


    function activateBoton(){
          $("#idBtnNexPromo").css('display','block');
    }    
    
     function desactivateBoton(){
          $("#idBtnNexPromo").css('display','none');
    }
$( "#sponsorCode" ).keyup(function() {
	if ($(this).val()){
		$( "#searchSponsorModal" ).prop( "disabled", false);
	}else{
		$( "#searchSponsorModal" ).prop( "disabled", true);
	}
});
