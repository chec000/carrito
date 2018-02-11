var apiUrl = APP_URL+'/api';
var urlGeneral = APP_URL + '/';
var productsUrl = APP_URL+'/products';
var registerUrl = APP_URL+'/inscription/register';
var path_image =  APP_URL + "/img/img-products/";
var urlProducts =  APP_URL + '/products/productList';
var urlArticulos =  APP_URL+ '/products/';
var urlProductos =  APP_URL + '/products';
var urlProductosDetail =  APP_URL + '/products/detailProduct/';
var urlResetPassword = APP_URL + '/authentication/resetPassword';
var urlAuthentication = APP_URL + '/authentication';
var is_visible = false;
var urlPayment =  APP_URL + '/payment/';
var urlCheckout = APP_URL + '/checkout/';
var urlGoCheckout =  APP_URL + '/checkout/checkout';
var pathUrl = APP_URL + '/';

var urlSelected;
var linksUrl;
var main = {};
var existNextProducts;
var methodFilter;
var idTipoFilter;
var visible_points;
var timeoutHandleCart = setTimeout(function () {
}, 3000);
var timeoutHandleSessionProducts = setTimeout(function () {
}, 300);
var timeoutHandleLoadSessionProducts = setTimeout(function () {
}, 1000);
var timeoutHandleRevalculateCart = setTimeout(function () {
}, 1100);

/*-----VUE-----*/
Vue.filter('truncate', function (value) {
    return value.substring(0, 65) + '...';
});

Vue.component('carousel', {
    props: ['title', 'add', 'see', 'products','points'],
    template: `
    <section class="products margin-top-95">
      <h2 class="products-title morado"><b>{{ title }}</b></h2>
      <div class="products-slider s1">
        <div v-for="product in products" class="prod-item main-category">
 <figure class="figure">
    <div class="col-md-10">
<div class="products-container">
 <div class="text-center">
     <div class="prod-image">
                <a :href="urlProductosDetail+product.product_id+'/home'"><img :src="path_image + product.sku +'.png'" onerror='this.src="img/imagen_producto.png"' class="slide-img rounded">
</a>
</div>   

            <div class="form-group m-top_closer15">
               <div class="col-md-12 text-center m-left30">
                <div class="products-font15 products-colorGray products-type-font-regular text-center">
                  <span>{{product.sku}}</span>
                </div>
                    <div class="products-font15 products-colorGray products-type-font-regular">
                              <span>{{ product.name.substring(0,18) }}<span v-if='product.name.length<18' >..</span> </span>             
              </div>
                                    <div>
                                    <span class="products-font15 products-colorGray products-type-font-regular">
                                       {{ product.description.substring(0,14)}} <span>..</span>                            
                                   <a class='cursor-pointer  underline products-uppercase'  :href="urlProductosDetail+product.product_id+'/home'">
                                       {{ see }} </a></span>                                   
                                      </div> 
                </div>    
             </div>
          </div>
 <div class="col-md-12 m-left30">    
      <div class="prod-values product-carrusel-items">
   <div>
        <p class="prod-price product-price"><b>$ {{ product.price }}</b></p>
            <p v-if='visible_points' class="prod-points product-points">{{ points }}:{{ product.points }}</p>
</div>        
    <div align="center">
<button type="button" name="addToCart" class="btn boton_omni products-font14 boton_lg product-carrusel-items-button products-uppercase addProduct">
{{ add }}</button>
          <p class="product" hidden>{{ product }}</p>


</div>
 <div>
</div>

          </div>     
    </div>
</div>    
</div>
    <div class="col-md-1"></div>
       
 </figure>
        </div>
      </div>
    </section>
  `,
});

Vue.component('modal', {
    template: '#modal-cartProducts'
})

main = new Vue({
    el: '#main',
    created() {
        this.getCategoriesProduct();
        this.getAllSessionVariables();
        this.fillPayment.method.fillPayment();
        this.fillkit.method.fillkit();
        this.menu.method.loadSessionProductsCart();
        this.menu.method.loadSessionLogin();
        this.promotion.method.loadSessionPromotions();
        this.getProductsByCategoryId();
        this.getAllProducts();
        this.product.method.getDataProducts();
        this.product.method.getProductsHome();
        this.fillSecurityQuestions.method.fillSecurityQuestions();
        this.register.method.searchSponsor2();
        this.promotion.method.getPromotionsBuild(); getSessionResetPassword
        this.checkout.method.getAddressShipSession();
        this.resetPassword.method.getSessionResetPassword();
    },
    data: {
        showModal: false,
        showZipError: false,
        zipChanging: false,
        addressChanging: false,
        sessions: {
            user: {},
            new_user: {
                sponsor: {},
                formReg: {},
                selected_kit: {},
                zip: {
                    zip: "0000"
                },
            },
            sponsor: {
                eo_name: ""
            },
            all: {
                zip: {
                    zip:""
                },
                selected_kit: {}
            },
        },
        server: "",
        list_categories: [],
        path_image: path_image,
        urlProductosDetail: urlProductos,
        registerUrl: registerUrl,
        menu: {
            prop: {
                productsCart: [],
                userLoginProducts: [],
                quantityProductsCart: 0,
                subTotalProductsCart: 0,
                totalPoints: 0,
                ws: '',
                totalProductsCart: 0,
                changingZip: true,
                goCheckout: false
            },
            method: {
                plusOneProductCart: plusOneProductCart,
                subtractOneProductCart: subtractOneProductCart,
                subtractProduct: subtractProduct,
                sessionProductsCart: sessionProductsCart,
                loadSessionProductsCart: loadSessionProductsCart,
                login: login,
                loadSessionLogin: loadSessionLogin,
                mergeSessionProductsCart: mergeSessionProductsCart,
                zipChanged: zipChanged,
                updateZip: updateZip,
                updateLocation: updateLocation,
                goCheckout: goCheckout
            }
        },
        product: {
            prop: {
                list_categories: [],
                list_benefits: [],
                list_products: [],
                homeProducts: {
                    categories: {
                        newReleases: [],
                        starProducts: [],
                        seasonProducts: []
                    },
                    titles: ['']
                },
                pagination_products: {},
                product: {
                    product_id: "",
                    sku: "",
                    price: "",
                    points: "",
                    name: "",
                    description: "",
                    short_description: "",
                    consupsion_tips: "",
                    nutritional_table: "",
                    video_url: "",
                    is_kit: "",
                    labels: [],
                    detail_product: {
                        benefit: [],
                        labels: [],
                        ingredients: [],
                        testimonies: [],
                        product_related: [],
                        counter: 1,
                        visible_combo: false,
                        product_selected: ""
                    },
                    packages: {
                        price: "",
                        quantity: "",
                        name: "",
                        desctipcion: "",
                    },
                    product_category: {
                        category_id: "",
                    },
                    redirect_home:false,
                }
            },
            method: {
                getDataProducts: getDataProducts,
                getFilter: getFilter,
                paginationProducts: paginationProducts,
                getPagesForPagination: getPagesForPagination,
                getFilterByBenefit: getFilterByBenefit,
                getFilterByCategory: getFilterByCategory,
                searchProducts: searchProducts,
                getProductsHome: getProductsHome,
                orderByDes: orderByDes,
                orderByAsc: orderByAsc,
                orderByStarPoducts: orderByStarPoducts,
                order: order,
                getDetailProduct: getDetailProduct,
                activeItem: activeItem,
                addMoreProducts: addMoreProducts,
                genericSocialShare:genericSocialShare
            }
        },
        register: {
            prop: {
                regForm: {
                    country: "",
                    name: "",
                    last_name: "",
                    gender: "",
                    day: "",
                    month: "",
                    year: "",
                    address: "",
                    district: "",
                    zip_code: "",
                    state: "",
                    federal_entities: "",
                    email: "",
                    phone_number: "",
                    security_question: "",
                    answer: "",
                    payment_condition: "",
                    terms_conditions: "",
                    sponsor_val: "",
                    sponsor_random: "",
                    ship_company: "",
                    county: "",
                },
            },
            method: {
                addFormReg: addFormReg,
                searchSponsor: searchSponsor,
                searchSponsor2: searchSponsor2
            }
        },
        fillPayment: {
            prop: {
            },
            method: {
                fillPayment: fillPayment
            }
        },
        fillSelectCountry: {
            prop: {
                countries: []
            },
            method: {
                fillSelectCountry: fillSelectCountry
            }
        },
        fillSelectState: {
            prop: {
                states: [],
                federal_entities: [],
                ship_companies: [],
                counties: [],
            },
            method: {
                fillSelectState: fillSelectState,
                fillSelectFederalEntities: fillSelectFederalEntities,
                fillSelectShip: fillSelectShip,
                fillCounty: fillCounty,
            }
        },
        fillSecurityQuestions: {
            prop: {
                questions: []
            },
            method: {
                fillSecurityQuestions: fillSecurityQuestions
            }
        },
        fillkit: {
            prop: {
                kits: []
            },
            method: {
                fillkit: fillkit
            }
        },
        kit: {
            prop: {
                saveKit: {
                    radio_kit: "",
                    price_kit: "",
                    name_kit: ""
                }
            },
            method: {
                saveKit: saveKit
            }
        },
        checkout: {
            prop: {
                existZIPSelected: {},
                checkedAddress: {},
                listAddress: [],
                addresShipp: [],
                newAddress: [],
                distId: "",
                clv_pais: "",
                listProductsPromo: [],
                listPromosFinish: [],
                addressShp: {}
            },
            method: {
                getListAddress: getListAddress,
                newFormShippAddress: newFormShippAddress,
                getAddressDistMod: getAddressDistMod,
                setNewValueVM: setNewValueVM,
                getCountysZipCode: getCountysZipCode,
                getSaveAddressDist: getSaveAddressDist,
                getStateByZipCode: getStateByZipCode,
                disableAddressShipp: disableAddressShipp,
                changeAddressShipp: changeAddressShipp,
                CheckValidation: CheckValidation,
                getNextPromo: getNextPromo,
                getProductsPromo: getProductsPromo,
                checkPromoProduct: checkPromoProduct,
                skipPromo: skipPromo,
                addSubProductPromo: addSubProductPromo,
                callPaypal: callPaypal,
                getAddressShipSession: getAddressShipSession
            }
        },
        promotion: {
            prop: {
                listPromotions: {},
                promotionsSelected: {},
                promoSelected: {},
                isPromotion: false
            },
            method: {
                initPromotions: initPromotions,
                addPromotion: addPromotion,
                setSessionPromotions: setSessionPromotions,
                unsetSessionPromotions: unsetSessionPromotions,
                savePromotions: savePromotions,
                loadSessionPromotions: loadSessionPromotions,
                getPromotionsBuild: getPromotionsBuild,
                getInitPromo: getInitPromo,
                addPromoSelected: addPromoSelected,
                checkValidationRadiosPromo: checkValidationRadiosPromo,
                unsetPromotionsAndRecalculate: unsetPromotionsAndRecalculate
            }
        },
        resetPassword: {
            prop: {
                pages: {
                    distributorNumber: false,
                    resetOption: false,
                    emailSent: false,
                    confirmResetPassword: false,
                    rejectReset: false,
                    successReset: false
                },
                resetOption: "mail",
                showQuestion: false,
                showEoValidation: false,
                showBirthdayValidation: false,
                showQuestionValidation: false,
                showPasswordValidation: false,
                showMatchPasswordValidation: false,
                sessionResetPassword: {},
                confirmBirthday: "  ",
                confirmAnswerQuestion: "",
                newPassword: "",
                newMatchPassword: ""
            },
            method: {
                nextResetPage: nextResetPage,
                cancelReset: cancelReset,
                checkResetOption: checkResetOption,
                getSessionResetPassword: getSessionResetPassword,
                validateEo: validateEo,
                validationResetSection: validationResetSection,
                setSessionResetPassword: setSessionResetPassword,
                resetPasswordEo: resetPasswordEo,
                sentTokenEmail: sentTokenEmail
            }
        },
  },
  methods: {
    addProduct: addProduct,
    recalculateCart: recalculateCart,
    getCategoriesProduct: getCategoriesProduct,
    getProductsByCategoryId: getProductsByCategoryId,
    getAllSessionVariables: getAllSessionVariables,
    getAllProducts: getAllProducts,
    cancelOrderRejected:cancelOrderRejected,
    logout:logout
  }
});

