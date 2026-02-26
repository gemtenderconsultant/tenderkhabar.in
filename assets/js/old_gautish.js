var busy = false;
var subcategory_list = [];
var dipartment_list = [];
var keyword_list = [];
var state_list = [];
var city_list = [];
var offset = 1;
var limit = 10;
var subcategory_offset = 1;
var subcategory_limit = 10;
var keyword_offset = 1;
var keyword_limit = 10;
var searchField = "";
var loadcity = false;

$('.dropdown').on('shown.bs.dropdown', function () {
  $('#backdrop').addClass('backdrop');
})

$('.dropdown').on('hide.bs.dropdown', function () {
  $('#backdrop').removeClass('backdrop');
})


// $("#Live").scroll(function() {
    
//     var t = $(this)[0].scrollHeight - 100;
//     var t2 = $(this).scrollTop() + $(this).innerHeight();
//     var html = '';
//     if(t2 >= t) {
        
//         if (busy == false) { 
//             busy = true;
//             offset = 1 + offset;
//         }
    
//     }
// });

$(document).ready(function(){
 $.fn.delayKeyup = function(callback, ms){
    var timer = 0;
    var el = $(this);
    //$(this).keyup(function(){ 
    $('body').on('keyup', $(this), function(){        
    clearTimeout (timer);
    timer = setTimeout(function(){
        callback(el)
        }, ms);
    });
    return $(this);
};   
 
$(window).scroll(function () {
    // make sure u give the container id of the data to be loaded in.
    //var t = $(document).height() - 480;
    
    if($(window).width() < 767){
        var t = $(document).height() - 1850;
    } else {
        var t = $(document).height() - 900; // 480
    }
    var t2 = $(window).scrollTop() + $(window).height();
    //if ($(window).scrollTop() + $(window).height() > $("#lev1").height() && !busy) {
     if (t2 >= t) { 
         //console.log(t);
         //alert(t2+' '+t);
        if (busy == false) { 
        busy = true;
        offset = 1 + offset;
        // this is optional just to delay the loading of data
        setTimeout(function () {
            getFilter2(offset);
        }, 500);
        }
        // you can remove the above code and can use directly this function
        // displayRecords(limit, offset);

    }
});
$('.dropdown-toggle').on('shown.bs.dropdown', function () {
        if($(this).attr('data-title') == "category"){
            tabloadcategory();
        }
        if($(this).attr('data-title') == "keywords"){
            tabloadkeyword();
        }
        if($(this).attr('data-title') == "dipartment"){
            tabloaddepartment();
        }
        if($(this).attr('data-title') == "state"){
            tabloadstate(); 
        }
        if($(this).attr('data-title') == "city"){
            tabloadcity();
        }
});
 
    
    
    //$('.searchkeywords').keyup(function () {
    $('body').on('keyup', '.searchkeywords', function(){    
        var value = $(this).val().toLowerCase();
        var $li = $(".searchkeyword_tr");

        $li.hide();
        $li.filter(function () {
            return $(this).text().toLowerCase().indexOf(value) > -1;
        }).show();
    });
    
    $('.searchsubcategory').delayKeyup(function(){
            $('.list_login_subcategory_list').html('');
            countsubcat = 1;
            busy_subcategory = false;
            if($(".remove_login_select_subcategory").length > 0){
                $(".remove_login_select_subcategory").each(function () {
                    var stitle = $(this).text();
                    stitle = $.trim(stitle);
                    if($(".subcategoryid[data='"+stitle+"']").length == 0){  
                        $('.list_login_subcategory_list').append('<div class="form-check col-md-6 searchkeyword_tr"><input class="form-check-input subcategoryid" data-title="'+stitle+'" checked type="checkbox" value="'+$(this).attr('data')+'" id="sFilters_subcategory_'+$(this).attr('data')+'" data="'+stitle+'" name="Filters[subcategoryid][]"/><label class="form-check-label" for=sFilters_subcategory_'+$(this).attr('data')+'>'+stitle+'</label></div>');
                    }
                });
            }
           
          get_subcategory_data();
    },500);
    
    $(".subcategory_scroll_div").scroll(function(e) {
    //$('.subcategory_scroll_div').on('scroll', function (e) {    
    //$('body').on('scroll', ".subcategory_scroll_div", function(e){  
    //$(document).on('scroll', ".subcategory_scroll_div", function (e) {
        e.preventDefault();
        var t = $(this)[0].scrollHeight - 100;
        var t2 = $(this).scrollTop() + $(this).innerHeight();
        var html = '';
        if(t2 >= t) {
            if (busy_subcategory == false) { 
                busy_subcategory = true;
                countsubcat = 1;
                get_subcategory_data();
            }
        }
    });
    
    $('.search_filter_text_keyword').delayKeyup(function(){
            $('.list_login_keyword_list').html('');
            countkeyword = 1;
            busy_keyword = false;
            if($(".remove_login_select_keyword").length > 0){
                $(".remove_login_select_keyword").each(function (i,item) {
                    var stitle = $(this).text();
                    stitle = $.trim(stitle);
                    if($(".keywordid[data='"+stitle+"']").length == 0){  
                        $('.list_login_keyword_list').append('<div class="form-check col-md-6 searchkeyword_tr"><input class="form-check-input keywordid" data-title="'+stitle+'" checked type="checkbox" value="'+stitle+'" id="ssFilters_keyword_'+i+'" data="'+stitle+'" name="Filters[keyword][]"/><label class="form-check-label" for="ssFilters_keyword_'+i+'">'+stitle+'</label></div>');
                    }
                });
            }
           
          get_keyword_data();
    },500);
    
    $(".keyword_scroll_div").scroll(function(e) {
        e.preventDefault();
        var t = $(this)[0].scrollHeight - 100;
        var t2 = $(this).scrollTop() + $(this).innerHeight();
        var html = '';
        if(t2 >= t) {
            if (busy_keyword == false) { 
                busy_keyword = true;
                countkeyword = 1;
                get_keyword_data();
            }
        }
    });
  
    $('.search-department').delayKeyup(function(){
            $('.dipartment-list').html('');
            countdept = 1;
            busy_dept = false;
            if($(".remove_login_select_dipartment").length > 0){
                $(".remove_login_select_dipartment").each(function () {
                    var stitle = $(this).text();
                    stitle = $.trim(stitle);
                    if($(".agencyid[data-id='"+$(this).attr('data')+"']").length == 0){  
                        $('.dipartment-list').append('<div class="form-check col-md-6"><input class="form-check-input agencyid" data-title="'+stitle+'" checked type="checkbox" value="'+$(this).attr('data')+'" id="dipartment_'+$(this).attr('data')+'" data="'+stitle+'" data-id="'+$(this).attr('data')+'" name="Filters[agency][]"/><label class="form-check-label" for="dipartment_'+$(this).attr('data')+'">'+stitle+'</label></div>');
                    }
                });
            }
           
          get_dipartment_data();
    },500);
    $(".dipartment-div").scroll(function(e) {
        e.preventDefault();
        var t = $(this)[0].scrollHeight - 100;
        var t2 = $(this).scrollTop() + $(this).innerHeight();
        var html = '';
        if(t2 >= t) {
            if (busy_dept == false) { 
                busy_dept = true;
                countdept = 1;
                get_dipartment_data();
            }
        }
    });
});

$('.filter_update').hide();
$('.delete_filter_confirmation').hide();
$('body').on('click', '.delete_filter', function(){
    $(this).parents('.delete_filter_main').find('.delete_filter_confirmation').show();
});
$('body').on('click', '.delete_filter_cancel', function(){
    $(this).parents('.delete_filter_confirmation').hide();
});

$('body').on('click','.BtnTxt', function(){ // saved_filter_toggle_btn
    $("input[name='example1']").prop('checked', false);
    $(this).parent('.accordion-button').find('input[name="example1"]').prop('checked', true);
    var chkid = $(this).parents('.accordion-header').find('input[name="example1"]').attr('data-main');
    var chkfilterid = $('input[name="example1"]:checked').attr('data'); 
    //alert(chkid+' '+chkfilterid); aria-expanded
    //var chkcollapse = $(this).parents('button').attr('aria-expanded');
    if($(this).parents('.accordion-button').hasClass('collapsed')){
        $('.filter_update').hide();
    } else {
        //alert(chkid);
        if(chkid == 0){
            var chkchange = $('input[name="updatefiltermsg_'+chkfilterid+'"]').val();
            if(chkchange == 1){
            $('.filter_update').show();
            }else{
              $('.filter_update').hide();  
            }
        } else {
            $('.filter_update').hide();
        }
        
    }
});   
//search filter text
$('.search_filter_text').keyup(function () {
    var value = $(this).val().toLowerCase();
    //var $li = $(this).closest(".dropdown-menu").find(".form-check-label");
    var $li2 = $(this).closest(".dropdown-menu").find('.col-md-6');
    $li2.hide();
    $li2.filter(function () {
        return $(this).find(".form-check-label").text().toLowerCase().indexOf(value) > -1;
    }).show();
});
$('body').on('click', '.amountfilter', function(){
    var text = $(this).attr('id');
    if(text == 'tamount_below_one_lac'){
        $('#txtminprice').val(0);
        $('#txtmaxprice').val(100000);
    } else if(text == 'tamount_one_lac_one_cr'){
        $('#txtminprice').val(100000);
        $('#txtmaxprice').val(10000000);
    } else if(text == 'tamount_one_cr_ten_cr'){
        $('#txtminprice').val(10000000);
        $('#txtmaxprice').val(100000000);
    } else if(text == 'tamount_ten_cr_hundred_cr'){
        $('#txtminprice').val(100000000);
        $('#txtmaxprice').val(1000000000);
    } else if(text == 'tamount_hundred_cr_above'){
        $('#txtminprice').val(1000000000);
        $('#txtmaxprice').val('');
    } else {
        
    }
});

// var dropdownMenu;
// $('#scroll-div .dropdown').on('show.bs.dropdown', function (e) {
//     dropdownMenu = $(e.target).find('.dropdown-menu');
//     $('body').append(dropdownMenu.detach());
//     // grab the new offset position
//     var eOffset = $(e.target).offset();
//     // make sure to place it where it would normally go (this could be improved)
//     dropdownMenu.css({
//         'display': 'block',
//         'width': '30rem',
//         'top': eOffset.top + $(e.target).outerHeight(),
//         'left': eOffset.left
//     });
// });

