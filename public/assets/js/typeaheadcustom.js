// start typeahead
var keywordselectkey = 10000;
$(function () {
    var myTypeahead = $.typeahead({
    input: '.js-typeahead',
    minLength: 1,
    maxItem: 50,
    maxItemPerGroup: 20,
    order: "asc",
    hint: true,
    cache: false,
    group: {
        key: "division",
        template: function (item) {
 
            var division = item.division;
            if (~division.toLowerCase().indexOf('north')) {
                division += " ---> Snow!";
            } else if (~division.toLowerCase().indexOf('south')) {
                division += " ---> Beach!";
            }
 
            return division;
        }
    },
    display: ["name", "city", "division"],
    href: "/{{division}}/{{name}}-tenders",
    dropdownFilter: [{
        key: 'division',
        template: '<strong>{{division}}</strong>',
        
        all: 'All'
    }],
    template: '<span>' +
        '<span class="name">{{name}}</span>' +
    '</span>',
    correlativeTemplate: true,
    source: {
        teams: {
            url: "../../testjson.json"
        }
    },
    callback: {
                onClickAfter: function (node, a, item, event) {
                    //console.log(item);
                    event.preventDefault();
                    var sid = item.id;
                    var svalue = item.name;
                    //saveuserkeyword(svalue);
                    if(item.division == "Keyword"){
                        $(".chk_selected_login_keyword").show();
                        if($(".remove_login_select_keyword[data='"+svalue+"']").length == 0){
                            //$('.list_selected_login_keyword').append('<span class="badge badge-outline-primary mb-1 remove_login_select_keyword" data="'+svalue+'">'+svalue+'<i class="mdi mdi-close ml-1"></i></span>');
                            //$('.list_login_keyword_list').append('<div class="col-md-6"><div class="form-check my-1"><label class="form-check-label"><input type="checkbox" name="Filters[keyword][]" class="form-check-input keywordid" data="'+svalue+'" value="'+svalue+'" checked="">'+svalue+'<i class="input-helper"></i></label></div></div>');                
                            $('.list_selected_login_keyword').append('<li class="BtnAddList remove_login_select_keyword" data="'+svalue+'">'+svalue+'<i class="fa-solid fa-xmark"></i></li>');
                            if($(".keywordid[data='"+svalue+"']").length == 0){  
                            $('.list_login_keyword_list').append('<div class="form-check col-md-6 searchkeyword_tr"><input class="form-check-input keywordid" data-title="'+svalue+'" type="checkbox" value="'+svalue+'" id="sFilters_keyword_'+keywordselectkey+'" data="'+svalue+'" name="Filters[keyword][]" checked><label class="form-check-label" for="sFilters_keyword_'+keywordselectkey+'">'+svalue+'</label></div>');
                            }
                            keywordselectkey++;
                            var keywords = new Array();
                            var keywords_str = $("input[name='input_s_keyword']").val();
                            if(keywords_str != ""){
                                keywords = keywords_str.split(',');
                            }
                            keywords.push(svalue);
                            //var keycount = keywords.length; 
                            //$('.buttonkeyword').text('Keyword ('+keycount+')');
                            $("input[name='input_s_keyword']").val(keywords.join(","));   
                            $(".keywordid[data='"+svalue+"']").prop('checked', true);
                            $('.keyword_count').text('('+$(".keywordid:checked").length+')');
                            
                        }else{
                            //$(".keywordid[data-title='"+svalue+"']").prop('checked', true);
                        }
                        
                    }else if(item.division == "Category"){
                        $(".chk_selected_login_subcategory").show();
                        if($(".remove_login_select_subcategory[data='"+sid+"']").length == 0){
                            //$(".list_selected_login_subcategory").append('<span class="badge badge-outline-primary mb-1 remove_login_select_subcategory" data="'+sid+'">'+svalue+'<i class="mdi mdi-close ml-1"></i></span>');
                            //$('.list_login_subcategory_list').append('<div class="col-md-6"><div class="form-check my-1"><label class="form-check-label"><input type="checkbox" name="Filters[subcategory][]" class="form-check-input subcategoryid" id="sFilters_subcategory_'+sid+'" data="'+svalue+'" value="'+sid+'" checked>'+svalue+'<i class="input-helper"></i></label></div></div>');
                            $(".list_selected_login_subcategory").append('<li class="BtnAddList remove_login_select_subcategory" data="'+sid+'">'+svalue+' <i class="fa-solid fa-xmark"></i></li>');
                            svalue = $.trim(svalue);
                            if($(".subcategoryid[data='"+svalue+"']").length == 0){  
                            $('.list_login_subcategory_list').append('<div class="form-check col-md-6 searchkeyword_tr"><input class="form-check-input subcategoryid" data-title="'+svalue+'" checked type="checkbox" value="'+sid+'" id="sFilters_subcategory_'+sid+'" data="'+svalue+'" name="Filters[subcategoryid][]"/><label class="form-check-label" for=sFilters_subcategory_'+sid+'>'+svalue+'</label></div>');
                            }
                            var subcategory = new Array();
                            var subcategory_str = $("input[name='input_s_subcategory']").val();
                            if(subcategory_str != ""){
                                subcategory = subcategory_str.split(',');
                            }
                            subcategory.push(sid);
                            $("input[name='input_s_subcategory']").val(subcategory.join(",")); 
                            $(".subcategoryid[data='"+svalue+"']").prop('checked', true);
                            $('.subcategory_count').text('('+$(".subcategoryid:checked").length+')');
                        }
                    }else if(item.division == "Department"){
                        $(".chk_selected_login_org").show();
                        if($(".remove_login_select_dipartment[data='"+sid+"']").length == 0){
                            //$(".list_selected_login_org").append('<span class="badge badge-outline-primary mb-1 remove_login_select_org" data="'+sid+'">'+svalue+'<i class="mdi mdi-close ml-1"></i></span>');
                            //$('.list_login_org_list').append('<div class="col-md-6"><div class="form-check my-1"><label class="form-check-label"><input type="checkbox" name="Filters[agency][]" class="form-check-input agencyid" id="sFilters_agency_'+sid+'" data="'+svalue+'" value="'+sid+'" checked>'+svalue+'<i class="input-helper"></i></label></div></div>');
                            $(".list-selected-dipartment").append('<li class="BtnAddList remove_login_select_dipartment" data="'+sid+'">'+svalue+'<i class="fa-solid fa-xmark"></i></li>');
                            if($(".agencyid[data-id='"+sid+"']").length == 0){  
                            $('.dipartment-list').append('<div class="form-check col-md-6"><input class="form-check-input agencyid" data-title="'+svalue+'" checked type="checkbox" value="'+sid+'" id="dipartment_'+sid+'" data="'+svalue+'" data-id="'+sid+'" name="Filters[agency][]"><label class="form-check-label" for="dipartment_'+sid+'">'+svalue+'</label></div>');
                            }
                            var org = new Array();
                            var org_str = $("input[name='input_s_org']").val();
                            if(org_str != ""){
                                org = org_str.split(',');
                            }
                            org.push(sid);
                            $("input[name='input_s_org']").val(org.join(",")); 
                            $(".agencyid[data-id='"+sid+"']").prop('checked', true);
                            $('.dipartment_count').text('('+$(".agencyid:checked").length+')');
                        }
                    }else if(item.division == "State"){
                        $(".chk_selected_login_state").show();
                        if($(".remove_login_select_state[data='"+sid+"']").length == 0){
                            //$(".list_selected_login_state").append('<span class="badge badge-outline-primary mb-1 remove_login_select_state" data="'+sid+'">'+svalue+'<i class="mdi mdi-close ml-1"></i></span>');
                            //$('.list_login_state_list').append('<div class="col-md-6"><div class="form-check my-1"><label class="form-check-label"><input type="checkbox" name="Filters[state][]" class="form-check-input stateid" id="sFilters_state_'+sid+'" data="'+svalue+'" value="'+sid+'" checked>'+svalue+'<i class="input-helper"></i></label></div></div>');
                            $(".list_selected_login_state").append('<li class="BtnAddList remove_login_select_state" data="'+sid+'">'+svalue+'<i class="fa-solid fa-xmark"></i></li>');
                            if($(".stateid[data='"+svalue+"']").length == 0){  
                            $('.state_list').append('<div class="form-check col-md-6 searchkeyword_tr">'+
                                '<input class="form-check-input stateid" type="checkbox" value='+sid+' id="sFilters_state_'+sid+'" name="Filters[state][]" data="'+svalue+'" checked>'+
                                '<label class="form-check-label" for="sFilters_state_'+sid+'">'+svalue+'</label>'+
                            '</div>');
                            }
                            var state = new Array();
                            var state_str = $("input[name='input_s_state']").val();
                            if(state_str != ""){
                                state = state_str.split(',');
                            }
                            state.push(sid);
                            $("input[name='input_s_state']").val(state.join(",")); 
                            $(".stateid[data='"+svalue+"']").prop('checked', true);
                            $('.state_count').text('('+$(".stateid:checked").length+')');
                        }
                    }else{
                        item.href = item.href.replaceAll(' ', '-');
                        event.preventDefault();
                    }
                    $(".js-typeahead").val('');
                    //$('.js-typeahead').typeahead('val', '');
                    
                    offset = 1;
                    busy == false;
                    $("#lev1").html('');
                    getFilter2(offset);
                    
                }
            },
            debug: true
    });
});