/*-----JavaScript-----*/
function sentTokenEmail(){ 
    axios.get(`${urlAuthentication}/sendTokenEmail`).then(response => {
   
    });
}

function resetPasswordEo(){ 
    return axios.post(`${urlAuthentication}/resetPasswordEo`, {
        eoId: main.resetPassword.prop.sessionResetPassword.eoId,
        newPassword: main.resetPassword.prop.newPassword
    });
}

function setSessionResetPassword(){ 
    return axios.post(`${urlAuthentication}/setSessionResetPassword`, {
        resetPasswordSession: main.resetPassword.prop.sessionResetPassword
    });
}

async function validationResetSection(){
    let validate = true;
    if(main.resetPassword.prop.sessionResetPassword.stage == "distributorNumber"){
        validate = await main.resetPassword.method.validateEo();
        if(!validate)
            main.resetPassword.prop.showEoValidation = true;
    }
    else if(main.resetPassword.prop.sessionResetPassword.stage == "resetOption"){
        if(main.resetPassword.prop.resetOption == "question"){
            main.resetPassword.prop.confirmBirthday = $("#datepicker").val();
            if(main.resetPassword.prop.confirmAnswerQuestion.toLowerCase() != main.resetPassword.prop.sessionResetPassword.answerQuestion.toLowerCase()){
                main.resetPassword.prop.showQuestionValidation = true;
                validate = false;
            }   
            else
                main.resetPassword.prop.showQuestionValidation = false;

            if(main.resetPassword.prop.confirmBirthday != main.resetPassword.prop.sessionResetPassword.birthday){
                main.resetPassword.prop.showBirthdayValidation = true;
                validate = false;
            }
            else
                main.resetPassword.prop.showBirthdayValidation = false; 
        }else{
            main.resetPassword.method.sentTokenEmail();
        }
    }
    else if(main.resetPassword.prop.sessionResetPassword.stage == "confirmResetPassword"){
        if(main.resetPassword.prop.newPassword.length < 4){
            main.resetPassword.prop.showPasswordValidation = true;
            validate = false;
        }
        else
            main.resetPassword.prop.showPasswordValidation = false;

        if(main.resetPassword.prop.newPassword != main.resetPassword.prop.newMatchPassword){
            main.resetPassword.prop.showMatchPasswordValidation = true;
            validate = false;
        }
        else
            main.resetPassword.prop.showMatchPasswordValidation = false;

        if(validate)
            main.resetPassword.method.resetPasswordEo();
    }
    return validate
}

function validateEo(){ 
    return axios.post(`${urlAuthentication}/validateEo`, {
        eoId: main.resetPassword.prop.sessionResetPassword.eoId
    }).then(response => {
        main.resetPassword.prop.sessionResetPassword = response.data;
        return response.data.exito;
    });
}

function getSessionResetPassword(){
    if($(location)[0].pathname.split('/')[2] == "resetPassword"){
        axios.get(`${urlAuthentication}/getSessionResetPassword`).then(response => {  
            main.resetPassword.prop.sessionResetPassword = response.data;
            main.resetPassword.prop.pages[response.data.stage] = true;
        });
    }
}

function checkResetOption(option){
    if(option == "question"){
        let date = new Date();
        main.resetPassword.prop.showQuestion = true;
        setTimeout(function(){
            $("#datepicker").datepicker({
                dateFormat: 'dd/mm/yy',
                changeYear: true,
                changeMonth: true,
                yearRange: `1900:${date.getFullYear()-16}`
            });
        },500);
    }
    else
        main.resetPassword.prop.showQuestion = false;
}

async function nextResetPage(nextPage){
    if(await main.resetPassword.method.validationResetSection()){
        if(main.resetPassword.prop.resetOption == "question" && main.resetPassword.prop.sessionResetPassword.stage != "confirmResetPassword"){
            main.resetPassword.prop.sessionResetPassword.stage = "confirmResetPassword";
            main.resetPassword.method.setSessionResetPassword();
        }
        else if(main.resetPassword.prop.resetOption == "confirmResetPassword")
            axios.get(`${urlAuthentication}/deleteSessionResetPassword`);

        Object.entries(main.resetPassword.prop.pages).map(function(page){
            if(page[0] != nextPage)
                main.resetPassword.prop.pages[page[0]] = false;
            else
                main.resetPassword.prop.pages[page[0]] = true;
        });
    }
}

function cancelReset(){
    axios.get(`${urlAuthentication}/deleteSessionResetPassword`).then(response => { 
        window.location.replace(urlResetPassword);
    });
}

function visiblePoints(data){
    try {
   let user=  data.userId;
        if (user!==undefined) {
                   visible_points=true;
        }else{
     visible_points=false;
        }
}
catch (e) {
        visible_points=false;     

}
 

}
function getAllSessionVariables() {
  axios.post(apiUrl+'/getSessionVariables').then(response => {
    visiblePoints(response.data);
    main.sessions.all = response.data;
   try{
            if (typeof (main.sessions.all) === "object") {
                    let zip=main.sessions.all.zip;
            if (zip===undefined) {
                main.sessions.all.zip = {
                zip : "00000"
             };
            }else{
                 main.register.prop.regForm.zip_code = main.sessions.all.zip.zip;
            }
            }else{
                main.sessions.all.zip = {
                zip : "00000"
             };
            }   
   }catch(e){
   }
    if(response.data.taxes == null){
      main.sessions.all.management = 0;
      main.sessions.all.taxes = 0;
      main.sessions.all.points = 0;
    }
    if(main.sessions.all.selected_kit == undefined && main.sessions.all.zip != undefined)
        location.reload();
  });
}

function getCategoriesProduct() {
    axios.get(productsUrl+'/categories').then(response => {
        main.list_categories = response.data;
        main.server = productsUrl + '/productsCategory/';
    });
}

function getProductsByCategoryId() {
    let url = window.location.href;
     if (url.indexOf('/products/productsBenefit')>-1)  {
        getProductsByBenefitId();
    } else if (url.indexOf("searchProducts")>-1) {
        searchProducts();
    } else if (url.indexOf("detailProduct")>-1) {
        getDetailProduct(0);
    } else  if (url.indexOf("/products/productsCategory")>-1) {     
        axios.get(productsUrl + '/productsByCategory').then(response => {
            main.product.method.paginationProducts(response.data.products);
            main.product.prop.list_categories = response.data.categories;
            main.product.prop.list_benefits = response.data.benefits;
            response.data.products.data.forEach(function (product) {
                product.price = currency(product.price, 2, [',', "'", '.']);
            });
            main.product.prop.list_products = response.data.products;
            urlSelected = response.data.urlSelected;
            linksUrl = urlGeneral+ response.data.url;
            main.product.prop.product.detail_product.product_selected = "";
        });
        }else{
                getDataProducts();
               
    }
}

async function zipChanged(zip) {
    await axios.post(apiUrl+'/zipChanged', {
        zip_selected: zip,
        address: main.addressChanging
    }).then(response => {
        if (response.data == "") {
            main.addressChanging = false;
            main.showZipError = true;
        } else {
            if (response.data.zip != zip) {
                if (!main.addressChanging)
                    main.zipChanging = true;
                main.sessions.all.zip.zip = zip;
                var promise = getTranslate('welcome.common.confirmation_message').then(function (responseTitle ) {
                        messageModalDynamic(response.data.message, responseTitle, 'info');
                });
            } else
                main.menu.prop.changingZip = true;
        }
    });
}