// $('#scroll-div .dropdown').on('hide.bs.dropdown', function (e) {
//     $(e.target).append(dropdownMenu.detach());
//     dropdownMenu.hide();
// });
$('body').on('click', '.remove_adding_item', function (e) {
    $(this).remove();
    var count = $(".remove_adding_item").length;
    $(".filtercount").text('');
    $(".filtercount").text(count);
 });

$('body').on('click', '.filter_create', function (e) {
       $(".filter_main_wrap").find("input[name='example1']").prop('checked', false); 
       var filterid = 0;
       var filtername = $("#filter_new_name").val();
       var filtercount = $(".filtercount").text(); 
       filtercount = parseInt(filtercount);
       if(filtercount > 0){
           if(filtername != ""){
               selected_filter_add_merge(filterid,filtername);
               //$("#modalFilterSave").modal('hide'); //close pop up 
               
           }else{
               $(".filter_name_error").text("Please enter filter name");
           }
       }else{
           $(".filter_name_error").text("Please select atleast one items");
       }
});
$('body').on('click', '.merge_filter', function (e) {
    //var filterid = $(this).attr('data');
    var checkselect = $(".modal_filter_main_wrap").find("input[name='example1']:checked").length; 
    if(checkselect > 0){
      var filterid = $(".modal_filter_main_wrap").find("input[name='example1']:checked").attr('data');
      $('input[name="updatefiltermsg_'+filterid+'"]').val(0);
      $(".updatefiltermsg_filteryes,.updatefiltermsg_filterno").attr('data','');
      $(".updatefiltermsg_popup").hide();   
      //selected_filter_update(filterid); 
      //var filtername = $(".modal_filter_main_wrap").find("input[name='example1']:checked").attr('data');
      var collapseid = $(".modal_filter_main_wrap").find("#collapse_"+filterid);
      var filtername = $(collapseid).find("input[name='filter_name_input']").val();
      selected_filter_add_merge(filterid,filtername);
      $("#modalFilterSave").modal('hide');
    }else{
      $(".filter_select_error").text("Please select any filter"); 
    }
});
$(".filter_update").click(function(e){
     var data = $(this).attr('data');
     var filterid = $("."+data).find("input[name='example1']:checked").attr('data');
     //filterid = 1;
      selected_filter_update(filterid);   
});
$('body').on('click', '.updatefiltermsg_filteryes', function (e) {
       var filterid = $(this).attr('data');
       if(filterid != ""){
       $('input[name="updatefiltermsg_'+filterid+'"]').val(0);
       $(".updatefiltermsg_filteryes,.updatefiltermsg_filterno").attr('data','');
       $(".updatefiltermsg_popup").hide();   
       selected_filter_update(filterid);   
       }
});
$('body').on('click', '.updatefiltermsg_filterno', function (e) {
   var data = $(this).attr('data');
   $('input[name="updatefiltermsg_'+data+'"]').val(0);
   $(".updatefiltermsg_filteryes,.updatefiltermsg_filterno").attr('data','');
   $(".updatefiltermsg_popup").hide();   
});

$('body').on('keyup', 'input[name="filter_name_input"]', function (e) {   
    var txt = $(this).val();
    var chkmainid = $('input[name="example1"]:checked').attr('data-main'); 
    var chkid = $('input[name="example1"]:checked').attr('data'); 
    if(txt != ""){
    if(chkmainid == 0){
        $('input[name="updatefiltermsg_'+chkid+'"]').val(1); 
    }
    if(chkmainid == 0){
         var chkchange = $('input[name="updatefiltermsg_'+chkid+'"]').val(); 
        if(chkchange == 1){
        $('.filter_update').show();
        }else{
          $('.filter_update').hide();  
        }
    }else{
        $('.filter_update').hide();  
    }
    }else{
        $('input[name="updatefiltermsg_'+chkid+'"]').val(0); 
        $('.filter_update').hide();  
    }
    return false;
});
$('body').on('click', '.remove_item', function (e) {    
    var chkmainid = $('input[name="example1"]:checked').attr('data-main'); 
    var chkid = $('input[name="example1"]:checked').attr('data'); 
    if(chkmainid == 0){
        $('input[name="updatefiltermsg_'+chkid+'"]').val(1); 
    }
    if(chkmainid == 0){
         var chkchange = $('input[name="updatefiltermsg_'+chkid+'"]').val(); 
        if(chkchange == 1){
        $('.filter_update').show();
        }else{
          $('.filter_update').hide();  
        }
    }else{
        $('.filter_update').hide();  
    }
    $(this).remove();
    return false;
});

$(".updatefiltermsg_popup").hide();
$('.umodalFilterSave').hide();
$('.umodalFilterSave').attr('disabled','disabled');