$('body').on('click', '.typeahead_searchbutton', function(){
    var svalue = $(".js-typeahead").val();
    //alert(svalue);
    $(".chk_selected_login_keyword").show();
    if($(".remove_login_select_keyword[data='"+svalue+"']").length == 0){
        $('.list_selected_login_keyword').append('<li class="BtnAddList remove_login_select_keyword" data="'+svalue+'">'+svalue+'<i class="fa-solid fa-xmark"></i></li>');
        if($(".keywordid[data='"+svalue+"']").length == 0){  
        $('.list_login_keyword_list').append('<div class="form-check col-md-6 searchkeyword_tr"><input class="form-check-input keywordid" data-title="'+svalue+'" type="checkbox" value="'+svalue+'" id="sFilters_keyword_'+keywordselectkey+'" data="'+svalue+'" name="Filters[keyword][]" checked><label class="form-check-label" for="sFilters_keyword_'+keywordselectkey+'">'+svalue+'</label></div>');
        }
        keywordselectkey++;
        var keywords = new Array();
        var keywords_str = $("input[name='input_s_keyword']").val();
        if(keywords_str != ""){
            keywords = keywords_str.split(',');
        }
        keywords.push(svalue);
        $("input[name='input_s_keyword']").val(keywords.join(","));   
        $(".keywordid[data='"+svalue+"']").prop('checked', true);
        $('.keyword_count').text('('+$(".keywordid:checked").length+')');
        
    }else{
       
    }
    $(".js-typeahead").val('');
    offset = 1;
    busy == false;
    $("#lev1").html('');
    getFilter2(offset);
});
// end typeahead