async function updateZip(zip) {
    await axios.post(apiUrl+'/updateZip', {
        zip_selected: zip
    });
}

async function updateLocation(zip) {
    await axios.post(apiUrl+'/updateLocation', {
        zip_selected: zip
    }).then(response => {
        if (!main.addressChanging) {
            main.promotion.method.unsetSessionPromotions();
            location.reload();
        } else {
            let url = urlGeneral + "checkout/updateSessionAddressShipp";
            axios.post(url, {
                addressShp: main.checkout.prop.addressShp
            }).then(response => {
                main.promotion.method.unsetSessionPromotions();
                location.reload();
            });
        }
    });
}

function getAllProducts() {
 let url = window.location.href;
 if (url.indexOf("searchProducts")>-1){
        let url = productsUrl + '/searchAllProducts';
        axios.get(url).then(response => {
            main.product.prop.list_categories = response.data.categories;
            main.product.prop.list_benefits = response.data.benefits;
            urlSelected = response.data.urlSelected;
            linksUrl =urlGeneral+ response.data.url;
            if (response.data.products !== null) {
                response.data.products.data.forEach(function (product) {
                    product.price = currency(product.price, 2, [',', "'", '.']);
                });
                main.product.prop.list_products = response.data.products;
                main.product.method.paginationProducts(response.data.products);
            }
        });
    
 }
     
    //console.log("categories");
}

function addMoreProducts(type) {
    if (type === 1) {
        main.product.prop.product.detail_product.counter = main.product.prop.product.detail_product.counter + 1;
    } else {
        if (main.product.prop.product.detail_product.counter > 0) {
            main.product.prop.product.detail_product.counter = main.product.prop.product.detail_product.counter - 1;
        }
    }
}

function loadSessionPromotions() {
    axios.get(apiUrl+'/getSessionPromotions').then(response => {
        main.promotion.prop.promotionsSelected = response.data;
    });
}

function savePromotions() {
    if (main.promotion.prop.promoSelected.promo.hasOwnProperty('isCombo')) {
        main.promotion.prop.promoSelected.promo.products.map(function (product) {
            product.quantity = product.quantity * main.promotion.prop.promoSelected.promo.quantity;
            main.promotion.method.addPromotion(product);
        });
    } else {
        main.promotion.method.addPromotion(main.promotion.prop.promoSelected.promo);
    }

    main.promotion.method.setSessionPromotions();

}

function addPromotion(product) {
    product.typePromotion = main.promotion.prop.promoSelected.type;
    main.promotion.prop.isPromotion = true;
    addProduct(product);
}

function setSessionPromotions() {
    axios.post(apiUrl+'/setSessionPromotions', {
        promotionsProducts: main.promotion.prop.promotionsSelected
    });
}

function unsetSessionPromotions() {
    axios.post(apiUrl+'/deleteSessionPromotions', {
        productsCart: main.menu.prop.productsCart,
        quantityProductsCart: main.menu.prop.quantityProductsCart,
        subTotalProductsCart: main.menu.prop.subTotalProductsCart
    }).then(response => {
        main.promotion.method.loadSessionPromotions();

        main.menu.method.loadSessionProductsCart();
    });
}

function mergeSessionProductsCart(opcion) {
    main.showModal = false;
    axios.post(apiUrl+'/mergeSessionProductsCart', {
        opcion: opcion,
        userLoginProducts: main.menu.prop.userLoginProducts
    }).then(response => {
        if (main.menu.prop.goCheckout)
            window.location.replace(urlGoCheckout);
        else{
            if($(location)[0].pathname.split('/')[2] == "resetPassword")
                window.location.replace(urlGeneral);
            else
                location.reload();
        }
    });
}

function loadSessionLogin() {
    axios.get(apiUrl+'/getSessionLogin').then(response => {
        if (response.data != null) {
            main.sessions.user.name = response.data.userName;
            main.sessions.user.discount = response.data.userDiscount;
            main.sessions.user.id = response.data.userId;
        }
    });
}

function login(){
  let login = validateInputsLogin();
  if(login){
    axios.post(apiUrl+'/login', {
      user: main.menu.prop.user,
      password: main.menu.prop.password
    }).then(response => {
      if (response.data.exito) {
        if (response.data.responseSessionProductsCart.merge) {
          main.showModal = true;
          $('#loginModal').modal('hide');
          main.menu.prop.userLoginProducts = response.data.responseSessionProductsCart.userLoginProducts;
        } else
        {
          if(main.menu.prop.goCheckout)
          window.location.replace(urlGoCheckout);
          else{
              if($(location)[0].pathname.split('/')[2] == "resetPassword")
                  window.location.replace(urlGeneral);
              else
                  location.reload();
          }
        }
      } else {
        $(".error").text(response.data.error);
        $(".error").show();
      }
    });
  }
}

function validateInputsLogin(){
  let login = true;
  if(main.menu.prop.user == undefined){
    $(".userInput").css("border-color", "red");
    login = false;
  }
  else if(main.menu.prop.user.length == 0){
    $(".userInput").css("border-color", "red");
    login = false;
  }
  else
    $(".userInput").css("border-color", "#682E8A");

  if(main.menu.prop.password == undefined){
    $(".userPassword").css("border-color", "red");
    login = false;
  }
  else if(main.menu.prop.password.length == 0){
    $(".userPassword").css("border-color", "red");
    login = false;
  }
  else
    $(".userPassword").css("border-color", "#682E8A");
  return login;
}

function loadSessionProductsCart() {
    return axios.get(apiUrl+'/getSessionProductsCart').then(response => {
        main.menu.prop.productsCart = typeof (response.data.sessionProductsCart) == "object" ? Object.values(response.data.sessionProductsCart) : response.data.sessionProductsCart;
        main.menu.prop.quantityProductsCart = response.data.quantityProductsCart;
        main.menu.prop.subTotalProductsCart = response.data.subTotalProductsCart;
    });
}

function sessionProductsCart() {
    return axios.post(apiUrl+'/sessionProductsCart', {
        productsCart: main.menu.prop.productsCart,
        quantityProductsCart: main.menu.prop.quantityProductsCart,
        subTotalProductsCart: main.menu.prop.subTotalProductsCart,
        isPromotion: main.promotion.prop.isPromotion,
        typePromotion: main.menu.prop.typePromotion
    }).then(response => {
        if (response.data != null) {
            if (!main.promotion.prop.isPromotion)
                main.promotion.method.loadSessionPromotions();
        }
    });
}

//function existZipSelected(){
//    var request = $.ajax({
//            type: "GET",
//            url: 'existZip'
//        });
//        request.done(function (data) {
//                        
//        });
//        
//         return request;
//}
 
function getProductsHome() {        
                axios.get(productsUrl+'/productsHome').then(response => {
                    if (typeof(response.data)==="object") {
                 response.data.categories.newReleases.forEach(function (product) {
                    product.price = currency(product.price, 2, [',', "'", '.']);
                });
            
        main.product.prop.homeProducts = response.data;
        Object.values(main.product.prop.homeProducts.categories).map(function (category, index) {
            if (category.length > 0)
                main.product.prop.homeProducts.titles[index] = category[0].category;
            else
                main.product.prop.homeProducts.titles[index] = "";
        });
            //
                main.product.prop.homeProducts.categories.newReleases;
                response.data.categories.seasonProducts.forEach(function (product) {
                    product.price = currency(product.price, 2, [',', "'", '.']);
                });
                main.product.prop.homeProducts.categories.seasonProducts;
                //
                response.data.categories.starProducts.forEach(function (product) {
                    product.price = currency(product.price, 2, [',', "'", '.']);
                });
                  main.product.prop.homeProducts.categories.seasonProducts;
        }     
    });
    
    
  }




function hideCartMenu() {
    window.clearTimeout(timeoutHandleCart);
    timeoutHandleCart = setTimeout(function () {
        if(!$(".productsCart").is(":hover"))
            $(".productsCart").hide();
    }, 3000);
}

function saveSessionProductsCart() {
    window.clearTimeout(timeoutHandleSessionProducts);
    window.clearTimeout(timeoutHandleLoadSessionProducts);
    window.clearTimeout(timeoutHandleRevalculateCart);
    timeoutHandleSessionProducts = setTimeout(function () {
        main.menu.method.sessionProductsCart();
        timeoutHandleLoadSessionProducts = setTimeout(function () {
            loadSessionProductsCart();
        }, 1000);
        timeoutHandleRevalculateCart = setTimeout(function () {
            main.recalculateCart();
        }, 1100);
    }, 300);
}

function logout(){
    axios.post(apiUrl+'/deleteSessionPromotions', {
        productsCart: main.menu.prop.productsCart,
        quantityProductsCart: main.menu.prop.quantityProductsCart,
        subTotalProductsCart: main.menu.prop.subTotalProductsCart
    }).then(response => {
        axios.get(apiUrl+'/logout', {}).then(responseLogout =>{
         if(responseLogout.data.result)
            {
                window.location.replace(APP_URL);
            }
        });
});

}