$('body').on('click','.filter_apply',function(e){
    var filterid = $(".saved_filter_body_scroll").find("input[name='example1']:checked").attr('data');
    var filteridname = $.trim($(".saved_filter_body_scroll").find('label[for="customCheck_'+filterid+'"]').attr('data-text'));
    
    if(filteridname != "My Preference"){
        $('.umodalFilterSave').removeAttr('disabled');
        $('.umodalFilterSave').attr('data',filterid);
        $('.umodalFilterSave').show();
    }else{
        $('.umodalFilterSave').attr('disabled','disabled');
        $('.umodalFilterSave').attr('data','');
        $('.umodalFilterSave').hide();
    }
    $(".buttonsavedfilters").text(filteridname);
    
    var chkfiltermainid = $('input[name="example1"]:checked').attr('data-main'); 
    var chkfilterid = $('input[name="example1"]:checked').attr('data'); 
    
    if(chkfiltermainid == 0){
        var chkchange = $('input[name="updatefiltermsg_'+chkfilterid+'"]').val();
        if(chkchange == 1){
        $(".updatefiltermsg_filteryes").attr('data',chkfilterid);
        $(".updatefiltermsg_filterno").attr('data',chkfilterid);
        $(".updatefiltermsg_popup").show();
        }else{
          $(".updatefiltermsg_filteryes,.updatefiltermsg_filterno").attr('data','');
          $(".updatefiltermsg_popup").hide();   
        }
    }else{
       $(".updatefiltermsg_filteryes,.updatefiltermsg_filterno").attr('data','');
       $(".updatefiltermsg_popup").hide(); 
    }
    
    var collapseid = $(".filter_main_wrap").find("#collapse_"+filterid);
    $(".stateid,.agencyid,.keywordid,.productid,.categoryid,.subcategoryid").prop( "checked", false);
     
     
    if($(collapseid).find(".filter_product").length > 0){ // gautish
        var product = new Array();
        $(".list_selected_login_product").html('');
        $($(collapseid).find(".filter_product")).each(function () {
            product.push($(this).attr('data'));
            $('.product_count').html('('+$(collapseid).find(".filter_product").length+')');
            $(".list_selected_login_product").append('<li class="badge bg-primary rounded-0 BtnAddList remove_login_select_product remove_item" data="'+$(this).attr('data')+'">'+$(this).attr('title')+'<i class="fa-solid fa-xmark"></i></li>');
            var checked = '';
            if($(".productid[value='"+$(this).attr('data')+"']").length == 0){
                //$(".list_login_product_list").append('<div class="form-check col-md-6 searchkeyword_tr"><input class="form-check-input productid" type="checkbox" name="Filters[product][]" id="sFilters_product_'+$(this).attr('data')+'" data="'+$(this).attr('title')+'" value="'+$(this).attr('data')+'"><label class="form-check-label" for="sFilters_product_'+$(this).attr('data')+'">'+$(this).attr('data')+'</label></div>');
            }
            $(".productid[value='"+$(this).attr('data')+"']").prop( "checked", true);
        });
        $("input[name='input_s_product']").val(product.join(","));
    }else{
        $(".list_selected_login_product").html('');
        $("input[name='input_s_product']").val('');
        $('.product_count').html("");
    }
     
    if($(collapseid).find(".filter_eproduct").length > 0){ // gautish 
        var eproduct = new Array();
        $(".list_selected_login_exe_product").html('');
        $('.eproduct_count').html('('+$(collapseid).find(".filter_eproduct").length+')');
        $($(collapseid).find(".filter_eproduct")).each(function () {
            eproduct.push($(this).attr('data'));
            $(".list_selected_login_exe_product").append('<li class="badge bg-primary rounded-0 BtnAddList remove_login_select_exe_product remove_item" data="'+$(this).attr('data')+'">'+$(this).attr('title')+'<i class="fa-solid fa-xmark"></i></li>');
        });
        $("input[name='input_s_eproduct']").val(eproduct.join(","));
    }else{
        $(".list_selected_login_exe_product").html('');
        $("input[name='input_s_eproduct']").val('');
        $('.eproduct_count').html("");
    }
     
    if($(collapseid).find(".filter_category").length > 0){ // gautish 
        
        var category = new Array();
        $(".list_selected_login_category").html(''); 
        $('.main_category_count').html('('+$(collapseid).find(".filter_category").length+')');
        $($(collapseid).find(".filter_category")).each(function () {
            category.push($(this).attr('data'));
            
            $(".list_selected_login_category").append('<li class="badge bg-primary rounded-0 BtnAddList remove_login_select_category remove_item" data="'+$(this).attr('data')+'">'+$(this).text()+'<i class="fa-solid fa-xmark"></i></li>');
            
            var checked = '';
            
            if($(".categoryid[value='"+$(this).attr('data')+"']").length == 0){
                //$(".list_login_category_list").append('<div class="col-md-6"><div class="form-check my-1"><label class="form-check-label"><input type="checkbox" name="Filters[category][]" class="form-check-input categoryid" id="sFilters_category_'+$(this).attr('data')+'" data="'+$(this).attr('title')+'" value="'+$(this).attr('data')+'">'+$(this).attr('title')+'<i class="input-helper"></i></label></div></div>');
            }
            
            $(".categoryid[value='"+$(this).attr('data')+"']").prop( "checked", true);
        });
        $("input[name='input_s_category']").val(category.join(","));
    }else{
        $('.main_category_count').html("");
        $(".list_selected_login_category").html('');
        $("input[name='input_s_category']").val('');
    }
    
    if($(collapseid).find(".filter_ecategory").length > 0){ //gautish 
        var ecategory = new Array();
        $(".list_selected_login_exe_category").html('');
        $('.emaincategory_count').html('('+$(collapseid).find(".filter_ecategory").length+')');
        $($(collapseid).find(".filter_ecategory")).each(function () {
            ecategory.push($(this).attr('data'));
            $(".list_selected_login_exe_category").append('<li class="badge bg-primary rounded-0 BtnAddList remove_login_select_exe_category remove_item" data="'+$(this).attr('data')+'">'+$(this).attr('title')+'<i class="fa-solid fa-xmark"></i></li>');
            
        });
        $("input[name='input_s_ecategory']").val(ecategory.join(","));
    }else{
        $('.emaincategory_count').html("");
        $(".list_selected_login_exe_category").html('');
        $("input[name='input_s_ecategory']").val('');
    }
    
    if($(collapseid).find(".filter_subcategory").length > 0){
        var subcategory = new Array();
        $(".list_selected_login_subcategory").html('');
        $('.subcategory_count').html('('+$(collapseid).find(".filter_subcategory").length+')');
        $($(collapseid).find(".filter_subcategory")).each(function () {
            subcategory.push($(this).attr('data'));
            $(".list_selected_login_subcategory").append('<li class="badge bg-primary rounded-0 BtnAddList remove_login_select_subcategory remove_item" data="'+$(this).attr('data')+'">'+$(this).attr('title')+' <i class="fa-solid fa-xmark"></i></li>');
            var checked = '';
            if($(".subcategoryid[value='"+$(this).attr('data')+"']").length == 0){
             $('.list_login_subcategory_list').append('<div class="form-check col-md-6 searchkeyword_tr"><input class="form-check-input subcategoryid" data-title="'+$(this).attr('title')+'" checked type="checkbox" value="'+$(this).attr('data')+'" id="sFilters_subcategory_'+$(this).attr('data')+'" data="'+$(this).attr('title')+'" name="Filters[subcategoryid][]"/><label class="form-check-label" for=sFilters_subcategory_'+$(this).attr('data')+'>'+$(this).attr('title')+'</label></div>');
            }
            $(".subcategoryid[value='"+$(this).attr('data')+"']").prop( "checked", true);
        });
        $("input[name='input_s_subcategory']").val(subcategory.join(","));
    }else{
        $(".list_selected_login_subcategory").html('');
        $("input[name='input_s_subcategory']").val('');
        $('.subcategory_count').html("");
    } 
    
    if($(collapseid).find(".filter_esubcategory").length > 0){ // set html 
        var esubcategory = new Array();
        $(".list_selected_login_exe_subcategory").html('');
        $('.exe_subcategory_count').html('('+$(collapseid).find(".filter_esubcategory").length+')');
        $($(collapseid).find(".filter_esubcategory")).each(function () {
            esubcategory.push($(this).attr('data'));
            $(".list_selected_login_exe_subcategory").append('<li class="badge bg-primary rounded-0 BtnAddList remove_login_select_exe_subcategory remove_item" data="'+$(this).attr('data')+'">'+$(this).attr('title')+' <i class="fa-solid fa-xmark"></i></li>');
        });
        $("input[name='input_s_esubcategory']").val(esubcategory.join(","));
    }else{
        $('.exe_subcategory_count').html('');
        $(".list_selected_login_exe_subcategory").html('');
        $("input[name='input_s_esubcategory']").val('');
    } 
    
    if($(collapseid).find(".filter_org").length > 0){
        var agency = new Array();
        $(".list-selected-dipartment").html('');
        $('.dipartment_count').html('('+$(collapseid).find(".filter_org").length+')');
        $($(collapseid).find(".filter_org")).each(function () {
            agency.push($(this).attr('data'));
            $(".list-selected-dipartment").append('<li class="badge bg-primary rounded-0 BtnAddList remove_login_select_dipartment remove_item" data="'+$(this).attr('data')+'">'+$(this).attr('title')+'<i class="fa-solid fa-xmark"></i></li>');
            var checked = '';
            if($(".agencyid[value='"+$(this).attr('data')+"']").length == 0){
            $('.dipartment-list').append('<div class="form-check col-md-6"><input class="form-check-input agencyid" data-title="'+$(this).attr('title')+'" checked type="checkbox" value="'+$(this).attr('data')+'" id="dipartment_'+$(this).attr('data')+'" data="'+$(this).attr('title')+'" data-id="'+$(this).attr('data')+'" name="Filters[agency][]"/><label class="form-check-label" for="dipartment_'+$(this).attr('data')+'">'+$(this).attr('title')+'</label></div>')
            }
            $(".agencyid[value='"+$(this).attr('data')+"']").prop( "checked", true);
        });
        $("input[name='input_s_org']").val(agency.join(","));
    }else{
        $('.dipartment_count').html('');
        $(".list-selected-dipartment").html('');
        $("input[name='input_s_org']").val('');
    }
    
    if($(collapseid).find(".filter_eorg").length > 0){ //set html 
        var eagency = new Array();
        $(".list-selected-exe-dipartment").html('');
        $('.exe_dipartment_count').html('('+$(collapseid).find(".filter_eorg").length+')');
        $($(collapseid).find(".filter_eorg")).each(function () {
            eagency.push($(this).attr('data'));
            $(".list-selected-exe-dipartment").append('<li class="badge bg-primary rounded-0 BtnAddList remove_login_select_exe_dipartment remove_item" data="'+$(this).attr('data')+'">'+$(this).attr('title')+'<i class="fa-solid fa-xmark"></i></li>');
        });
        
        $("input[name='input_s_eorg']").val(eagency.join(","));
    }else{
        $('.exe_dipartment_count').html('');
        $(".list-selected-exe-dipartment").html('');
        $("input[name='input_s_eorg']").val('');
    }
    
    if($(collapseid).find(".filter_keyword").length > 0){
        var keyword = new Array();
        $(".list_selected_login_keyword").html('');
        $(".keyword_count").html('('+$(collapseid).find(".filter_keyword").length+')');
        var keyidstart = 100000;
        $($(collapseid).find(".filter_keyword")).each(function () {
            keyword.push($(this).attr('data'));
            $(".list_selected_login_keyword").append('<li class="badge bg-primary rounded-0 BtnAddList remove_login_select_keyword" data="'+$(this).attr('data')+'">'+$(this).attr('data')+'<i class="fa-solid fa-xmark"></i></li>');
            var checked = '';
            var stitle = $(this).attr('data');
            stitle = $.trim(stitle);
            if($(".keywordid[value='"+$(this).attr('data')+"']").length == 0){
            $('.list_login_keyword_list').append('<div class="form-check col-md-6 searchkeyword_tr"><input class="form-check-input keywordid" data-title="'+stitle+'" checked type="checkbox" value="'+stitle+'" id="ssFilters_keyword_'+keyidstart+'" data="'+stitle+'" name="Filters[keyword][]"/><label class="form-check-label" for="ssFilters_keyword_'+keyidstart+'">'+stitle+'</label></div>');
            }
            $(".keywordid[value='"+$(this).attr('data')+"']").prop( "checked", true);
            keyidstart++;
        });
        $("input[name='input_s_keyword']").val(keyword.join(","));
        
    }else{
        $(".list_selected_login_keyword").html('');
        $("input[name='input_s_keyword']").val('');
        $(".keyword_count").html("");
    }
    
    if($(collapseid).find(".filter_ekeyword").length > 0){ //set html 
        var ekeyword = new Array();
        
        $(".list_selected_login_ekeyword").html('');
        $('.excluding_keyword_count').html('('+$(collapseid).find(".filter_ekeyword").length+')');
        $($(collapseid).find(".filter_ekeyword")).each(function () {
            ekeyword.push($(this).attr('data'));
            $(".list_selected_login_ekeyword").append('<li class="badge bg-primary rounded-0 BtnAddList remove_login_select_ekeyword remove_item" data="'+$(this).attr('data')+'">'+$(this).attr('data')+'<i class="fa-solid fa-xmark"></i></li>');
        });
        $("input[name='input_s_ekeyword']").val(ekeyword.join(","));
    }else{
        
        $('.excluding_keyword_count').html('');
        $(".list_selected_login_ekeyword").html('');
        $("input[name='input_s_ekeyword']").val('');
    }
    
    if($(collapseid).find(".filter_state").length > 0){
        var state = new Array();
        $(".list_selected_login_state").html('');
        $(".state_count").html('('+$(collapseid).find(".filter_state").length+')');
        $($(collapseid).find(".filter_state")).each(function () {
            state.push($(this).attr('data'));
            $(".list_selected_login_state").append('<li class="badge bg-primary rounded-0 BtnAddList remove_login_select_state" data="'+$(this).attr('data')+'">'+$(this).attr('title')+'<i class="fa-solid fa-xmark"></i></li>');
            var checked = '';
            if($(".stateid[data='"+$(this).attr('title')+"']").length == 0){  
                $('.state_list').append('<div class="form-check col-md-6 searchkeyword_tr">'+
                    '<input class="form-check-input stateid" type="checkbox" value='+$(this).attr('data')+' id="sFilters_state_'+$(this).attr('data')+'" name="Filters[state][]" data="'+$(this).attr('title')+'">'+
                    '<label class="form-check-label" for="sFilters_state_'+$(this).attr('data')+'">'+$(this).attr('title')+'</label>'+
                '</div>');
            }
            $(".stateid[value='"+$(this).attr('data')+"']").prop( "checked", true);
        });
        $("input[name='input_s_state']").val(state.join(","));
    }else{
        $(".state_count").html('');
        $(".list_selected_login_state").html('');
        $("input[name='input_s_state']").val('');
    }
    
    $(".cityid").prop( "checked", false);
    if($(collapseid).find(".filter_city").length > 0){
        var city = new Array();
        $(".list_selected_login_city").html('');
        $('.city_count').html('('+$(collapseid).find(".filter_city").length+')');
        $($(collapseid).find(".filter_city")).each(function () {
            city.push($(this).attr('data'));
            //$(".list_selected_login_city").append('<span class="badge badge-outline-primary mb-1 remove_login_select_city" data="'+$(this).attr('data')+'">'+$(this).attr('data')+'<i class="mdi mdi-close ml-1"></i></span>');
            $(".list_selected_login_city").append('<li class="badge bg-primary rounded-0 BtnAddList remove_login_select_city" data="'+$(this).attr('data')+'">'+$(this).attr('data')+'<i class="fa-solid fa-xmark"></i></li>');
            if($(".cityid[data='"+$(this).attr('data')+"']").length == 0){  
                  $('.city_list').append('<div class="form-check col-md-6 searchkeyword_tr">'+
                        '<input class="form-check-input cityid" type="checkbox" value="'+$(this).attr('data')+'" id="sFilters_city_'+$(this).attr('data')+'" name="Filters[city][]" data="'+$(this).attr('data')+'" checked>'+
                        '<label class="form-check-label" for="sFilters_city_'+$(this).attr('data')+'">'+$(this).attr('data')+'</label>'+
                    '</div>');
              }
            $(".cityid[data='"+$(this).attr('data')+"']").prop( "checked", true);
        });
        $("input[name='input_s_city']").val(city.join(","));
    }else{
        $('.city_count').html('');
        $(".list_selected_login_city").html('');
        $("input[name='input_s_city']").val('');
    }
    
    if($(collapseid).find(".filter_tender_amount").length > 0){
         var datamin = $(collapseid).find(".filter_tender_amount").attr('datamin');
         var datamax = $(collapseid).find(".filter_tender_amount").attr('datamax');
     
        $("#txtminprice").val(datamin);
        $("#txtmaxprice").val(datamax);
    }else{
        $("#txtminprice,#txtmaxprice").val('');
    }
    
    if($(collapseid).find(".filter_not_estimate").length > 0){
        $(".chk_estimate").prop( "checked", true);
    }else{
        $(".chk_estimate").prop( "checked", false);
    }
    
    if($(collapseid).find(".filter_rkeyword").length > 0){
        var rkeywords = new Array();
        $($(collapseid).find(".filter_rkeyword")).each(function () {
            rkeywords.push($(this).attr('data'));
        });
        $("#Filters_keyword2").val(rkeywords.join(","));
    }else{
        $("#Filters_keyword2").val('');
    }
    $("#Filters_ntid").val('');
    $("#relevance").prop("checked", true);
    
    offset = 1;
    busy == false;
    $("#lev1").html('');
    getFilter2(offset);
    //$(".dropdown-toggle").dropdown('toggle');
    $(".dropdown-menu,.dropdown-toggle").removeClass("show");
    $(".backdrop").removeClass("active");
 });
 
 $('body').on('click','.sector_apply,.all_filter_apply,.mobile_sector_apply',function(){
        $(".updatefiltermsg_popup").hide();
        var data = $(this).attr('data'); // mobile_sector_apply
        
        if(data == 'product' || data == "mobile_apply"){
            var product = new Array();
            var p1 = jQuery(".productid:checked").length;
            $('.list_selected_login_product').html('');
            if (p1 > 0) {
                $('.list_selected_login_product').html('');
                $('.chk_selected_login_product').show();
                jQuery(".productid:checked").each(function () {
                    product.push($(this).val());
                    $('.list_selected_login_product').append('<li class="badge bg-primary rounded-0 BtnAddList remove_login_select_product" data="'+$(this).val()+'">'+$(this).attr("data")+'<i class="fa-solid fa-xmark"></i></li>');
                });
                $("input[name='input_s_product']").val(product.join(","));
            }else{
                $("input[name='input_s_product']").val('');
                $('.chk_selected_login_product').hide();
            }
            //exe orgnazation
            var eproduct = new Array();
            var nep = jQuery(".remove_login_select_exe_product").length;
            if (nep > 0) {
                $('.chk_selected_login_exe_product').show();
                jQuery(".remove_login_select_exe_product").each(function () {
                    eproduct.push($(this).attr('data'));
                });
                $("input[name='input_s_eproduct']").val(eproduct.join(","));
            }else{
                $("input[name='input_s_eproduct']").val('');
                $('.chk_selected_login_exe_product').hide();
            }
        }
        if(data == 'category' || data == 'mobile_apply'){
            var category = new Array();
            var c1 = jQuery(".categoryid:checked").length;
            $('.list_selected_login_category').html('');
            if (c1 > 0) {
                $('.list_selected_login_category').html('');
                $('.chk_selected_login_category').show();
                jQuery(".categoryid:checked").each(function () {
                    category.push($(this).val());
                    $('.list_selected_login_category').append('<li class="badge bg-primary rounded-0 BtnAddList remove_login_select_category" data="'+$(this).val()+'">'+$(this).attr("data")+'<i class="fa-solid fa-xmark"></i></li>');
                });
                $("input[name='input_s_category']").val(category.join(","));
            }else{
                $("input[name='input_s_category']").val('');
                $('.chk_selected_login_category').hide();
            }
            //exe orgnazation
            var ecategory = new Array();
            var nep = jQuery(".remove_login_select_exe_category").length;
            if (nep > 0) {
                $('.chk_selected_login_exe_category').show();
                jQuery(".remove_login_select_exe_category").each(function () {
                    ecategory.push($(this).attr('data'));
                });
                $("input[name='input_s_ecategory']").val(ecategory.join(","));
            }else{
                $("input[name='input_s_ecategory']").val('');
                $('.chk_selected_login_exe_category').hide();
            }
        }
        if(data == "subcategory" || data == 'mobile_apply'){
            var subcategory = new Array();
            var s1 = $(".subcategoryid:checked").length;
            if (s1 > 0) {
                $('.subcategory_count').html('('+s1+')');
                $('.list_selected_login_subcategory').html('');
                $('.chk_selected_login_subcategory').show();
                if($('.remove_login_select_exe_subcategory').length > 0){
                    $('.exe_subcategory_count').text('('+$('.remove_login_select_exe_subcategory').length+')');
                }else{
                    $('.exe_subcategory_count').text('');
                }
                
                $(".subcategoryid:checked").each(function () {
                    subcategory.push($(this).val()); 
                    $('.list_selected_login_subcategory').append('<li class="badge bg-primary rounded-0 BtnAddList remove_login_select_subcategory" data="'+$(this).val()+'">'+$(this).attr("data")+' <i class="fa-solid fa-xmark"></i></li>');
                });
                
                $("input[name='input_s_subcategory']").val(subcategory.join(","));
            }else{
                $('.subcategory_count').html('');
                $('.list_selected_login_subcategory').html('');
                $("input[name='input_s_subcategory']").val('');
                $('.chk_selected_login_subcategory').hide();
            }
            
            var esubcategory = new Array();
            var nep = jQuery(".remove_login_select_exe_subcategory").length;
            if (nep > 0) {
                $('.chk_selected_login_exe_subcategory').show();
                jQuery(".remove_login_select_exe_subcategory").each(function () {
                    esubcategory.push($(this).attr('data'));
                });
                $("input[name='input_s_esubcategory']").val(esubcategory.join(","));
            }else{
                $("input[name='input_s_esubcategory']").val('');
                $('.chk_selected_login_exe_subcategory').hide();
            }
        }
        if(data == "keyword" || data == 'mobile_apply'){
            var keyword = new Array();
            var s1 = $(".keywordid:checked").length;
            
            if (s1 > 0) {
                $('.list_selected_login_keyword').html('');
                $('.keyword_count').text('('+s1+')');
                $('.chk_selected_login_keyword').show();
                $(".keywordid:checked").each(function () {
                    keyword.push($(this).val()); 
                        $('.list_selected_login_keyword').append('<li class="badge bg-primary rounded-0 BtnAddList remove_login_select_keyword" data="'+$.trim($(this).val())+'">'+$(this).attr("data")+' <i class="fa-solid fa-xmark"></i></li> ');
                });
                
                $("input[name='input_s_keyword']").val(keyword.join(","));
            }else{
                $("input[name='input_s_keyword']").val('');
                $('.keyword_count').text("");
                $('.list_selected_login_keyword').html('');
                $('.chk_selected_login_keyword').hide();
            }
            
            //exe keywords
            var ekeywords = new Array();
            var nek = jQuery(".remove_login_select_ekeyword").length;
            if (s1 > 0) {
                $('.chk_selected_login_exe_keyword').show();
                jQuery(".remove_login_select_ekeyword").each(function () {
                    ekeywords.push($(this).attr('data'));
                });
                $("input[name='input_s_ekeyword']").val(ekeywords.join(","));
            }else{
                $("input[name='input_s_ekeyword']").val('');
                $('.chk_selected_login_exe_keyword').hide();
            }
        }
        if(data == "Dipartment" || data == 'mobile_apply'){
            var dipartment = new Array();
            var s1 = $(".agencyid:checked").length;
            if (s1 > 0) {
                $('.list-selected-dipartment').html('');
                $('.dipartment_count').text('('+s1+')');
                $('.chk_selected_login_org').show();
                $(".agencyid:checked").each(function () {
                    dipartment.push($(this).val()); 
                    $('.list-selected-dipartment').append('<li class="badge bg-primary rounded-0 BtnAddList remove_login_select_dipartment" data="'+$(this).val()+'">'+$(this).attr("data")+' <i class="fa-solid fa-xmark"></i></li> ');
                });
                
                $("input[name='input_s_org']").val(dipartment.join(","));
            }else{
                $("input[name='input_s_org']").val('');
                $('.dipartment_count').text('');
                $('.list-selected-dipartment').html('');
                $('.chk_selected_login_org').hide();
            }
            
            if($('.remove_login_select_exe_dipartment').length > 0){
                    $('.exe_dipartment_count').text('('+$('.remove_login_select_exe_dipartment').length+')');
            }else{
                $('.exe_dipartment_count').text('');
            }
            
            //exe orgnazation
            var eorganization = new Array();
            var neo = jQuery(".remove_login_select_exe_dipartment").length;
            if (neo > 0) {
                $('.chk_selected_login_exe_org').show();
                jQuery(".remove_login_select_exe_dipartment").each(function () {
                    eorganization.push($(this).attr('data'));
                });
                $("input[name='input_s_eorg']").val(eorganization.join(","));
            }else{
                $("input[name='input_s_eorg']").val('');
                $('.chk_selected_login_exe_org').hide();
            }
        }
        if(data == "state"){
            var state = new Array();
            var s1 = $(".stateid:checked").length;
            if (s1 > 0) {
                $('.state_count').text('('+s1+')');
                $('.list_selected_login_state').html('');
                $('.chk_selected_login_state').show();
                $(".stateid:checked").each(function () {
                    state.push($(this).val()); 
                    $('.list_selected_login_state').append('<li class="badge bg-primary rounded-0 BtnAddList remove_login_select_state" data="'+$(this).val()+'">'+$(this).attr("data")+' <i class="fa-solid fa-xmark"></i></li> ');
                });
                
                $("input[name='input_s_state']").val(state.join(","));
                
                $('.list_selected_login_city').html('');
                $('.city_count').text("");
                $(".cityid").prop('checked', false);
                $("input[name='input_s_city']").val("");
                
            }else{
                $("input[name='input_s_state']").val('');
                $('.state_count').text("");
                $('.list_selected_login_state').html('');
                $('.chk_selected_login_state').hide();
            }
        }
        if(data == 'mobile_apply'){
            var state = new Array();
            var s1 = $(".stateid:checked").length;
            if (s1 > 0) {
                $('.state_count').text('('+s1+')');
                $('.list_selected_login_state').html('');
                $('.chk_selected_login_state').show();
                $(".stateid:checked").each(function () {
                    state.push($(this).val()); 
                    $('.list_selected_login_state').append('<li class="badge bg-primary rounded-0 BtnAddList remove_login_select_state" data="'+$(this).val()+'">'+$(this).attr("data")+' <i class="fa-solid fa-xmark"></i></li> ');
                });
                
                $("input[name='input_s_state']").val(state.join(","));
                
            }else{
                $("input[name='input_s_state']").val('');
                $('.state_count').text("");
                $('.list_selected_login_state').html('');
                $('.chk_selected_login_state').hide();
            }
        }
        if(data == "city" || data == 'mobile_apply'){
            var city = new Array();
            var s1 = $(".cityid:checked").length;
            if (s1 > 0) {
                $('.list_selected_login_city').html('');
                $('.city_count').text('('+s1+')');
                $('.chk_selected_login_city').show();
                $(".cityid:checked").each(function () {
                    city.push($(this).attr('data')); 
                    $('.list_selected_login_city').append('<li class="badge bg-primary rounded-0 BtnAddList remove_login_select_city" data="'+$(this).attr("data")+'">'+$(this).attr("data")+' <i class="fa-solid fa-xmark"></i></li> ');
                });
                
                $("input[name='input_s_city']").val(city.join(","));
            }else{
                $("input[name='input_s_city']").val('');
                $('.city_count').text("");
                $('.list_selected_login_city').html('');
                $('.chk_selected_login_city').hide();
            }
        }
        if(data == "tenderamount"){
            $("input[name='input_min_amount']").val($('#txtminprice').val());
            $("input[name='input_max_amount']").val($('#txtmaxprice').val());
            if($(".chk_estimate").prop( "checked")){
                $("input[name='input_estimate_values']").val(1);    
            }else{
                $("input[name='input_estimate_values']").val(0);
            }
        }
        if(data == "morefilter"){
            $("input[name='input_within_search']").val($('#Filters_keyword2').val());
            $("input[name='input_publish_date']").val($('#Filters_dt').val());
            $("input[name='input_ntid_search']").val($('#Filters_ntid').val());
            if($('#isexactkeyword_values').prop('checked')){
                $("input[name='input_isexactkeyword_values']").val(1);    
            }else{
                $("input[name='input_isexactkeyword_values']").val(0);                
            }
        }
        if(data == "mobile_apply"){ // mobile menu
        
            $("input[name='input_min_amount']").val($('#mobile_txtminprice').val());
            $("input[name='input_max_amount']").val($('#mobile_txtmaxprice').val());
            if($("#mobile_estimate_values").prop( "checked")){
                $("input[name='input_estimate_values']").val(1);    
            }else{
                $("input[name='input_estimate_values']").val(0);
            }
            
            $("input[name='input_within_search']").val($('#mobile_Filters_keyword2').val());
            $("input[name='input_publish_date']").val($('#mobile_Filters_dt').val());
            $("input[name='input_ntid_search']").val($('#mobile_Filters_ntid').val());
            
            if($('#mobile_isexactkeyword_values').prop('checked')){
                $("input[name='input_isexactkeyword_values']").val(1);    
            }else{
                $("input[name='input_isexactkeyword_values']").val(0);                
            }
        }else{
            
        }
         
        offset = 1;
        busy == false;
        $("#lev1").html('');
        getFilter2(offset);
        //$(".dropdown-toggle").dropdown('toggle');
        $(".dropdown-menu,.dropdown-toggle").removeClass("show");
        $(".backdrop").removeClass("active");
        
        //mobile menu hide
        $(".FIlterMobileWrap").removeClass("Active");
        $("nav.navbar.navbar-expand-lg").show();
        $("body").removeClass("FilterActive");
        
 });
 
 $('body').on('click', '.remove_login_select_state,.remove_login_select_dipartment,.remove_login_select_product,.remove_login_select_category,.remove_login_select_subcategory,.remove_login_select_city,.remove_login_select_keyword', function () {
        
        var cls = $(this).attr('class');
        var data = $(this).attr('data');
        if(cls == 'badge bg-primary rounded-0 BtnAddList remove_login_select_state'){
            $( 'input.stateid[value="'+data+'"]' ).prop( "checked", false );
        }else if(cls == 'badge bg-primary rounded-0 BtnAddList remove_login_select_org'){
            $( 'input.agencyid[value="'+data+'"]' ).prop( "checked", false );
        }else if(cls == 'badge bg-primary rounded-0 BtnAddList remove_login_select_product'){
            $( 'input.productid[value="'+data+'"]' ).prop( "checked", false );
        }else if(cls == 'badge bg-primary rounded-0 BtnAddList remove_login_select_exe_product'){
            $( 'input.eproductid[value="'+data+'"]' ).prop( "checked", false );
        }else if(cls == 'badge bg-primary rounded-0 BtnAddList remove_login_select_category'){
            $( 'input.categoryid[value="'+data+'"]' ).prop( "checked", false );
        }else if(cls == 'badge bg-primary rounded-0 BtnAddList remove_login_select_subcategory'){
            $( 'input.subcategoryid[value="'+data+'"]' ).prop( "checked", false );
        }else if(cls == 'badge bg-primary rounded-0 BtnAddList remove_login_select_city'){
            $( 'input.cityid[data="'+data+'"]' ).prop( "checked", false );
        }else if(cls == 'badge bg-primary rounded-0 BtnAddList remove_login_select_keyword'){
            $( 'input.keywordid[value="'+data+'"]' ).prop( "checked", false );
        }else if(cls == 'badge bg-primary rounded-0 BtnAddList remove_login_select_dipartment'){
            $( 'input.agencyid[value="'+data+'"]' ).prop( "checked", false );
        }
        $(this).remove();
 });
 
 $('body').on('click', '.btn_clear_selected_item', function () {
    var data = $(this).attr('data');
    $(".list_selected_login_"+data).html('');
    $(".chk_selected_login_"+data).hide();
    if(data == "subcategory"){
        $("input[name='input_s_subcategory']").val('');
        $("input[name='input_s_esubcategory']").val('');
        $(".list_selected_login_exe_subcategory").html('');
        $(".subcategoryid").prop( "checked", false );
        //var s1 = $(".subcategoryid:checked").length;
        $('.subcategory_count').text("");
        $('.exe_subcategory_count').text("");
    }else if(data == "keyword"){
        $("input[name='input_s_subcategory']").val('');
        $("input[name='input_s_esubcategory']").val('');
        $(".list_selected_login_exe_subcategory").html('');
        $(".keywordid").prop( "checked", false );
        //var s1 = $(".keywordid:checked").length;
        $('.keyword_count').text('');
        $('.excluding_keyword_count').text('');
    }else if(data == "Dipartment"){
        $(".agencyid").prop( "checked", false );
        $('.dipartment_count').text('');
        $('.list-selected-dipartment').html('');
        $('.list-selected-exe-dipartment').html('');
        $('.exe_dipartment_count').text('');
        
        $("input[name='input_s_org']").val('');
        $("input[name='input_s_eorg']").val('');
    }else if(data == "state"){
        $("input[name='input_s_state']").val('');
        $(".list_selected_login_city,.list_login_city_list").html('');
        $(".cityid").prop( "checked", false);
        $(".stateid").prop( "checked", false);
        $('.state_count').text("");
        $('.city_count').text("");
    }else if(data == "city"){
        $("input[name='input_s_city']").val('');
        $(".cityid").prop( "checked", false);
        $('.city_count').text("");
        $(".list_selected_login_city").html('');
    }else if(data == "tenderamount"){
        $("input[name='min_amount']").val('');
        $("input[name='max_amount']").val('');
        $(".chk_estimate").prop( "checked", false);
        $("input[name='input_min_amount']").val('');
        $("input[name='input_max_amount']").val('');
        $("input[name='input_estimate_values']").val(0);
    }else if(data == "morefilter"){
        $("#Filters_keyword2,.clearallinput").val('');
        $('#isexactkeyword_values').prop( "checked", false);
        $("input[name='input_min_amount']").val('');
        $("input[name='input_max_amount']").val('');
        
        $("input[name='input_within_search']").val('');
        $("input[name='input_publish_date']").val('');
        $("input[name='input_ntid_search']").val('');
        $("input[name='input_isexactkeyword_values']").val(0);
    }else if(data == "clearallfilter"){
        $("#Filters_keyword2,.clearallinput").val('');
        if (confirm('Are you sure want to clear all filters ?')) {
            
            $("input[name='input_s_keyword']").val('');
            $("input[name='input_s_ekeyword']").val('');
            $("input[name='input_s_state']").val('');
            $("input[name='input_s_city']").val('');
            $("input[name='input_s_org']").val('');
            $("input[name='input_s_eorg']").val('');
            $("input[name='input_s_product']").val('');
            $("input[name='input_s_eproduct']").val('');
            $("input[name='input_s_category']").val('');
            $("input[name='input_s_ecategory']").val('');
            $("input[name='input_s_subcategory']").val('');
            $("input[name='input_s_esubcategory']").val('');
            
            $("input[name='input_min_amount']").val('');
            $("input[name='input_max_amount']").val('');
            $("input[name='input_estimate_values']").val('');
            $("input[name='input_within_search']").val('');
            $("input[name='input_publish_date']").val('');
            $("input[name='input_ntid_search']").val('');
            $("input[name='input_isexactkeyword_values']").val(0);
        
            $(".list_selected_login_exe_product").html('');
            $(".list_selected_login_exe_category").html('');
            $(".list_selected_login_exe_subcategory").html('');
            $(".list-selected-exe-dipartment").html('');
            
            
            $('.list-selected-dipartment').html('');
            $('.list_selected_login_city').html('');
            
            $('.counts').html("");
            $(".list_login_city_list,.list_selected_login_product,.list_selected_login_category,.list_selected_login_subcategory,.list_selected_login_keyword,.list-selected-dipartment,.list_selected_login_state,.chk_selected_login_city").html(''); 
            $(".agencyid,.stateid,.cityid,.keywordid,.productid,.categoryid,.subcategoryid").prop( "checked", false );
            
            $("#txtminprice").val('');
            $("#txtmaxprice").val('');
            $(".chk_estimate").prop( "checked", false );
            $("#isexactkeyword_values").prop( "checked", false );
            $("#relevance").prop( "checked", true );
            $("#Filters_keyword2,.clearallinput").val('');
            
            //mobile clear
            $("#mobile_txtminprice").val('');
            $("#mobile_txtmaxprice").val('');
            $("#mobile_estimate_values,#mobile_isexactkeyword_values").prop( "checked", false );
            $("#mobile_Filters_keyword2,#mobile_Filters_dt,#mobile_Filters_ntid").val('');
            
             offset = 1;
             busy == false;
             $("#lev1").html('');
             getFilter2(offset);
        }
    }else{
        $("."+data+"id").prop( "checked", false );
    }
});

