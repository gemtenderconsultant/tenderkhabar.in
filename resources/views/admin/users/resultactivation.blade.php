@extends('admin.layouts.app')
@section('stylesheet')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet">
<style type="text/css">
.tree_category,
.etree_category {
    max-height: 400px;
    overflow-y: scroll;
    border: 1px solid #ddd;
    margin-top: 15px;
}

.list-group-item {
    border: 1px solid transparent !important;
    padding: 0px 15px !important;
    font-weight: bold;
}

.filter-header {
    display: none;
}
</style>
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 mt-2">
                <div class="card card-default">
                    <div class="card-header">
                        <div class="float-left">
                            <h2>Add/Edit Result Activation</h2>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Error!</strong> <br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if ($message = Session::get('error'))
                        <div class="alert alert-danger">
                            <p class="mb-0">{{ $message }}</p>
                        </div>
                        @endif
                        <form action="{{ route('postresultactivation',$id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="treekeyword" placeholder="Enter Product Keyword" name="search" autocomplete="off">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary btn-product-keyword" type="button">Search</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="tree_category"></div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Industry:</strong>
                                        <select id="userproduct-productid" name="Userproduct[productid][]" multiple="multiple" class="form-control">
                                            @if(!empty($dataproduct))
                                            @foreach($dataproduct as $keyp => $valp)
                                            <option value="{{ $valp->id }}" selected>{{ $valp->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>SubIndustry:</strong>
                                        <select id="userproduct-categoryid" name="Userproduct[categoryid][]" multiple="multiple" class="form-control">
                                            @if(!empty($datacategory))
                                            @foreach($datacategory as $keyct => $valct)
                                            <option value="{{ $valct->id }}" selected>{{ $valct->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Category:</strong>
                                        <select id="userproduct-subcategoryid" name="Userproduct[subcategoryid][]" multiple="multiple" class="form-control">
                                            @if(!empty($datasubcategory))
                                            @foreach($datasubcategory as $keysct => $valsct)
                                            <option value="{{ $valsct->id }}" selected>{{ $valsct->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Keyword: (add multiple keywords with comma separated)</strong>
                                        <textarea id="userproduct-keyword" name="Userproduct[keyword]" class="form-control ui-autocomplete-input" placeholder="enter keywords">@if(isset($data->keyword)){{ trim($data->keyword) }}@endif</textarea>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" name="Userproduct[chk_exact]" value="1" {{ ($is_exact == 1) ? "checked" : "" }}>
                                            <label for="customCheckbox1" class="custom-control-label">Is Exact Keyword</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Excluding Keyword: (add multiple keywords with comma separated)</strong>
                                        <input type="text" id="userproduct-excludingkeyword" name="Userproduct[excludingkeyword]" value="@if(isset($data->excludingkeyword)){{ trim($data->excludingkeyword) }}@endif" class="form-control" placeholder="Excluding Keyword">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Refine Keyword:</strong>
                                        <input type="text" name="Userproduct[refine_keyword]" class="form-control" value="@if(isset($data->refine_keyword)){{ trim($data->refine_keyword) }}@endif" placeholder="Refine Keyword">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="etreekeyword" placeholder="Enter Product Keyword" name="search" autocomplete="off">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary btn-eproduct-keyword" type="button">Search</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="etree_category"></div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Excluding Industry:</strong>
                                        <select id="userproduct-eproductid" name="Userproduct[eproductid][]" multiple="multiple" class="form-control">
                                            @if(!empty($dataeproduct))
                                            @foreach($dataeproduct as $keyep => $valep)
                                            <option value="{{ $valep->id }}" selected>{{ $valep->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Excluding SubIndustry:</strong>
                                        <select id="userproduct-ecategoryid" name="Userproduct[ecategoryid][]" multiple="multiple" class="form-control">
                                            @if(!empty($dataecategory))
                                            @foreach($dataecategory as $keyect => $valect)
                                            <option value="{{ $valect->id }}" selected>{{ $valect->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Excluding Category:</strong>
                                        <select id="userproduct-esubcategoryid" name="Userproduct[esubcategoryid][]" multiple="multiple" class="form-control">
                                            @if(!empty($dataesubcategory))
                                            @foreach($dataesubcategory as $keyesct => $valesct)
                                            <option value="{{ $valesct->id }}" selected>{{ $valesct->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Agency:</strong>
                                        <select id="userproduct-agency" name="Userproduct[agency][]" multiple="multiple" class="form-control">
                                            @if(!empty($dataagency))
                                            @foreach($dataagency as $keydept => $valdept)
                                            <option value="{{ $valdept->agencyid }}" selected>{{ $valdept->agencyname }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Excluding Agency:</strong>
                                        <select id="userproduct-excludingagency" name="Userproduct[excludingagency][]" multiple="multiple" class="form-control">
                                            @if(!empty($edataagency))
                                            @foreach($edataagency as $keyedept => $valedept)
                                            <option value="{{ $valedept->agencyid }}" selected>{{ $valedept->agencyname }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>State:</strong>
                                        <select id="userproduct-state" name="Userproduct[state][]" multiple="multiple" class="form-control">
                                            @foreach($datastate as $keys => $vals)
                                            <option value="{{ $vals->id }}" {{ (in_array($vals->id,$state_arr)) ? 'selected' : '' }}>{{ $vals->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>City:</strong>
                                        <select id="userproduct-city" name="Userproduct[city][]" multiple="multiple" class="form-control">
                                            @if(!empty($datacity))
                                            @foreach($datacity as $keyc => $valc)
                                            <option value="{{ $valc->name }}" {{ (in_array($valc->name,$city_arr)) ? 'selected' : '' }}>{{ $valc->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <strong>Min Amount:</strong>
                                        <input type="text" id="userproduct-min_amount" name="Userproduct[Min_Amount]" value="{{ $min_amount }}" class="form-control" placeholder="Min Amount">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <strong>Max Amount:</strong>
                                        <input type="text" id="userproduct-max_amount" name="Userproduct[Max_Amount]" value="{{ $max_amount }}" class="form-control" placeholder="Max Amount">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="customCheckbox2" name="Userproduct[chk_estimated]" value="1" {{ ($is_estimate == 1) ? "checked" : "" }}>
                                            <label for="customCheckbox2" class="custom-control-label">Not Estimated</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <strong>From Date:</strong>
                                        <input type="date" id="userproduct-fromdate" name="Userproduct[fromdate]" value="{{ $fromdate }}" class="form-control clearallinput" placeholder="From Date">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <strong>To Date:</strong>
                                        <input type="date" id="userproduct-todate" name="Userproduct[todate]" value="{{ $todate }}" class="form-control clearallinput" placeholder="To Date">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary sb-userproduct">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript">
// $("#userproduct-agency").select2({
//     closeOnSelect: false
// });

// $("#userproduct-excludingagency").select2({
//     closeOnSelect: false
// });
$("#userproduct-agency,#userproduct-excludingagency").select2({
    ajax: {
        url: '{{ route('getdepartmentlist') }}',
        dataType: 'json',
        delay: 250,
        data: function(params) {
            return {
                searchTerm: params.term // search term
            };
        },
        processResults: function(response) {
            return {
                results: response
            };
        },
        cache: true
    },
    escapeMarkup: function(markup) { return markup; }, // let our custom formatter work
    minimumInputLength: 3,
});

$("#userproduct-state").select2({
    closeOnSelect: false
});
$("#userproduct-city").select2({
    closeOnSelect: false
});
$("#userproduct-productid").select2({
    closeOnSelect: false
});
$("#userproduct-categoryid").select2({
    closeOnSelect: false
});
$("#userproduct-subcategoryid").select2({
    closeOnSelect: false
});
$("#userproduct-eproductid").select2({
    closeOnSelect: false
});
$("#userproduct-ecategoryid").select2({
    closeOnSelect: false
});
$("#userproduct-esubcategoryid").select2({
    closeOnSelect: false
});

$(".btn-product-keyword").click(function() {
    var values = $("#treekeyword").val();
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    var sub = '';
    jQuery.ajax({
        'type': 'POST',
        'url': '{{ route('treecategory') }}',
        //'data': "data=" + values,
        data: { 'data': values, '_token': csrf_token },
        'cache': false,
        'success': function(response) {
            $('.tree_category').html('');
            $('.tree_category').append(response);
        }
    });
});
//excluding product,category and subcategory
$(".btn-eproduct-keyword").click(function() {
    var values = $("#etreekeyword").val();
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    var sub = '';
    jQuery.ajax({
        'type': 'POST',
        'url': '{{ route('excludingtreecategory') }}',
        //'data': "data=" + values,
        data: { 'data': values, '_token': csrf_token },
        'cache': false,
        'success': function(response) {
            $('.etree_category').html('');
            $('.etree_category').append(response);
        }
    });
});

$('body').on('click', '.i_select', function() {
    var n1 = jQuery(".i_select:checked").length;
    //var selectin = new Array();
    //var selectinname = new Array();
    //$('#userproduct-productid').html('');
    //$("#userproduct-productid").select2("val", "");
    if (n1 > 0) {
        jQuery(".i_select:checked").each(function() {
            //selectin.push($(this).val());
            //selectinname.push($(this).attr('data'));
            var sn = $(this).attr('data');
            var ss = $(this).val();
            var newOption = new Option(sn, ss, true, true);
            $('#userproduct-productid').append(newOption).trigger('change');
        });
    }
});
$('body').on('click', '.c_select', function() {
    var n1 = jQuery(".c_select:checked").length;
    //$('#userproduct-categoryid').html('');
    //$("#userproduct-categoryid").select2("val", "");
    if (n1 > 0) {
        jQuery(".c_select:checked").each(function() {
            var sn = $(this).attr('data');
            var ss = $(this).val();
            var newOption = new Option(sn, ss, true, true);
            $('#userproduct-categoryid').append(newOption).trigger('change');
        });
    }
});
$('body').on('click', '.s_select', function() {
    var n1 = jQuery(".s_select:checked").length;
    //$('#userproduct-subcategoryid').html('');
    //$("#userproduct-subcategoryid").select2("val", "");
    if (n1 > 0) {
        jQuery(".s_select:checked").each(function() {
            var sn = $(this).attr('data');
            var ss = $(this).val();
            var newOption = new Option(sn, ss, true, true);
            $('#userproduct-subcategoryid').append(newOption).trigger('change');
        });
    }
});
$('body').on('click', '.k_select', function() {
    var n1 = jQuery(".k_select:checked").length;
    var selectin = new Array();
    //var alredykeyword = $('#userproduct-keyword').val();
    var strVal = $.trim($('#userproduct-keyword').val());
    var lastChar = strVal.slice(-1);
    if (lastChar == ',') {
        strVal = strVal.slice(0, -1);
    }

    var exist_array = strVal.split(',');
    const index = exist_array.indexOf($(this).val());
    if (index > -1) {
        exist_array.splice(index, 1);
    }

    var selected_fiter_keyword = exist_array.join(",");
    //alert(exist_array);
    //var selectinname = new Array();
    //$('#userproduct-subcategoryid').html('');
    //$("#userproduct-subcategoryid").select2("val", "");

    if (n1 > 0) {
        jQuery(".k_select:checked").each(function() {
            selectin.push($(this).val());
            //selectinname.push($(this).attr('data'));
        });
    }
    var selected_keyword = selectin.join(",");
    var final_key = selected_fiter_keyword + ',' + selected_keyword;
    var array = final_key.split(',');
    var uniqueNames = [];
    $.each(array, function(i, el) {
        if ($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
    });
    var final_keywords = uniqueNames.join();
    $('#suserproduct-keyword').text(final_keywords);
    $('#userproduct-keyword').val(final_keywords);
});

$('body').on('click', '.ei_select', function() {
    var n1 = jQuery(".ei_select:checked").length;
    //var selectin = new Array();
    //var selectinname = new Array();
    //$('#userproduct-eproductid').html('');
    //$("#userproduct-eproductid").select2("val", "");
    if (n1 > 0) {
        jQuery(".ei_select:checked").each(function() {
            //selectin.push($(this).val());
            //selectinname.push($(this).attr('data'));
            var sn = $(this).attr('data');
            var ss = $(this).val();
            var newOption = new Option(sn, ss, true, true);
            $('#userproduct-eproductid').append(newOption).trigger('change');
        });
    }
});
$('body').on('click', '.ec_select', function() {
    var n1 = jQuery(".ec_select:checked").length;
    //$('#userproduct-ecategoryid').html('');
    //$("#userproduct-ecategoryid").select2("val", "");
    if (n1 > 0) {
        jQuery(".ec_select:checked").each(function() {
            var sn = $(this).attr('data');
            var ss = $(this).val();
            var newOption = new Option(sn, ss, true, true);
            $('#userproduct-ecategoryid').append(newOption).trigger('change');
        });
    }
});
$('body').on('click', '.es_select', function() {
    var n1 = jQuery(".es_select:checked").length;
    //$('#userproduct-esubcategoryid').html('');
    //$("#userproduct-esubcategoryid").select2("val", "");
    if (n1 > 0) {
        jQuery(".es_select:checked").each(function() {
            var sn = $(this).attr('data');
            var ss = $(this).val();
            var newOption = new Option(sn, ss, true, true);
            $('#userproduct-esubcategoryid').append(newOption).trigger('change');
        });
    }
});
$('body').on('click', '.sb-userproduct', function() {
    var TCode = document.getElementById('userproduct-keyword').value;
    if (/[^a-zA-Z0-9 ,\-\/]/.test(TCode)) {
        alert('Input is not alphanumeric! Remove special character');
        return false;
    }
    return true;
});


$('body').on('change ', '#userproduct-state', function() {
    var selectedState = new Array();
    var n = jQuery("#userproduct-state option:selected").length;
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    if (n > 0) {
        jQuery("#userproduct-state option:selected").each(function() {
            selectedState.push($(this).val());
        });
        //alert(selectedState);
    }
    if (n == 0) {
        jQuery("#userproduct-city").html('');
    }

    $.ajax({
        'type': 'POST',
        'url': '{{ route('dynamicfiltercity') }}',
        data: { 'data': selectedState, '_token': csrf_token },
        'cache': false,
        'success': function(html) {
            $('#userproduct-city').html('');
            $("#userproduct-city").select2("val", "");
            $("#userproduct-city").html(html);
        }
    });
});
</script>
@endsection