function addProduct(product) {
  $(".productsCart").show();
  hideCartMenu();
  let index = product.hasOwnProperty('sku') ? main.menu.prop.productsCart.findIndex(i => i.sku === product.sku) : main.menu.prop.productsCart.findIndex(i => i.name === product.name);
  main.promotion.prop.isPromotion = product.hasOwnProperty('isPromotion');
  if (index < 0) {
    if(product.quantity == undefined){
      product.quantity = main.product.prop.product.detail_product.counter;
      main.product.prop.product.detail_product.counter = 1;
      
      if (product.quantity == undefined || product.quantity == 0) {
        product.quantity = 1;
      }
    }
    else if(product.quantity == 0)
      product.quantity = 1;
 

        product.priceQuantity = parseFloat(product.quantity * product.price);
        main.menu.prop.productsCart.push(product);
        main.menu.prop.quantityProductsCart++;
        main.menu.prop.subTotalProductsCart += main.menu.prop.productsCart.slice(-1)[0].priceQuantity;
        saveSessionProductsCart();
    } else if (main.product.prop.product.detail_product.counter > 0) {
        let price = main.menu.prop.productsCart[index].price;
        main.menu.prop.productsCart[index].quantity += parseFloat(main.product.prop.product.detail_product.counter);
        main.menu.prop.productsCart[index].priceQuantity += parseFloat(main.product.prop.product.detail_product.counter * price);
        main.promotion.prop.isPromotion = parseFloat(main.menu.prop.productsCart[index].hasOwnProperty('isPromotion'));
        main.menu.prop.subTotalProductsCart += parseFloat(main.product.prop.product.detail_product.counter * price);
        main.product.prop.product.detail_product.counter = 1;
        main.promotion.prop.isPromotion = false;
        saveSessionProductsCart();
    } else
        main.menu.method.plusOneProductCart(index);
}

function subtractProduct(index) {
    $(".loader").fadeIn("slow");
    main.menu.prop.subTotalProductsCart -= main.menu.prop.productsCart[index].priceQuantity;
    main.menu.prop.productsCart.splice(index, 1);
    main.menu.prop.quantityProductsCart--;
    main.promotion.prop.isPromotion = false;
    saveSessionProductsCart();
}

function plusOneProductCart(index) {
    let quantity = (main.menu.prop.productsCart[index].quantity++) + 1;
    let price = main.menu.prop.productsCart[index].price;
    let priceQuantity = main.menu.prop.productsCart[index].priceQuantity = quantity * price;
    main.promotion.prop.isPromotion = main.menu.prop.productsCart[index].hasOwnProperty('isPromotion');
    main.menu.prop.subTotalProductsCart += parseFloat(price);
    main.promotion.prop.isPromotion = false;
    saveSessionProductsCart();
}

function subtractOneProductCart(index) {
    if (main.menu.prop.productsCart[index].quantity > 1) {
        let quantity = (main.menu.prop.productsCart[index].quantity--) - 1;
        let price = main.menu.prop.productsCart[index].price;
        main.menu.prop.productsCart[index].priceQuantity = quantity * price;
        main.menu.prop.subTotalProductsCart -= parseFloat(price);
        main.promotion.prop.isPromotion = false;
        saveSessionProductsCart();
    }
}

function getDataProducts() {
    if (window.location.href === productsUrl) {
        axios.get(urlProducts).then(response => {
            main.product.prop.list_categories = response.data.categories;
            main.product.prop.list_benefits = response.data.benefits;
            main.product.method.paginationProducts(response.data.products);
            response.data.products.data.forEach(function (product) {
                product.price = currency(product.price, 2, [',', "'", '.']);
            });
            main.product.prop.list_products = response.data.products;
            main.product.prop.product.detail_product.product_selected = "";
            main.product.prop.product.redirect_home = true;
            urlSelected = response.data.urlSelected;
            linksUrl = response.data.url;
        });

    }
}

function getFilter(page_url,page) {
    $(".loader").fadeIn("slow");
       $("#pagintacio-products").show();
      $("[id ^= page-]").each(function () {
        var r = $(this);
             r.removeClass('underline');
      });
    
     $("#page-"+page).addClass("underline");
      $("#page-"+page).addClass("products-colorViolet-pagintator");

    axios.get(page_url).then(response => {
        main.product.method.paginationProducts(response.data.products);
        response.data.products.data.forEach(function (product) {
            product.price = currency(product.price, 2, [',', "'", '.']);
        });
        main.product.prop.list_products = response.data.products;
        main.product.prop.product.detail_product.product_selected = "";
    });
     $( ".loader" ).fadeOut( "2000", function() {
      $('html, body').animate({scrollTop:0}, 'slow');
  });      
}

function paginationProducts(data) {
    if (data!==undefined) {
            if (data.next_page_url !== null) {
        axios.get(data.next_page_url).then(response => {
            let resp = response.data.products.data.length;
            if (resp > 0) {
                data.next_page_url;
                let pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    next_page_url: data.next_page_url,
                    prev_page_url: data.prev_page_url,
                    pagesArray: main.product.method.getPagesForPagination(data, resp)
                }
                main.product.prop.pagination_products = pagination;
            } else {
                let pagination = {
                    current_page: data.current_page,
                    last_page: data.current_page,
                    next_page_url: "",
                    prev_page_url: data.prev_page_url,
                    pagesArray: main.product.method.getPagesForPagination(data, resp)
                }
                main.product.prop.pagination_products = pagination;
            }
        });
    } else {
        let pagination = {
            current_page: data.current_page,
            last_page: data.current_page,
            next_page_url: "",
            prev_page_url: data.prev_page_url,
            pagesArray: main.product.method.getPagesForPagination(data, 0)
        }
        main.product.prop.pagination_products = pagination;
    }
    }

}

function addFormReg() {
    var day, month, year, birthday;
    day = $('#day-reg').val();
    month = $('#month-reg').val();
    year = $('#year-reg').val();
    birthday = year + "-" + month + "-" + day;
    if (month == 2 && day > 28) {
        $("#d-val").show();
        $(document).scrollTop(100);
        return false;
    } else {
        if ($("#email-1").val() != $("#email-2").val()) {
            $("#e-val").show();
            $(document).scrollTop(350);
            return false;
        } else {
            var age = validateAge(birthday);
            if (age < 16) {
                $("#d-val2").show();
                $(document).scrollTop(350);
            }
            if (!$('#form')[0].checkValidity() || !main.menu.prop.changingZip) {
                $('#form').find('input[type="submit"]').click();
                if (!main.menu.prop.changingZip) {
                    var promise = getTranslate('welcome.alerts.zip_alert').then(function (responseContent) {
                        getTranslate('welcome.common.attention').then(function (responseTitle) {
                            messageModalDynamic(responseContent, responseTitle, '');
                        });
                    });
                }
                return false;
            }
            if (main.sessions.sponsor.eo_name == "") {
                var promise = getTranslate('welcome.alerts.sponsor_alert').then(function (responseContent) {
                    getTranslate('welcome.common.attention').then(function (responseTitle) {
                        messageModalDynamic(responseContent, responseTitle, '');
                    });
                });
                return false;
            } else {
                var url = urlGeneral + "inscription/save-form";
                axios.post(url, {
                    regForm: main.register.prop.regForm
                }).then(response => {
                    if (response) {
                        var kit = getTranslate('welcome.register.select_kit').then(function (response) {
                            $('#form-title').text(response).wrapInner("<b />");
                        });
                        $('#form-reg').hide("fast");
                        $('#kit').removeClass('azult').addClass('green-icon');
                        $('#information').removeClass('green-icon').addClass('azult');
                        $('#sponsor-reg').hide();
                        $('#kit-part').show("slow");
                        
                        main.sessions.new_user.formReg = response.data;
                        main.sessions.sponsor.eo_name = response.data.eo_name;
                    } else {
                        var promise = getTranslate('welcome.alerts.error_alert').then(function (responseContent) {
                            getTranslate('welcome.common.attention').then(function (responseTitle) {
                                messageModalDynamic(responseContent, responseTitle, '');
                            });
                        });
                    }
                })
            }
        }

        return false;
      } if (main.sessions.sponsor.eo_name == ""){
        var promise = getTranslate('welcome.alerts.sponsor_alert').then(function (responseContent) {
              getTranslate('welcome.common.attention').then(function(responseTitle){
                  messageModalDynamic(responseContent, responseTitle, '');
              });
          });
        return false;
      }else {
        var url = urlGeneral + "inscription/save-form";
        axios.post(url, {
          regForm: main.register.prop.regForm
        }).then(response => {
          if (response) {
            var kit = getTranslate('welcome.register.select_kit').then(function(response){
              $('#form-title').text(response).wrapInner("<b />");
            });
            $('#form-reg').hide("fast");
            $('#kit').removeClass('azult').addClass('green-icon');
            $('#information').removeClass('green-icon').addClass('azult');
            $('#sponsor-reg').hide();
            $('#kit-part').show("slow");
            main.sessions.new_user.formReg = response.data;
            main.sessions.sponsor.eo_name = response.data.eo_name;
          } else {
            var promise = getTranslate('welcome.alerts.error_alert').then(function (responseContent) {
              getTranslate('welcome.common.attention').then(function(responseTitle){
                  messageModalDynamic(responseContent, responseTitle, '');
              });
            });
          }
        })
      }   
}
function validateAge(birthday) {
    var now = new Date();
    var past = new Date(birthday);
    var nowYear = now.getFullYear();
    var pastYear = past.getFullYear();
    var age = nowYear - pastYear;
    return age;
}
function saveKit(kit) {
  var url = urlGeneral + "inscription/selected-kit";
  let saved = false;
  kit.price = currency(kit.price, 2, [',', "'", '.']);
  axios.post(url, {
    saveKit: kit
  }).then(response => {
    if (response) {
      addProduct(kit);
      $(".loader").fadeIn("slow");
      setTimeout(function(){
        $(".loader").fadeIn("slow");
        recalculateCart();
      }, 400);
      setTimeout(function(){
        window.location.href = urlGeneral+"checkout/checkout/";
      }, 1200);
    } else{
      var promise = getTranslate('welcome.alerts.error_alert').then(function (responseContent) {
        getTranslate('welcome.common.attention').then(function(responseTitle){
          messageModalDynamic(responseContent, responseTitle, '');
        });
      });
    }
  });
}