$('body').on('change', '.stateid', function () {
        $(".cityid").prop('checked', false);
        setTimeout(function () {
            load_json_city();
        }, 1000);
});
///
$('body').on('click', '.BtnSearch > .tablinksfilter', function () {
    var prevdata = $(".BtnSearch > .tablinksfilter.active").attr('data');
    $(".BtnSearch > .tablinksfilter").removeClass('active');
    $(".ArchToggle > .navbar-nav > li > .dropdown-menu > li > a").removeClass('active');
    $(this).addClass('active');
    var data = $(".BtnSearch > .tablinksfilter.active").attr('data');
    
    if(data != prevdata){
     offset = 1;
     busy == false;
     $("#lev1").html('');
     getFilter2(offset);
    }
});
$('.sortfilter > .tablinksfilter').on('click', function () {
    var prevdata = $(".sortfilter > .tablinksfilter.active").attr('data');
    $(".sortfilter > .tablinksfilter").removeClass('active');
    $(this).addClass('active');
    var data = $(this).attr('data');
     if(data != prevdata){
         offset = 1;
         busy == false;
         $("#lev1").html('');
         getFilter2(offset);
     }
});
function tabloadcategory(){
    if($('.list_login_subcategory_list').find('.searchkeyword_tr').length < 10){
        //var category_url = "{{ asset('products.json') }}";
        var category_url = "../../products.json";
        if(subcategory_list.length == 0) {
        $.getJSON(category_url, function(data) { $.each(data,function(i,item){ subcategory_list.push({subcategoryid:item.subcategoryid,subcategoryname:item.subcategoryname}); }); });
            setTimeout(function () {
                //if(subcategory_list.length > 0) {
                    get_subcategory_data();                
               // }
            },1000);
        }
    }
}
function tabloadkeyword(){
    if($('.list_login_keyword_list').find('.searchkeyword_tr').length < 10){    
        //$('.list_login_keyword_list').empty();
        //var url = "{{ asset('keywords.json') }}";
        var url = "../../keywords.json";
        $.getJSON(url, function(data) { 
            //var filter_list = data.filter( element => element.division =="Keyword");
            $.each(data,function(i,item){ keyword_list.push({id:item.id,name:item.name}); });
            setTimeout(function () {
                //if(keyword_list.length > 0) { keyword_offset,keyword_limit
                    get_keyword_data();                
                //}
            },1000);
        });
    }
}
function tabloaddepartment(){
    if($('.dipartment-list').find('.form-check').length < 10){
        //var url = "{{ asset('agency.json') }}";
        var url = "../../agency.json";
        $.getJSON(url, function(data) { $.each(data,function(i,item){ dipartment_list.push({id:item.id,text:item.text}); }); });
        setTimeout(function () {
            //if(dipartment_list.length > 0) {
                get_dipartment_data();                
            //}
        },1000);
    }
}
function tabloadstate(){
    //$('.city_list').empty();
    //if($('.state_list').find('.searchkeyword_tr').length == 0){
        //var state_url = "{{ asset('state.json') }}";
        if(state_list.length == 0) {
        var state_url = "../../state.json";
        $.getJSON(state_url, function(data) { $.each(data,function(i,item){ state_list.push({id:item.id,name:item.name}); }); });
        setTimeout(function () {
            if(state_list.length > 0) {
                $.each(state_list,function(i,item){
                    if($(".stateid[data='"+item.name+"']").length == 0){  
                        $('.state_list').append('<div class="form-check col-md-6 searchkeyword_tr">'+
                            '<input class="form-check-input stateid" type="checkbox" value='+item.id+' id="sFilters_state_'+item.id+'" name="Filters[state][]" data="'+item.name+'">'+
                            '<label class="form-check-label" for="sFilters_state_'+item.id+'">'+item.name+'</label>'+
                        '</div>');
                    }
                });        
            }
        },1000);
        
        }
    //}
}
function tabloadcity(){
    //var city_url = "{{ asset('city.json')}}";
    var city_url = "../../city.json";
    if(city_list.length == 0){
        $.getJSON(city_url, function(data) { $.each(data,function(i,item){ city_list.push({id:item.id,stateid:item.stateid,text:item.name}); }); });
    }
    if(loadcity == false){
        setTimeout(function () {
        load_json_city();
        loadcity = true;
        },1000);
    }
}
$(".FilterOpenMobile").click(function(){
        
   var sucategoryhtml = $(".subcategoryfiltermain").html();
   var is_sucategory = $(".subcategoryfiltermain").attr('data');
   if(is_sucategory == "false"){
        $(".mobile_subcategoryfiltermain").html(sucategoryhtml);
        $(".subcategoryfiltermain").html('');
        $(".subcategoryfiltermain").attr('data',true);
   } 
   var keywordhtml = $(".keywordfiltermain").html();
   var is_keyword = $(".keywordfiltermain").attr('data');
   if(is_keyword == "false"){
        $(".mobile_keywordfiltermain").html(keywordhtml);
        $(".keywordfiltermain").html('');
        $(".keywordfiltermain").attr('data',true);
   }
   var departmenthtml = $(".departmentfiltermain").html();
   var is_department = $(".departmentfiltermain").attr('data');
   if(is_department == "false"){
        $(".mobile_departmentfiltermain").html(departmenthtml);
        $(".departmentfiltermain").html('');
        $(".departmentfiltermain").attr('data',true);
   }
   var statehtml = $(".statefiltermain").html();
   var is_state = $(".statefiltermain").attr('data');
   if(is_state == "false"){
        $(".mobile_statefiltermain").html(statehtml);
        $(".statefiltermain").html('');
        $(".statefiltermain").attr('data',true);
   }
   var cityhtml = $(".cityfiltermain").html();
   var is_city = $(".cityfiltermain").attr('data');
   if(is_city == "false"){
        $(".mobile_cityfiltermain").html(cityhtml);
        $(".cityfiltermain").html('');
        $(".cityfiltermain").attr('data',true);
   }
   
    tabloadcategory();
    $(".BootmFooterBox").hide();
    $(".FIlterMobileWrap").addClass("Active");
    $("nav.navbar.navbar-expand-lg").hide();
    $("body").addClass("FilterActive");
});

