$( document ).ready(function() {

    $('#btn_order_tbl').on('click', function() {
        $('#tbl_products').show();
        $('#list_products').hide();
    });
    $('#btn_order_lst').on('click', function() {
        $('#list_products').show();
        $('#tbl_products').hide();
    });

    $('#findNavbarFltrs').on('click', function() {
        $('#navbar-collapse').removeClass("show");
    });

    $('.products-detailProduct').on('click', function(){
        $('#product-detail').show();
        $('#products-content').hide();
    });
    $('.products-clsDetail').on('click', function(){
        $('#product-detail').hide();
        $('#products-content').show();
    });
//hola();
    /*$('a.active').parents('li').css("background-color", "#3EC1CC");*/

});

function hola(){
     $("[id ^= productPrice-]").each(function () {
         console.log("hols");
     });
}