function fillPayment(){
    var url =urlGeneral+"checkout/getSession";
    if(window.location.href.indexOf("/checkout/checkout") >-1 ||  window.location.href.indexOf("/checkout/rejectedCharge") >-1 ){
      axios.get(url).then(response =>  {
        main.sessions.new_user = response.data;
        main.sessions.sponsor.eo_name = response.data.eo_name;
      //Function to validate address shipping required
        if(main.sessions.new_user.userId != undefined && main.sessions.new_user.userId != null) {    
            getListAddress(true);
        } else {
          recalculateCart();
        }
        setTimeout(function(){ $('#pay').show(); }, 5000);
      });

    }
}
function fillSelectCountry() {
    var url = urlGeneral + "inscription/getCountries"
    axios.get(url, {
        params: {
        }
    }).then(response => {
        main.fillSelectCountry.prop.countries = response.data;
    });
}
function fillSelectState(state = "") {
    var url = urlGeneral + "inscription/getStates"
    axios.get(url, {
        params: {
            state: state
        }
    }).then(response => {
        //console.log('state');
        //console.log(response.data);
        main.fillSelectState.prop.states = response.data;
    });
}
function fillSelectFederalEntities(zip = "") {
    var url = urlGeneral + "inscription/getFederalEntities";
    axios.get(url, {
        params: {
            zip: zip
        }
    }).then(response => {
        //console.log('city');
        main.fillSelectState.prop.federal_entities = response.data;
        //console.log(response);
    });
}
function fillSelectShip(city) {
    var url = urlGeneral + "inscription/getShipCompany";
    axios.get(url, {
        params: {
            country: main.register.prop.regForm.country,
            state: main.register.prop.regForm.state,
            city: city
        }
    }).then(response => {
        main.fillSelectState.prop.ship_companies = response.data.arrShippsCompany;
    });
}
function fillCounty() {
    var url = urlGeneral + "inscription/getCounty";
    axios.get(url, {
        params: {
            zip: main.register.prop.regForm.zip_code,
        }
    }).then(response => {
        main.fillSelectState.prop.counties = response.data;
        //zipChanged(main.register.prop.regForm.zip_code);
        fillSelectState(response.data[0].state);
        fillSelectFederalEntities(main.register.prop.regForm.zip_code);
    });
}
function fillSecurityQuestions() {
    var url = urlGeneral + "inscription/getSecurityQuestions"

    axios.get(url, {
        params: {
        }
    }).then(response => {
        main.fillSecurityQuestions.prop.questions = response.data;
    });
}
function fillkit() {
    var url = urlGeneral + "inscription/getKits"
    axios.get(url, {
        params: {
        }
    }).then(response => {
        main.fillkit.prop.kits = response.data;

    });
}
function searchSponsor2() {
    var url = urlGeneral + "checkout/getSession"
    axios.get(url).then(response => {
        if (typeof response.data.sponsor != 'undefined') {
            main.sessions.new_user.sponsor = response.data.sponsor;
            main.sessions.sponsor.eo_name = response.data.sponsor.eo_name;
            main.register.prop.regForm.sponsor_val = response.data.sponsor.eo_number;
        } else {
            main.sessions.new_user.sponsor = false;
        }
      });
  }
function beforeLoadInscription(){
  $('#form-reg').hide("fast");
  $('#kit-part').hide("fast");
  $('#m-btn').hide("fast");
  $('#pay').hide("fast");
  if ($('#sponsorCode').val()){
    $("#searchSponsorModal").attr('disabled', false);
  } 
  
}

function searchSponsor(spons = "") {
    var spons_val;
    if (!spons) {
        spons_val = null;
    } else {
        spons_val = main.register.prop.regForm.sponsor_val;
    }
    if (!main.sessions.new_user.sponsor.rand_sponsor) {
        var url = urlGeneral + "inscription/getSponsor"
        axios.get(url, {
            params: {
                sponsor: spons_val
            }
        }).then(response => {
            
            if (response.data.eo_number) {
                if (response.data.rand_sponsor) {
                    main.register.prop.regForm.sponsor_random = response.data.rand_sponsor;
                    main.register.prop.regForm.sponsor = response.data.eo_number;
                }
                main.sessions.sponsor.eo_name = response.data.eo_name;
                main.sessions.new_user.sponsor = response.data;
                $('#sponsorModal').modal('hide');
                $('#form-reg').show('slow');
            } else {
                var promise = getTranslate('welcome.alerts.sponsor_error').then(function (responseContent) {
                    getTranslate('welcome.common.attention').then(function (responseTitle) {
                        messageModalDynamic(responseContent, responseTitle, '');
                    });
                });
            }
        });
    } else {
        var url = urlGeneral + "checkout/getSession"
        axios.get(url).then(response => {
            main.sessions.new_user.sponsor = response.data;
            main.sessions.sponsor.eo_name = response.data.eo_name;
        });
}
}
function getPagesForPagination(data, response) {
    var pagesArray = [];
    let from = data.current_page;
//    if (response!==0) {
    for (from = 1; from <= data.last_page; from++) {
        var page_number = {
            current_number_page: data.path + "?page=" + from,
            from: from
        };
        pagesArray.push(page_number);
//    }
    }
    return pagesArray;
}

//function getTipeFilter(type,id){
//    if (type==="benefit") {
//        getFilterByBenefit(id,"asc");
//    }else{
//        getFilterByCategory(id,"asc");
//    }
//}
function getFilterByBenefit(benefit_id, order) {
    $("#product-detail").hide();
     $("#products-not-found").remove();
    $("#products-content").show();
       $("#pagintacio-products").show();
    $(".loader").fadeIn("slow");
    var urlProducts = urlArticulos + 'benefits/' + benefit_id + '/' + order;
    axios.get(urlProducts).then(response => {
        response.data.products.data.forEach(function (product) {
            product.price = currency(product.price, 2, [',', "'", '.']);
        });
        main.product.method.paginationProducts(response.data.products);
        main.product.prop.list_products = response.data.products;
        urlSelected = response.data.urlSelected;
        linksUrl =urlGeneral+ response.data.url;

        main.product.prop.product.detail_product.product_selected = "";
    });
      $( ".loader" ).fadeOut( "2000", function() {
      $('html, body').animate({scrollTop:0}, 'slow');
  });      
}

function getFilterByCategory(category_id, order) {
    $(".loader").fadeIn("slow");
     $("#products-not-found").remove();
     $("#pagintacio-products").show();
    $("#product-detail").hide();
    $("#products-content").show();
    var urlProducts = urlArticulos + 'category/' + category_id + '/' + order;
    axios.get(urlProducts).then(response => {
        main.product.method.paginationProducts(response.data.products);
        response.data.products.data.forEach(function (product) {
            product.price = currency(product.price, 2, [',', "'", '.']);
        });
        main.product.prop.list_products = response.data.products;
        urlSelected = response.data.urlSelected;
        linksUrl =urlGeneral+ response.data.url;
//      methodFilter="getFilterByCategory(category_id)";
        main.product.prop.product.detail_product.product_selected = "";
    });
      $( ".loader" ).fadeOut( "2000", function() {
      $('html, body').animate({scrollTop:0}, 'slow');
  });      
}

function searchProducts() {
    $(".loader").fadeIn("slow");    
    var name = $("#product_name").val();
    var name2 = $("#producs-nav").val();
    if (name !== "" || name2 !== "") {
        var urlProductsSearch = urlArticulos + 'search/' + name;
        if (name === "") {
            var urlProductsSearch = urlArticulos + 'search/' + name2;
        }
        $("#product-detail").hide();
        $("#products-content").show();
        axios.get(urlProductsSearch).then(response => {
            if (response.data.products.data.length > 0) {
                response.data.products.data.forEach(function (product) {
                    product.price = currency(product.price, 2, [',', "'", '.']);
                });
                main.product.method.paginationProducts(response.data.products);
                main.product.prop.list_products = response.data.products;
                urlSelected = response.data.urlSelected;
                linksUrl = productsUrl;
                  $("#pagintacio-products").show();
            } else {
                main.product.method.paginationProducts(response.data.products);
                var l = [];
                main.product.prop.list_products = l;
                 $("#pagintacio-products").hide();
               setMessage();
            }
        });
    }
    $(".loader").fadeOut(2000);
}

function setMessage(){
    var noProducts="";
    var boton="";
     var promise = getTranslate('welcome.alerts.no_products').then(function (responseContent) {
               noProducts =  responseContent;
         var promise2 = getTranslate('welcome.products.products').then(function (content2) {
                     $("#products-not-found").remove();
     $("#products-content")
       .append('<div id="products-not-found" class="card">\n\
<div class="card-block"><p class="card-text text-center products-font-error">'+noProducts+'</p>\n\
\n\<a href="'+productsUrl+'"  class="btn products-uppercase products-font13 products-colorBlu_Viol"><span class="fa fa-arrow-circle-left"></span>'+content2+'</a></div></div>');
             
         });

         
       
   

                        });
                        
   
}
/**/
function order(order) {
    $(".loader").fadeIn("slow");
     $("#products-not-found").remove();
    var urlProductsSearch = urlArticulos + 'productOrder/' + order;
    axios.get(urlProductsSearch).then(response => {
        main.product.method.paginationProducts(response.data.products);
        response.data.products.data.forEach(function (product) {
            product.price = currency(product.price, 2, [',', "'", '.']);
        });
        main.product.prop.list_products = response.data.products;
    });
    $(".loader").fadeOut(2000);
}

function orderByStarPoducts() {
     $("#products-not-found").remove();
    $(".loader").fadeIn("slow");
    var urlProductsSearch = urlArticulos + 'starProducts';
    axios.get(urlProductsSearch).then(response => {
        main.product.method.paginationProducts(response.data.products);
        response.data.products.data.forEach(function (product) {
            product.price = currency(product.price, 2, [',', "'", '.']);
        });
        main.product.prop.list_products = response.data.products;
    });
    $(".loader").fadeOut(2000);
}