function EventTabn(evt, TabName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("eventcontentfilter");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("eventlinksfiltern");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(TabName).style.display = "block";
  evt.currentTarget.className += " active";
  
  //GAUTISH
  if(TabName == "CategoryF"){
    tabloadcategory();
  }else if(TabName == "KeywordF"){
    tabloadkeyword();
  }else if(TabName == "DepartmentF"){
    tabloaddepartment();
  }else if(TabName == "StateF"){
     tabloadstate(); 
  }else if(TabName == "CityF"){
    tabloadcity();
  }else{
      
  }
}
//item not selected than hide according
function checkselecteditems(){
    if(jQuery(".remove_login_select_product").length > 0){
        $('.chk_selected_login_product').show();
    }else{
        $('.chk_selected_login_product').hide();
    }
    if(jQuery(".remove_login_select_exe_product").length > 0){
        $('.chk_selected_login_exe_product').show();
    }else{
        $('.chk_selected_login_exe_product').hide();
    }
    if(jQuery(".remove_login_select_category").length > 0){
        $('.chk_selected_login_category').show();
    }else{
        $('.chk_selected_login_category').hide();
    }
    if(jQuery(".remove_login_select_exe_category").length > 0){
        $('.chk_selected_login_exe_category').show();
    }else{
        $('.chk_selected_login_exe_category').hide();
    }
    if(jQuery(".remove_login_select_subcategory").length > 0){
        $('.chk_selected_login_subcategory').show();
    }else{
        $('.chk_selected_login_subcategory').hide();
    }
    if(jQuery(".remove_login_select_exe_subcategory").length > 0){
        $('.chk_selected_login_exe_subcategory').show();
    }else{
        $('.chk_selected_login_exe_subcategory').hide();
    }
    if(jQuery(".remove_login_select_keyword").length > 0){
        $('.chk_selected_login_keyword').show();
    }else{
        $('.chk_selected_login_keyword').hide();
    }
    if(jQuery(".remove_login_select_ekeyword").length > 0){
        $('.chk_selected_login_exe_keyword').show();
    }else{
        $('.chk_selected_login_exe_keyword').hide();
    }
    if(jQuery(".remove_login_select_dipartment").length > 0){
        $('.chk_selected_login_org').show();
    }else{
        $('.chk_selected_login_org').hide();
    }
    if(jQuery(".remove_login_select_exe_dipartment").length > 0){
        $('.chk_selected_login_exe_org').show();
    }else{
        $('.chk_selected_login_exe_org').hide();
    }
    if(jQuery(".remove_login_select_state").length > 0){
        $('.chk_selected_login_state').show();
    }else{
        $('.chk_selected_login_state').hide();
    }
    if(jQuery(".remove_login_select_city").length > 0){
        $('.chk_selected_login_city').show();
    }else{
        $('.chk_selected_login_city').hide();
    }
}
//adding filter items 
function selected_adding_new_items(){
     /*get selected filters start */
        //var productval = $("input[name='input_s_product']").val();
        //var product = productval.split(','); 
        // <li class="ValueListItem">Security Guards <span>Keyword</span> <i class="fa-solid fa-xmark"></i></li>
        $("#filter_new_name").val('');
        var adding_filter = '';
        var adding_filter_count = 0;
        jQuery($(".remove_login_select_product")).each(function (index, value) {
            var spid = $(this).attr('data');
            var sptxt = $(this).text();
            //console.log(sptxt);
            //adding_filter += '<h6 class="badge badge-outline-primary mb-1 remove_adding_product_item remove_adding_item" data="'+spid+'">'+sptxt+'<i class="mdi mdi-close ml-1"></i><p class="text-left text-danger mb-0"><small>Product</small></p></h6>';
            adding_filter +='<li class="ValueListItem remove_adding_product_item remove_adding_item" data="'+spid+'">'+sptxt+' <span>Industry</span> <i class="fa-solid fa-xmark"></i></li>';
            adding_filter_count++;
        });
        jQuery($(".remove_login_select_exe_product")).each(function (index, value) {
            var sepid = $(this).attr('data');
            var septxt = $(this).text();
            //console.log(septxt);
            adding_filter +='<li class="ValueListItem remove_adding_eproduct_item remove_adding_item" data="'+sepid+'">'+septxt+' <span>Excluding Industry</span> <i class="fa-solid fa-xmark"></i></li>'; 
            adding_filter_count++;
            
        });
        //var categoryval = $("input[name='input_s_category']").val();
        //var category = categoryval.split(',');
        jQuery($(".remove_login_select_category")).each(function (index, value) {
            var scid = $(this).attr('data');
            var sctxt = $(this).text();
            //console.log(sctxt);
            adding_filter +='<li class="ValueListItem remove_adding_category_item remove_adding_item" data="'+scid+'">'+sctxt+' <span>SubIndustry</span> <i class="fa-solid fa-xmark"></i></li>'; 
            adding_filter_count++;
        }); 
        jQuery($(".remove_login_select_exe_category")).each(function (index, value) {
            var secid = $(this).attr('data');
            var sectxt = $(this).text();
            //console.log(sectxt);
            adding_filter +='<li class="ValueListItem remove_adding_ecategory_item remove_adding_item" data="'+secid+'">'+sectxt+' <span>Excluding SubIndustry</span> <i class="fa-solid fa-xmark"></i></li>'; 
            adding_filter_count++;
        }); 
         
        jQuery($(".remove_login_select_subcategory")).each(function (index, value) {
            var sscid = $(this).attr('data');
            var ssctxt = $(this).text();
            //console.log(ssctxt);
            adding_filter +='<li class="ValueListItem remove_adding_subcategory_item remove_adding_item" data="'+sscid+'">'+ssctxt+' <span>Subcategory</span> <i class="fa-solid fa-xmark"></i></li>'; 
            adding_filter_count++;
        }); 
        jQuery($(".remove_login_select_exe_subcategory")).each(function (index, value) {
            var sescid = $(this).attr('data');
            var sesctxt = $(this).text();
            //console.log(sesctxt);
            adding_filter +='<li class="ValueListItem remove_adding_esubcategory_item remove_adding_item" data="'+sescid+'">'+sesctxt+' <span>Excluding Subcategory</span> <i class="fa-solid fa-xmark"></i></li>'; 
            adding_filter_count++;
        }); 
        jQuery($(".remove_login_select_keyword")).each(function (index, value) {
            var skeyid = $(this).attr('data');
            var skeytxt = $(this).text();
            //console.log(skeytxt);
            adding_filter +='<li class="ValueListItem remove_adding_keyword_item remove_adding_item" data="'+skeyid+'">'+skeytxt+' <span>Keyword</span> <i class="fa-solid fa-xmark"></i></li>'; 
            adding_filter_count++;
        }); 
        jQuery($(".remove_login_select_exe_keyword")).each(function (index, value) {
            var sekeyid = $(this).attr('data');
            var sekeytxt = $(this).text();
            //console.log(sekeytxt);
            adding_filter +='<li class="ValueListItem remove_adding_ekeyword_item remove_adding_item" data="'+sekeyid+'">'+sekeytxt+' <span>Excluding Keyword</span> <i class="fa-solid fa-xmark"></i></li>'; 
            adding_filter_count++;
        });
        jQuery($(".remove_login_select_dipartment")).each(function (index, value) {
            var sorgid = $(this).attr('data');
            var sorgtxt = $(this).text();
            //console.log(sorgtxt);
            adding_filter +='<li class="ValueListItem remove_adding_org_item remove_adding_item" data="'+sorgid+'">'+sorgtxt+' <span>Department</span> <i class="fa-solid fa-xmark"></i></li>'; 
            adding_filter_count++;
        }); 
        jQuery($(".remove_login_select_exe_dipartment")).each(function (index, value) {
            var seorgid = $(this).attr('data');
            var seorgtxt = $(this).text();
            //console.log(seorgtxt);
            adding_filter +='<li class="ValueListItem remove_adding_eorg_item remove_adding_item" data="'+seorgid+'">'+seorgtxt+' <span>Excluding Department</span> <i class="fa-solid fa-xmark"></i></li>'; 
            adding_filter_count++;
        }); 
        jQuery($(".remove_login_select_state")).each(function (index, value) {
            var sstateid = $(this).attr('data');
            var sstatetxt = $(this).text();
            //console.log(sstatetxt);
            adding_filter +='<li class="ValueListItem remove_adding_state_item remove_adding_item" data="'+sstateid+'">'+sstatetxt+' <span>State</span> <i class="fa-solid fa-xmark"></i></li>'; 
            adding_filter_count++;
        }); 
        jQuery($(".remove_login_select_city")).each(function (index, value) {
            var scityid = $(this).attr('data');
            var scitytxt = $(this).text();
            //console.log(scitytxt);
            adding_filter +='<li class="ValueListItem remove_adding_city_item remove_adding_item" data="'+scityid+'">'+scitytxt+' <span>City</span> <i class="fa-solid fa-xmark"></i></li>'; 
            adding_filter_count++;
        }); 
         
        //var minvalue = $("#txtminprice").val();
        //var maxvalue =$("#txtmaxprice").val();
        var minvalue = $("input[name='input_min_amount']").val();
        var maxvalue = $("input[name='input_max_amount']").val();
        //var is_estimate = $(".chk_estimate").prop( "checked", true);
        //var refine_keyword = $("#Filters_keyword2").val();
        
        var refine_keyword = $("input[name='input_within_search']").val();
        
        
        var ref_arr = Array();
        if(refine_keyword != ''){
            ref_arr = refine_keyword.split(',');
            jQuery(ref_arr).each(function (index, value) {
                var srkeyid = value;
                var srkeytxt = value;
                //console.log(skeytxt);
                adding_filter +='<li class="ValueListItem remove_adding_rkeyword_item remove_adding_item" data="'+srkeyid+'">'+srkeytxt+' <span>Refine Keyword</span> <i class="fa-solid fa-xmark"></i></li>'; 
                adding_filter_count++;
            });
        }
        
        if(minvalue != '' || maxvalue != ''){
            if(minvalue != '' && maxvalue != ''){
                adding_filter +='<li class="ValueListItem remove_adding_amount_item remove_adding_item" datamin="'+minvalue+'" datamax="'+maxvalue+'">'+minvalue+' to '+maxvalue+' <span>Amount</span> <i class="fa-solid fa-xmark"></i></li>'; 
               
                if($(".chk_estimate").is(":checked")){
                    adding_filter +='<li class="ValueListItem remove_adding_amount_item remove_adding_item" data="1">With not estimated <span>Amount</span> <i class="fa-solid fa-xmark"></i></li>'; 
                }
                adding_filter_count++;
            } else if(minvalue != '' && maxvalue == ''){
                adding_filter +='<li class="ValueListItem remove_adding_amount_item remove_adding_item" datamin="'+minvalue+'" datamax="'+maxvalue+'">More than '+minvalue+' <span>Amount</span> <i class="fa-solid fa-xmark"></i></li>'; 
                if($(".chk_estimate").is(":checked")){
                    adding_filter +='<li class="ValueListItem remove_adding_amount_item remove_adding_item" data="1">With not estimated <span>Amount</span> <i class="fa-solid fa-xmark"></i></li>'; 
                }
                adding_filter_count++;
            } else if(minvalue == '' && maxvalue != ''){
                adding_filter +='<li class="ValueListItem remove_adding_amount_item remove_adding_item" datamin="'+minvalue+'" datamax="'+maxvalue+'">Less than '+maxvalue+' <span>Amount</span> <i class="fa-solid fa-xmark"></i></li>'; 
                if($(".chk_estimate").is(":checked")){
                    adding_filter +='<li class="ValueListItem remove_adding_amount_item remove_adding_item" data="1">With not estimated <span>Amount</span> <i class="fa-solid fa-xmark"></i></li>'; 
                }
                adding_filter_count++;
            }
        }
        /*get selected filters amount,estimate,refine keyword end*/
         
        /*var html = $(".filter_main_wrap").html();
        $(".modal_filter_main_wrap").html(html);
        var did = $(".modal_filter_main_wrap").find('input[name="example1"]');
        $(".modal_filter_main_wrap").find("input[name='example1']").prop('checked', false);
        $.each(did, function(key, value){
            var cdid = $(this).attr('data');
            $(this).attr('id','customCheckm_'+cdid);
            $(".modal_filter_main_wrap").find('label[for="customCheck_'+cdid+'"]').attr('for','customCheckm_'+cdid);
        });
        $(".modal_filter_main_wrap").find('span').removeClass('remove_item');
        $(".modal_filter_main_wrap").find('span').find('i').remove();*/
        
        //var did = $(".modal_filter_main_wrap").find(".saved_filter_toggle_btn");
        //$(did).attr('data-parent','accordion1');
        $('.adding_new_filter_inner').html('');
        //$('.adding_new_filter_inner').html('<h5 class="card-title">Adding New Filters (<span class="filtercount">'+adding_filter_count+'</span>)</h5>');
        $('.Headingb').html('Adding New Filters (<span class="filtercount">'+adding_filter_count+'</span>)');
        $('.adding_new_filter_inner').append(adding_filter);
}
//load json
function load_json_city(){
    $('.city_list').html('');  
	var n = jQuery(".stateid:checked").length;
	var selectedState = new Array();
	
    if (n > 0) {
        $('.chk_selected_login_city').show();
		$(".stateid:checked").each(function () {
            selectedState.push($(this).val());
        });
          
        $.each(city_list, function(key, value){
			if(jQuery.inArray(value.stateid, selectedState) !== -1)			
			{
			    var ischecked = '';
    		    if($(".remove_login_select_city[data='"+value.text+"']").length > 0){
                   ischecked = 'checked';
                }    
              
              if($(".cityid[data='"+value.text+"']").length == 0){  
                  $('.city_list').append('<div class="form-check col-md-6 searchkeyword_tr">'+
                        '<input class="form-check-input cityid" type="checkbox" value="'+value.id+'" id="sFilters_city_'+value.id+'" name="Filters[city][]" data="'+value.text+'" '+ischecked+'>'+
                        '<label class="form-check-label" for="sFilters_city_'+value.id+'">'+value.text+'</label>'+
                    '</div>');
              }
			  //$('.city_list').append('<div class="col-md-6"><div class="form-check my-1"><label class="form-check-label"><input type="checkbox" name="Filters[city][]" class="form-check-input cityid" id="sFilters_city_'+value.id+'" data="'+value.name+'" value="'+value.id+'" '+ischecked+'>'+value.name+'<i class="input-helper"></i></label></div></div>');
			}
		});
	}else{
	    $('.chk_selected_login_city').hide();
		$('.city_list').html('');  
	}
} 
var countsubcat = 1;
var busy_subcategory = false;
function get_subcategory_data(){
    var searchField = $(".searchsubcategory").val().toLowerCase();
    var output = ''; 
        //console.log("ss "+subcategory_list.length);
        
    		if(searchField === ''){
    		    $.each(subcategory_list,function(i,item){
                    if (countsubcat > 16){ return false; }
                    var ischecked = '';
                    if($(".remove_login_select_subcategory[data='"+item.subcategoryid+"']").length > 0){
                      ischecked = 'checked';
                    } 
                    //if($(".remove_login_select_subcategory[data='"+item.subcategoryid+"']").length == 0){   
                    if($(".subcategoryid[data='"+item.subcategoryname+"']").length == 0){    
                       output +='<div class="form-check col-md-6 searchkeyword_tr"><input '+ischecked+' class="form-check-input subcategoryid" data-title="'+item.subcategoryname+'" '+ischecked+' type="checkbox" value="'+item.subcategoryid+'" id="sFilters_subcategory_'+item.subcategoryid+'" data="'+item.subcategoryname+'" name="Filters[subcategoryid][]" /><label class="form-check-label" for=sFilters_subcategory_'+item.subcategoryid+'>'+item.subcategoryname+'</label></div>';
                        countsubcat++;
                    }   
    		    });
    		}else{
    		    if(searchField.length >=2){
    		        $.each(subcategory_list,function(i,item){
                        if (countsubcat > 10){ return false; }
                        var ischecked = '';
                        if($(".remove_login_select_subcategory[data='"+item.subcategoryid+"']").length > 0){
                          ischecked = 'checked';
                        } 
            		    var regex = new RegExp(searchField, "i");
                        if (item.subcategoryname.search(regex) != -1) {
                            if($(".subcategoryid[data='"+item.subcategoryname+"']").length == 0){    
                               output +='<div class="form-check col-md-6 searchkeyword_tr"><input '+ischecked+' class="form-check-input subcategoryid" data-title="'+item.subcategoryname+'" '+ischecked+' type="checkbox" value="'+item.subcategoryid+'" id="sFilters_subcategory_'+item.subcategoryid+'" data="'+item.subcategoryname+'" name="Filters[subcategoryid][]" /><label class="form-check-label" for=sFilters_subcategory_'+item.subcategoryid+'>'+item.subcategoryname+'</label></div>';
                                countsubcat++;
                            }  
                        }
    		        });
    		    }
    		}
          //console.log("cc "+i);
        
          
    $('.list_login_subcategory_list').append(output);
	if(busy_subcategory){
        busy_subcategory = false;
    }
}
var countkeyword = 1;
var busy_keyword = false;
function get_keyword_data(){
    var searchField = $(".search_filter_text_keyword").val().toLowerCase();
    var output = ''; 
        //console.log("ss "+subcategory_list.length);
        if(searchField === ''){
        $.each(keyword_list,function(i,item){
            if (countkeyword > 16){ return false; } 
            var ischecked = '';
            if($(".remove_login_select_keyword[data='"+item.name+"']").length > 0){
              ischecked = 'checked';
            } 
            //if($(".remove_login_select_subcategory[data='"+item.subcategoryid+"']").length == 0){   
            if($(".keywordid[data='"+item.name+"']").length == 0){    
               output +='<div class="form-check col-md-6 searchkeyword_tr"><input '+ischecked+' class="form-check-input keywordid" data-title="'+item.name+'" '+ischecked+' type="checkbox" value="'+item.name+'" id="sFilters_keyword_'+item.id+'" data="'+item.name+'" name="Filters[keyword][]" /><label class="form-check-label" for=sFilters_keyword_'+item.id+'>'+item.name+'</label></div>';
                countkeyword++;
            }
        });
        }else{
            if(searchField.length >=3){
            $.each(keyword_list,function(i,item){
                if (countkeyword > 10){ return false; }
                var ischecked = '';
                if($(".remove_login_select_keyword[data='"+item.name+"']").length > 0){
                  ischecked = 'checked';
                } 
                
        		    var regex = new RegExp(searchField, "i");
                    if (item.name.search(regex) != -1) {
                        if($(".keywordid[data='"+item.name+"']").length == 0){    
                           output +='<div class="form-check col-md-6 searchkeyword_tr"><input '+ischecked+' class="form-check-input keywordid" data-title="'+item.name+'" '+ischecked+' type="checkbox" value="'+item.name+'" id="sFilters_keyword_'+item.id+'" data="'+item.name+'" name="Filters[keyword][]" /><label class="form-check-label" for=sFilters_keyword_'+item.id+'>'+item.name+'</label></div>';
                            countkeyword++;
                        }  
                    }
    		    
            });
        }
        }
        /*$.each(keyword_list,function(i,item){
            
            if (countkeyword > 10){ return false; }
            var ischecked = '';
            if($(".remove_login_select_keyword[data='"+item.name+"']").length > 0){
              ischecked = 'checked';
            } 
    		if(searchField === ''){
                //if($(".remove_login_select_subcategory[data='"+item.subcategoryid+"']").length == 0){   
                if($(".keywordid[data='"+item.name+"']").length == 0){    
                   output +='<div class="form-check col-md-6 searchkeyword_tr"><input '+ischecked+' class="form-check-input keywordid" data-title="'+item.name+'" '+ischecked+' type="checkbox" value="'+item.name+'" id="sFilters_keyword_'+item.id+'" data="'+item.name+'" name="Filters[keyword][]" /><label class="form-check-label" for=sFilters_keyword_'+item.id+'>'+item.name+'</label></div>';
                    countkeyword++;
                }                   
    		}else{
    		    
    		}
        });*/
          
    $('.list_login_keyword_list').append(output);
	if(busy_keyword){
        busy_keyword = false;
    }
}
var countdept = 1;
var busy_dept = false;
function get_dipartment_data(){
    var searchField = $(".search-department").val().toLowerCase();
    var output = ''; 
        //console.log("ss "+subcategory_list.length);
       
    		if(searchField === ''){
    		     $.each(dipartment_list,function(i,item){
                    if (countdept > 16){ return false; }
                    var ischecked = '';
                    if($(".remove_login_select_dipartment[data='"+item.name+"']").length > 0){
                      ischecked = 'checked';
                    } 
                    //if($(".remove_login_select_subcategory[data='"+item.subcategoryid+"']").length == 0){   
                    if($(".agencyid[data-id='"+item.id+"']").length == 0){    
                       output +='<div class="form-check col-md-6"><input '+ischecked+' class="form-check-input agencyid" data-title="'+item.text+'" '+ischecked+' type="checkbox" value="'+item.id+'" id="dipartment_'+item.id+'" data="'+item.text+'" data-id="'+item.id+'" name="Filters[agency][]" /><label class="form-check-label" for="dipartment_'+item.id+'">'+item.text+'</label></div>';
                       countdept++;
                    }     
    		     });
    		}else{
    		    if(searchField.length >=3){
    		        $.each(dipartment_list,function(i,item){
                        if (countdept > 10){ return false; }
                        var ischecked = '';
                        if($(".remove_login_select_dipartment[data='"+item.name+"']").length > 0){
                          ischecked = 'checked';
                        } 
            		    var regex = new RegExp(searchField, "i");
                        if (item.text.search(regex) != -1) {
                            if($(".agencyid[data-id='"+item.id+"']").length == 0){    
                               output +='<div class="form-check col-md-6"><input '+ischecked+' class="form-check-input agencyid" data-title="'+item.text+'" '+ischecked+' type="checkbox" value="'+item.id+'" id="dipartment_'+item.id+'" data="'+item.text+'" data-id="'+item.id+'" name="Filters[agency][]" /><label class="form-check-label" for="dipartment_'+item.id+'">'+item.text+'</label></div>';
                                countdept++;
                            }  
                        }
    		        });  
    		    }
    		}
          //console.log("cc "+i);
    $('.dipartment-list').append(output);
	if(busy_dept){
        busy_dept = false;
    }
}