function orderByAsc() {
     $("#products-not-found").remove();
    $(".loader").fadeIn("slow");
    var urlProductsSearch = urlArticulos + 'orderByAsc';
    axios.get(urlProductsSearch).then(response => {
        main.product.method.paginationProducts(response.data.products);
        response.data.products.forEach(function (product) {
            product.price = currency(product.price, 2, [',', "'", '.']);
        });
        main.product.prop.list_products = response.data.products;
    });
    $(".loader").fadeOut(2000);
}

function orderByDes() {
     $("#products-not-found").remove();
    $(".loader").fadeIn("slow");
    var urlProductsSearch = urlArticulos + 'orderByDes';
    axios.get(urlProductsSearch).then(response => {
        main.product.method.paginationProducts(response.data.products);
        response.data.products.forEach(function (product) {
            product.price = currency(product.price, 2, [',', "'", '.']);
        });
        main.product.prop.list_products = response.data.products;
    });
    $(".loader").fadeOut(2000);
}

function getDetailProduct(id_producto) {
     $("#products-not-found").remove();
    $(".loader").fadeIn("slow");
    if (id_producto === 0) {
        var urlProduct = urlArticulos + 'productDetail';
    } else {
        var urlProduct = urlArticulos + 'productDetail/' + id_producto;
    }
    axios.get(urlProduct).then(response => {
        $("#products-content").hide();
        $("#product-detail").show();
        main.product.prop.product.product_id = response.data.product.product_id,
                main.product.prop.product.sku = response.data.product.sku,
                main.product.prop.product.is_kit = response.data.product.is_kit,
                main.product.prop.product.price = currency(response.data.product.price, 2, [',', "'", '.']),
                main.product.prop.product.points = response.data.product.points,
                main.product.prop.product.video_url = response.data.product_language[0].video_url;
        main.product.prop.product.name = response.data.product_benefits.product_description[0].name,
                main.product.prop.product.consupsion_tips = response.data.product_benefits.product_description[0].consupsion_tips,
                main.product.prop.product.description = response.data.product_benefits.product_description[0].description,
                main.product.prop.product.short_description = response.data.product_benefits.product_description[0].short_description,
                main.product.prop.product.nutritional_table = response.data.product_benefits.product_description[0].nutritional_table,
                main.product.prop.product.detail_product.benefits = response.data.product_benefits.benefits;
        main.product.prop.product.detail_product.ingredients = response.data.product_benefits.ingredients;
        main.product.prop.product.detail_product.labels = response.data.product_benefits.labels;
        main.product.prop.product.product_category.category_id = response.data.product_category.category_id;
        main.product.prop.product.product_category.showTableNutri = response.data.product_category.showTableNutri;
        main.product.prop.product.redirect_home = response.data.redirect_home;
        response.data.product_benefits.packages.forEach(function (package) {
            package.price = currency(package.price, 2, [',', "'", '.']);
        });
        if (id_producto === 0) {
            main.product.prop.list_categories = response.data.listCategories;
            main.product.prop.list_benefits = response.data.listBenefits;
            main.product.prop.product.redirect_home = true;
        }
        main.product.prop.product.detail_product.package = response.data.product_benefits.packages;
        if (response.data.product_benefits.packages.length > 0) {
            main.product.prop.product.detail_product.visible_combo = true;
        } else {
            main.product.prop.product.detail_product.visible_combo = false;
        }
        setIsVisible(response.data.product_benefits.products_related.length);
        main.product.prop.product.detail_product.testimonies = response.data.product_benefits.users_testimonies;
        response.data.product_benefits.products_related.forEach(function (product) {
            product.price = currency(product.price, 2, [',', "'", '.']);
        });
        main.product.prop.product.detail_product.products_related = response.data.product_benefits.products_related;
        main.product.prop.product.detail_product.product_selected = response.data.product_selected;
        linksUrl = response.data.url;
        urlSelected = response.data.urlSelected;
        setTimeout(function(){
                $('.slide_detailProduct').slick({
                    slidesToShow: 3,
                    autoplay: true,
                    autoplaySpeed: 30000,
                    nextArrow: '<p class="ic left-arrow a-left control-c prev slick-prev"></p>',
                    prevArrow: '<p class="ic right-arrow a-right control-c next slick-next"></p>',
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3,
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
        },4000);
    });
    $(".loader").fadeOut(2000);
}
function setIsVisible(count) {
    if (count > 0) {
        is_visible = true;
    } else {
        is_visible = false;
    }
}

/*** checkout functions ***/
function getListAddress(validaShowModal) {
    main.checkout.prop.checkedAddress = false;
    axios.get(urlCheckout + 'getListAddressDist/USA').then(response => {
        main.checkout.prop.listAddress = response.data.result.data;
        main.checkout.prop.existZIPSelected = response.data.result.existZIPSelected;
        main.checkout.prop.zipSelected = response.data.result.zipSelected;
        main.checkout.prop.addresShipp = response.data.result.existZIPSelected.addressSelected;
        main.sessions.all.adressShippDist = response.data.result.existZIPSelected.addressSelected;
        //main.checkout.prop.distId = idDist;
        if ((validaShowModal && (typeof (response.data.result.data) == 'undefinded' || response.data.result.data.length < 1))
                || (validaShowModal && !response.data.result.existZIPSelected.existsZip)) {
                $("#modalLstShippAddres").modal("show");
        }

        if (!response.data.result.existZIPSelected.existsZip) {
            var promise = getTranslate('welcome.shipp.message_address_shipp_zip_not_registered', 'ZIP_CODE', response.data.result.zipSelected).then(function (responseContent) {
                getTranslate('welcome.common.attention', '', '').then(function (responseTitle) {
                    messageModalDynamic(responseContent, responseTitle, '');
                  });
                  main.getAllSessionVariables();
              });
              //main.getAllSessionVariables();
          } else {
            main.checkout.prop.checkedAddress = true;
            if( validaShowModal) {
              //main.getAllSessionVariables();
              //window.location.replace(urlGoCheckout);
              main.getAllSessionVariables();
              main.recalculateCart();
              //main.promotion.method.initPromotions();
            }
          }

      });
  }

  function newFormShippAddress() {
    main.checkout.prop.addresShipp = new Array();
    Vue.set(main.checkout.prop.addresShipp, 'tipo', 'ALTERNA');
    Vue.set(main.checkout.prop.addresShipp, 'folio', '');
    Vue.set(main.checkout.prop.addresShipp, 'dist_id', main.sessions.user.id);
}
function setNewValueVM(idComponent, keyAddresShipp) {

    var newValue = $('#saId-' + idComponent).val();
    Vue.set(main.checkout.prop.addresShipp, keyAddresShipp, newValue)
}

function getSaveAddressDist(data) {

    var arrayPost = {};

    arrayPost['iddireccion'] = data['iddireccion'];
    arrayPost['nombre'] = $('#saId-name').val();
    arrayPost['numero'] = "";
    arrayPost['condado'] = $('#saId-county').val();
    arrayPost['comp_env'] = $('#saId-servDelivery').val();
    arrayPost['nombre_cd'] = $('#saId-').val();
    arrayPost['colonia'] = "";
    arrayPost['folio'] = data['folio'];
    arrayPost['complemento'] = "";
    arrayPost['etiqueta'] = $('#saId-description').val();
    arrayPost['ciudad'] = $('#saId-city').val();
    arrayPost['cp'] = $('#saId-zipCode').val();
    arrayPost['estado'] = $('#saId-state').val();
    arrayPost['clv_pais'] = '';
    arrayPost['correo'] = $('#saId-email').val();
    arrayPost['direccion'] = $('#saId-address').val();
    arrayPost['telefono'] = $('#saId-phoneNumber').val();
    arrayPost['dist_id'] = main.sessions.user.id;
    arrayPost['tipo'] = data['tipo'];

    var urlCheckoutAddAddress = urlCheckout + 'addAddress';
    axios.post(urlCheckoutAddAddress, {addressForm: arrayPost}).then(function (response) {
        getListAddress();
        messageModalDynamic(response.data.userMessage, response.data.messageTitle, response.data.typeMessage);
    });

    $('#modalFormDirecShipp').modal('hide');
    $('#modalConfirmSaveAddress').modal('hide');

}

function getAddressDistMod(dataAddres, booleanDetele) {
    main.checkout.prop.addresShipp = new Array();
    for (var propiedad in dataAddres) {
        if (dataAddres.hasOwnProperty(propiedad)) {
            ////console.log("En la propiedad '" + propiedad + "' hay este valor: " + dataAddres[propiedad]);
            Vue.set(main.checkout.prop.addresShipp, propiedad, dataAddres[propiedad]);
        }
    }

    var zipCodeAddress = main.checkout.prop.addresShipp.cp.toString();
    main.checkout.prop.addresShipp.listCitys = [];
    if (zipCodeAddress.length >= 3) {
        var n = zipCodeAddress;
        while (n.length < 5) {
            n = "0" + n;
            zipCodeAddress = n;
            main.checkout.prop.addresShipp.cp = n;
        }
    }

    if (!booleanDetele && zipCodeAddress.length >= 5) {
        var urlCheckoutGetCitysZipCode =
                urlCheckout + 'getCatCitysZip/' + main.checkout.prop.addresShipp.cp
                + '/' + main.checkout.prop.addresShipp.estado;
        axios.get(urlCheckoutGetCitysZipCode).then(response => {
            Vue.set(main.checkout.prop.addresShipp, 'listCitys', response.data.citys);
        });

        var urlCheckoutGetCountysZipCode =
                urlCheckout + 'getCatCountysZip/' + main.checkout.prop.addresShipp.cp
                + '/' + main.checkout.prop.addresShipp.estado
                + '/' + main.checkout.prop.addresShipp.ciudad;
        axios.get(urlCheckoutGetCountysZipCode).then(response => {
            Vue.set(main.checkout.prop.addresShipp, 'lstCountys', response.data.countys);
        });

        var urlCheckoutGetShCompZipCode =
                urlCheckout + 'getShippComp/' + main.checkout.prop.addresShipp.clv_pais
                + '/' + main.checkout.prop.addresShipp.estado
                + '/' + main.checkout.prop.addresShipp.ciudad;
        axios.get(urlCheckoutGetShCompZipCode).then(response => {
            Vue.set(main.checkout.prop.addresShipp, 'lstShippsComp', response.data.arrShippsCompany);
        });
    }
}

function getStateByZipCode() {

    $('#saId-zipCode').val($('#saId-zipCode').val().match(/[0-9]*/));
    var zipCodeAddress = $('#saId-zipCode').val();
    if (zipCodeAddress.length >= 5) {
        var urlCheckoutGetStatesZipCode = urlCheckout + 'getStateZip/' + zipCodeAddress;
        axios.get(urlCheckoutGetStatesZipCode).then(function (response) {
            var urlCheckoutGetCitysZipCode = urlCheckout + 'getCatCitysZip/' + zipCodeAddress + '/' + response.data;
            axios.get(urlCheckoutGetCitysZipCode).then(function (responseCitys) {
                Vue.set(main.checkout.prop.addresShipp, 'estado', response.data);
                Vue.set(main.checkout.prop.addresShipp, 'cp', zipCodeAddress);
                Vue.set(main.checkout.prop.addresShipp, 'listCitys', responseCitys.data.citys);
            });
        });
    }
}

function getCountysZipCode() {
    var zipCode = $('#saId-zipCode').val();
    var state = $('#saId-state').val();
    var city = $('#saId-city').val();
    var shippCompany = $('#saId-servDelivery').val();
    var urlCheckoutGetCountysZipCode = urlCheckout + 'getCatCountysZip/' + zipCode + '/' + state + '/' + city;
    axios.get(urlCheckoutGetCountysZipCode).then(function (response) {
        var urlCheckoutGetShCompZipCode =
                urlCheckout + 'getShippComp/' + main.checkout.prop.addresShipp.clv_pais
                + '/' + state
                + '/' + city;
        axios.get(urlCheckoutGetShCompZipCode).then(function (responseShippsComp) {
            Vue.set(main.checkout.prop.addresShipp, 'comp_env', shippCompany);
            Vue.set(main.checkout.prop.addresShipp, 'ciudad', city);
            Vue.set(main.checkout.prop.addresShipp, 'lstCountys', response.data.countys);
            Vue.set(main.checkout.prop.addresShipp, 'lstShippsComp', responseShippsComp.data.arrShippsCompany);
        });
    });
}
function disableAddressShipp(folio) {
    var urldisabledAddressShipp = urlCheckout + 'disabledAddress/' + main.sessions.user.id + '/' + folio;
    axios.get(urldisabledAddressShipp).then(function (response) {
        messageModalDynamic(response.data.userMessage, response.data.messageTitle, response.data.typeMessage);
        getListAddress();
    });
    $('#modalConfirmDeleteAddress').modal('hide');

}

function changeAddressShipp(addressShp) {
    main.checkout.prop.addressShp = addressShp;
    main.addressChanging = true;
    main.sessions.all.zip.zip = main.checkout.prop.addressShp.cp;
    main.menu.method.zipChanged(main.checkout.prop.addressShp.cp);
}

  function getAddressShipSession(){
      
      var url =urlCheckout + 'getAddressShipSession';
      axios.get(url).then(function (response) {
        if (typeof (main.sessions.new_user.formReg.new_user) === 'undefined' || !main.sessions.new_user.formReg.new_user){
          main.checkout.prop.addressShp = response.data;
        }
      });

      setTimeout(function(){
         if (typeof (main.sessions.new_user.formReg) === 'undefined'
          || !main.sessions.new_user.formReg){
          var url =urlCheckout + 'getAddressShipSession';
          axios.get(url).then(function (response) {
              main.checkout.prop.addressShp = response.data;
          });  
         }
      },700);

  }

function CheckValidation(idmodal, formValidate) {
    let result = true;

    let inputsError = "<ul>";
    $("#"+formValidate+" input:text").each(function(){
        if ($(this).attr('readonly') != 'readonly' && ($(this).val().trim() == "" || $(this).val().length < 5)){
            result = false;
            inputsError = inputsError + '<li>'+($(this).data('msgvalidation'))+'</li>';
        }
    });
    inputsError = inputsError+("</ul>");


    if (result){
        $('#' + idmodal).modal('show');
    } else {
        var promise = getTranslate('validation.required', 'attribute',inputsError).then(function (responseContent) {
            getTranslate('welcome.common.attention', '', '').then(function (responseTitle) {
                messageModalDynamic(responseContent, responseTitle, '');
            });
        });
    }
}

function openNav() {
    $("#myNav").css({'display': 'block', 'width': '100%'});
//   .css('fontSize', '100px');
//      document.getElementById("myNav").style.width = "100%";
//     document.getElementById("myNav").style.display = "block";
}

function closeNav() {
    $("#myNav").css('display', 'none');
//    document.getElementById("myNav").style.width = "0%";
//      document.getElementById("myNav").style.display = "block";
}

function activeItem(item) {
    if (item === 1) {
        $("#package-1").addClass("active");
    }
}

/*** Function to show modal messages, if type is empty then take 'danger' value ***/
function messageModalDynamic(message, title, type) {
    switch (type) {
        case 'info':
            var icon = 'info';
            var color = 'products-colorBlue';
            break;
        case 'warning':
            var icon = 'times';
            var color = 'products-colorOrange';
            break;
        case 'success':
            var icon = 'check';
            var color = 'products-colorGreen';
            break;
        default:
            type = 'danger';
            var icon = 'times';
            var color = 'products-colorOrange';
            break;
    }
    var tagIcon = ' <i class="fa fa-' + icon + '-circle fa-2x ' + color + '" aria-hidden="true"></i>';

    if ($('#modalGeneralMessages').is(":visible")) {

        $("#modalGeneralMessages").find("#modalContentMessage").append('<br><br><p class="' + color + '">' + tagIcon + '  ' + message + '</p>');
    } else {
        if (type == '') {

        }
        var classTypeModal = "modal-header modal-header-" + type;

        $("#modalGeneralMessages").modal('show');

        $("#modalGeneralMessages").find("#modalHeaderMessage").removeClass().addClass(classTypeModal);
        $("#modalGeneralMessages").find("#modalGeneralMessagesTitle").html('').append(title);
        $("#modalGeneralMessages").find("#modalContentMessage").html('').append(tagIcon + '  ' + message);
    }
}

function modalContinuePayPal(message, title, type) {
    var classTypeModal = "modal-header modal-header-" + type;
    $("#modalContinuePayPal").find(".modalHeaderMessage").removeClass().addClass(classTypeModal);
    $("#modalContinuePayPal").find(".modalGeneralMessagesTitle").html('').append(title);
    $("#modalContinuePayPal").find(".modalContentMessage").html('').append(message);

    $("#modalContinuePayPal").modal('show');
}


/*** functions promotions ***/
function initPromotions() {
    var promoContinue = false;
    Object.values(main.promotion.prop.listPromotions).map(function (promotion) {
        if (promotion != null && !main.promotion.prop.promotionsSelected[promotion.type].selected && !promoContinue) {
            promoContinue = true;
        }
    });
    if (promoContinue) {
        getInitPromo();
        $("#modalPromosCheckout").modal("show");
    } else {
        return promoContinue;
    }

}

function addPromoSelected(type, promo) {
    main.promotion.prop.promoSelected["type"] = type;
    main.promotion.prop.promoSelected["promo"] = promo;
}

function getNextPromo() {
    if (checkValidationsPromo(main.promotion.prop.promoSelected)) {   
                desactivateBoton();
        let init = getInitPromo();
        if (!init) {
            $('#modalPromosCheckout').modal('hide');
                
            var promise = getTranslate('welcome.promotion.product_add_success', '', '').then(function (responseContent) {
                getTranslate('welcome.common.confirmation_message', '', '').then(function (responseTitle) {
                    modalContinuePayPal(responseContent, responseTitle, 'info');
                });
            });
            //$("#modalContinuePayPal").modal('show');
        }

        main.promotion.method.savePromotions();
        $("input[name='selectPromoRadio']").prop('checked', false);
    }
}
function callPaypal() {
    $(".loader").fadeIn("slow");
    let url = urlGeneral + "paypal/beforePayment";
    $('html, body').animate({
        scrollTop: $("#payment-method").offset().top
    }, 2000);
    //$("#wait").css("display", "block");
    //$('#principal_body').append('<div style="background-color: rgba(225, 225, 225, 0.7);position: absolute;top:0;left:0;width: 100%;height:100%;z-index:2;opacity:0.4;filter: alpha(opacity = 100)"></div>');
    window.location.href = url;
}   

function checkValidationRadiosPromo() {
    if (!$("input[name='selectPromoRadio']").is(':checked')) {
        var promise = getTranslate('welcome.promotion.choose_promotion_product', '', '').then(function (responseContent) {
            getTranslate('welcome.common.attention', '', '').then(function (responseTitle) {
                messageModalDynamic(responseContent, responseTitle, '');
            });
        });
    } else {
        $('#modalConfirmPromoProducts').modal('show');
    }

}

function checkValidationsPromo(promo) {
    // Validaciones de promociones guardadas
    if (main.checkout.prop.listProductsPromo.required == true) {
        if (!$("input[name='selectPromoRadio']").is(':checked')) {
            var promise = getTranslate('welcome.promotion.choose_promotion_product', '', '').then(function (responseContent) {
                getTranslate('welcome.common.attention', '', '').then(function (responseTitle) {
                    messageModalDynamic(responseContent, responseTitle, '');
                });
            });
            return false;
        }
    }
    main.promotion.prop.promotionsSelected[promo.type].selected = true;
    main.promotion.prop.promotionsSelected[promo.type].item = promo.promo.hasOwnProperty('isCombo') ? promo.promo.products : promo.promo;
    main.promotion.prop.promotionsSelected.anySelected = false;
    return true;
}

function getProductsPromo(promo) {
    if (main.promotion.prop.listPromotions[promo] != null) {
        main.checkout.prop.listProductsPromo = main.promotion.prop.listPromotions[promo];
    }
}

function getInitPromo() {
    let init = false;
    Object.values(main.promotion.prop.listPromotions).map(function (promotion) {
        if (promotion != null && !main.promotion.prop.promotionsSelected[promotion.type].selected && !init) {
            main.checkout.prop.listProductsPromo = promotion;
            init = true;
        }
    });
    return init;
}

function checkPromoProduct(booleanSkipPromo, type, productPromo) {
    $("input[name='selectPromoRadio']").closest('tr').find('.products-quantitySize').val('0');
    $("input[name='selectPromoRadio']").closest('tr').find('.sub_product').attr('disabled', true);
    $("input[name='selectPromoRadio']").closest('tr').find('.add_product').attr('disabled', true);
    if (booleanSkipPromo) {
        $("input[name='selectPromoRadio']").prop('checked', false);
    } else {
        $("input[name='selectPromoRadio']:checked").closest('tr').find('.products-quantitySize').val('1');
        $("input[name='selectPromoRadio']:checked").closest('tr').find('.sub_product').removeAttr('disabled');
        $("input[name='selectPromoRadio']:checked").closest('tr').find('.add_product').removeAttr('disabled');
    }
    addPromoSelected(type, productPromo);
}

function skipPromo(typePromotion) {
    main.promotion.prop.promotionsSelected[typePromotion]["selected"] = true;
    checkPromoProduct(true, typePromotion);
    getNextPromo();
}

/*** function to add and subtract products quantity ***/
/*** 1 = add, 2 = subtract ***/
function addSubProductPromo(action, objectVue) {

    if (action == 1) {
        if (objectVue.quantity < objectVue.max_quantity) {
            objectVue.quantity++;
        }
    } else {
        if (objectVue.quantity > 1) {
            objectVue.quantity--;
        }
    }
    objectVue.total = (objectVue.price * objectVue.quantity).toFixed(2);
}

function recalculateCart() {
    setTimeout(function () {
        let url = urlGeneral + "checkout/acceptedItems";;
        if ((main.sessions.new_user.formReg.name != null || main.sessions.all.adressShippDist != null)
            && (window.location.href.indexOf("/checkout/checkout")>-1 || window.location.href.indexOf("/checkout/checkout")>-1) ){
            $('#modalLstShippAddres').modal('hide');
            $(".loader").fadeIn("slow");
            axios.post(url, {
                sessionProductsCart: main.menu.prop.productsCart,
                parcel: main.kit.prop.saveKit.radio_kit,
            }).then(response => {
              if (response.data != null) {
                
                main.getAllSessionVariables();
                loadSessionProductsCart();
                getPromotions();
                main.menu.prop.totalPoints = response.data.total_points;
                main.menu.prop.ws = true;
                main.menu.prop.totalProductsCart = response.data.totalProductsCart;
                $(".loader").fadeOut("slow");
                if(main.menu.prop.quantityProductsCart == 0) {
                    window.location.replace(urlProductos);
                } else {
                    setTimeout(function(){
                        initPromotions();
                    },700);

                }
            }
            });
        }
    }, 2000);
}
function getPromotions() {
    let url = urlGeneral + "checkout/promotion";
    axios.get(url).then(response => {
        main.promotion.prop.listPromotions = response.data;
    });
}
function getPromotionsBuild() {
    let url = urlGeneral + "checkout/promotionsBuild";
    axios.get(url).then(response => {
        main.promotion.prop.listPromotions = response.data;
    });
}

function resetChangingVariables() {
    main.addressChanging = false;
    main.zipChanging = false;
    main.menu.prop.changingZip = false;
    main.showZipError = false;
}

function getTranslate(translate, name_attr, attr) {
    if (name_attr == '') {
        name_attr = false;
        attr = false;
    }
    ////console.log(name_attr);
    ////console.log(attr);
    return axios.post(apiUrl+'/getTranslate', {

        translate: translate,
        name_attr: name_attr,
        attr: attr,
    }).then(response => {
        if (response.data != null) {
            return response.data;
        }
    });

}



//  //Function to validate address shipping required
//$("#payment-method").ready(function () {
//    getListAddress(true);
//});

function getProductsByBenefitId() {
     $("#products-not-found").remove();
    var urlProducts = urlArticulos + 'products-Benefits/';
    axios.get(urlProducts).then(response => {
        main.product.method.paginationProducts(response.data.products);
        response.data.products.data.forEach(function (product) {
            product.price = currency(product.price, 2, [',', "'", '.']);
        });
        main.product.prop.list_products = response.data.products;
        main.product.prop.list_categories = response.data.categories;
        main.product.prop.list_benefits = response.data.benefits;
        main.product.prop.product.detail_product.product_selected = "";
        urlSelected = response.data.urlSelected;
      linksUrl =urlGeneral+ response.data.url;
    });
    //console.log("benefits");
}

function closeDetail() {
    if(main.product.prop.product.redirect_home) {
        window.location.replace(productsUrl);
    } else {
        $('#product-detail').hide();
        $('#products-content').show();
    }
}

function goCheckout() {
    if (main.menu.prop.quantityProductsCart > 0) {
        if(main.sessions.all.selected_kit != undefined && main.sessions.all.selected_kit.sku != undefined) 
            window.location.replace(urlGoCheckout);
        else if ($(location)[0].pathname != "/checkout/checkout/" && $(location)[0].pathname != "/checkout/checkout") {
            if (main.sessions.new_user.selected_kit.sku || main.sessions.all.userId)
                $(location).attr('href', urlCheckout+'checkout');
            else {
                main.menu.prop.goCheckout = true;
                $('#loginModal').modal('show');
            }
        } else
            main.recalculateCart();
    }
    else
        window.location.replace(urlProductos);
}

function unsetPromotionsAndRecalculate() {
    main.promotion.method.unsetSessionPromotions();
    location.reload();
}
function contract() {
   var w = window.open('/inscription/pdf', '_blank');
   if (!w){
        var promise = getTranslate('welcome.alerts.popup_block').then(function (responseContent) {
            getTranslate('welcome.common.attention').then(function(responseTitle){
            messageModalDynamic(responseContent, responseTitle, '');
            });
        });
    }
}
function detectIE() {
var browser=get_browser_info();
//alert(browser.name +" "+ browser.version);
    if (browser.name == "Chrome" && browser.version <=50){
        alert("La plataforma se encuentra optimizada para un navegador mas actualizado.");
    }
    else if(browser.name == "Firefox" && browser.version <=50){
        alert("La plataforma se encuentra optimizada para un navegador mas actualizado.");
    }
    else if(browser.name == "Firefox" && browser.version <=50){
        alert("La plataforma se encuentra optimizada para un navegador mas actualizado.");
    }
    else if (browser.name == "IE"){
        alert("La plataforma se encuentra optimizada para un navegador mas actualizado.");   
    }
}
function get_browser_info(){
    var ua=navigator.userAgent,tem,M=ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || []; 
    if(/trident/i.test(M[1])){
        tem=/\brv[ :]+(\d+)/g.exec(ua) || []; 
        return {name:'IE ',version:(tem[1]||'')};
        }   
    if(M[1]==='Chrome'){
        tem=ua.match(/\bOPR\/(\d+)/)
        if(tem!=null)   {return {name:'Opera', version:tem[1]};}
        }   
    M=M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
    if((tem=ua.match(/version\/(\d+)/i))!=null) {M.splice(1,1,tem[1]);}
    return {
      name: M[0],
      version: M[1]
    };
 }
function cancelOrderRejected(){
  var url =urlGeneral+"checkout/cancelOrderRejected"
    axios.get(url).then(response =>  {
      if (response.data){
        var promise = getTranslate('welcome.payment.order_canceled').then(function (responseContent) {
          getTranslate('welcome.common.attention').then(function(responseTitle){
          messageModalDynamic(responseContent, responseTitle, 'info');
        });
      });
        setTimeout(function(){ window.location.href = urlGeneral; }, 2000);
      }
  });
}

function genericSocialShare(id, product_name, social_network){
    let finalUrl = '';
    switch(social_network){
        case 'fb':
            //?title"+product_name+"
            finalUrl = "http://www.facebook.com/sharer.php?u="+urlProductos+"/detailProduct/"+id+"&t="+product_name;
            break;
        case 'tw':
            finalUrl = "http://twitter.com/share?text="+product_name+"&url="+urlProductos+'/detailProduct/'+id;
            break;
        default:
            finalUrl = "http://www.facebook.com/sharer.php?u="+urlProductos+'/detailProduct/'+id;
            break;
    }

    window.open(finalUrl,'sharer','toolbar=0,status=0,width=648,height=395');
    return true;
}

function printDiv() {
  var divToPrint=document.getElementById('divToPrint');
  var newWin=window.open('','Print-Window');
  newWin.document.open();
  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
  newWin.document.close();
  setTimeout(function(){newWin.close();},10);
    if (!newWin){
        var promise = getTranslate('welcome.alerts.popup_block').then(function (responseContent) {
            getTranslate('welcome.common.attention').then(function(responseTitle){
            messageModalDynamic(responseContent, responseTitle, '');
            });
        });
    }
}

