<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserproductController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserserviceinquiryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchresultController;
use App\Http\Controllers\PayuController;
use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('reset', function (){
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
});

Route::get('/clear-everything', function() {
    \Artisan::call('config:clear');
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');
    return "All cache cleared!";
});

// Route::get('/', function () {
//     return view('home');
// });

Route::get('/',[PageController::class,'home'])->name('welcome');
//Route::get('/home',[PageController::class,'home'])->name('welcome');

Auth::routes();

Route::get('searchtenders',[SearchController::class,'searchtenders'])->name('searchtenders');
Route::get('search-result/{id?}',[SearchController::class,'searchkeyword'])->name('searchkeyword')->middleware('loginuser');
Route::get('advancesearch/search-result/{id?}',[SearchController::class,'postadvancesearch'])->name('postadvancesearch')->middleware('loginuser');
Route::get('tenderdetails/{id}',[SearchController::class,'tenderview'])->name('tenderview');
Route::post('gettenderslist',[SearchController::class,'gettenderslist'])->name('gettenderslist');

Route::get('search-result-single/{id?}',[SearchController::class,'searchkeyword'])->name('searchkeyword')->middleware('loginuser');
Route::get('tenderdetails-single/{id}',[SearchController::class,'tenderviewsingle'])->name('tenderviewsingle');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [PageController::class, 'aboutus'])->name('about-us');
Route::get('/contact-us', [PageController::class, 'contactus'])->name('contact-us');
Route::get('/services', [PageController::class, 'services'])->name('services');

Route::get('/policy', [PageController::class, 'privacypolicy'])->name('privacy-policy');
Route::get('/pricing-plans', [PageController::class, 'pricingplans'])->name('pricing-plans');

Route::post('/payu', [PayuController::class, 'payu'])->name('payment.payu');   // STEP 1
Route::post('/payu/pay', [PayuController::class, 'pay'])->name('payu.pay');    // STEP 2
Route::post('/payment/success', [PayuController::class, 'success'])->name('payu.success');
Route::post('/payment/failed', [PayuController::class, 'failed'])->name('payu.failed');
Route::get('/payment/receipt', [PayuController::class, 'downloadReceipt'])->name('payment.receipt');

Route::post('/singlepayu', [PayuController::class, 'singlepayu'])->name('singlepayment.singlepayu');   // STEP 1
Route::post('/singlepayu/pay', [PayuController::class, 'singlepay'])->name('singlepayu.pay');    // STEP 2
Route::post('/singlepayment/success', [PayuController::class, 'singlesuccess'])->name('singlepayu.success');
Route::post('/singlepayment/failed', [PayuController::class, 'singlefailed'])->name('singlepayu.failed');

Route::get('/gem', [PageController::class, 'gem'])->name('gem');
Route::get('/bidding', [PageController::class, 'bidding'])->name('bidding');
Route::get('/certification', [PageController::class, 'certification'])->name('certification');

Route::post('userinquiry', [PageController::class, 'userinquiry'])->name('userinquiry');
Route::post('userinquirynew', [PageController::class, 'userinquirynew'])->name('userinquirynew');
Route::post('sortinquiry', [PageController::class, 'sortinquiry'])->name('sortinquiry');
Route::post('filtercity', [PageController::class, 'getfiltercity'])->name('city-filter');
Route::post('filtercitys', [PageController::class, 'getfiltercityselect2'])->name('city-filter-select2');

Route::post('keywordlist', [PageController::class, 'actionGetkeywordlist'])->name('get-keyword-list');
Route::get('EmailTenderDetails',[TenderController::class,'emailTenderDetails'])->name('emailTenderDetails');
Route::get('dashboard', [DashboardController::class, 'actiondashboard'])->name('dashboard')->middleware('loginuser');
Route::get('tender-listing', [DashboardController::class, 'actiontenderresult'])->name('tender-listing')->middleware('loginuser');

Route::post('tenderlist/filterupdate',[TenderController::class,'filterupdate'])->name('tenderlist-filterupdate');
Route::post('tenderlist/filtercreate',[TenderController::class,'filtercreate'])->name('tenderlist-filtercreate');
Route::post('tenderlist/filterdelete',[TenderController::class,'filterdelete'])->name('tenderlist-filterdelete');

Route::post('favoritetender',[TenderController::class,'favoritetender'])->name('favoritetender');

Route::post('tenderlist/viewdashboardtenderlist',[SearchController::class,'backendgettenderslist'])->name('backendgettenderslist');

Route::get('tenderdetails',[SearchController::class,'backendtenderview'])->name('backendtenderview');

Route::get('tenderresultdetails',[SearchresultController::class,'backendtenderresultview'])->name('backendtenderresultview');

Route::get('/advancesearch',[PageController::class,'advancesearch'])->name('advancesearch');
Route::get('change-password2',[PageController::class,'changepasswordform'])->name('changepassword2')->middleware('loginuser');
Route::post('/change-password2', [PageController::class, 'changePassword'])->name('password.update2');
Route::get('my-profile',[AdminController::class,'myprofile'])->name('myprofile')->middleware('loginuser');
Route::prefix('admin')->group(function () { 

    Route::get('/',[AdminController::class,'showAdminLoginForm'])->name('admin.login-view');
    Route::get('login',[AdminController::class,'showAdminLoginForm'])->name('admin.login-view');
    Route::post('/admin',[AdminController::class,'adminLogin'])->name('admin.login');
    Route::get('logout',[AdminController::class,'adminLogout'])->name('admin.logout');
    
    Route::get('dashboard',[AdminController::class,'admindashboard'])->name('admindashboard');
    Route::get('userlist',[UserController::class,'userlist'])->name('user-list');
    Route::get('activation/{id}',[UserproductController::class,'activation'])->name('activation');

    Route::get('resultactivation/{id}',[UserproductController::class,'resultactivation'])->name('resultactivation');
    Route::post('postresultactivation/{id}',[UserproductController::class,'postresultactivation'])->name('postresultactivation');

    Route::post('refreshjson',[AdminController::class,'refreshuserjson'])->name('refresh-user-json-list');
    
    Route::post('treecategory',[UserproductController::class,'treecategory'])->name('treecategory');
    Route::get('getdepartmentlist',[UserproductController::class,'getdepartmentlist'])->name('getdepartmentlist');
    Route::post('excludingtreecategory',[UserproductController::class,'excludingtreecategory'])->name('excludingtreecategory');
    Route::post('dynamicfiltercity',[UserproductController::class,'dynamicfiltercity'])->name('dynamicfiltercity');
    Route::post('postactivation/{id}',[UserproductController::class,'postactivation'])->name('postactivation');
    Route::resource('users', UserController::class);
 
    Route::get('adminlist',[AdminController::class,'adminlist'])->name('adminlist');
    Route::resource('admins', AdminController::class);

    Route::get('userserviceinquiry',[UserserviceinquiryController::class,'index'])->name('userserviceinquiry');
    Route::get('userserviceinquirylist',[UserserviceinquiryController::class,'userserviceinquirylist'])->name('userserviceinquirylist');

    Route::post('update-password',[AdminController::class,'updatepassword'])->name('update-password');

    Route::get('emails',[AdminController::class,'adminemails'])->name('adminemails');
    Route::get('emailcredit',[AdminController::class,'emailcredit'])->name('emailcredit');
    Route::get('emailreport',[AdminController::class,'smsreport'])->name('emailreport');
    Route::get('ajaxsmsreport',[AdminController::class,'ajaxsmsreport'])->name('ajaxsmsreport');

    Route::get('ajax-user-select',[AdminController::class,'ajaxuserselect'])->name('ajax-user-select');
    Route::any('change-pwd',[AdminController::class,'changepwd'])->name('changepwd')->middleware('loginuser');
});

Route::get('tenderresults',[SearchresultController::class,'logintenderresults'])->name('logintenderresults')->middleware('loginuser');

Route::post('tenderlist/viewdashboardtenderresultlist',[SearchresultController::class,'backendgettenderresultlist'])->name('backendgettenderresultlist');

Route::get('searchresult/{id?}',[SearchresultController::class,'searchresultkeyword'])->name('searchresultkeyword')->middleware('loginuser');

Route::get('tender/searchresult',[SearchresultController::class,'searchresult'])->name('searchresult');

Route::get('tenderresultview/{id}',[SearchresultController::class,'tenderresultview'])->name('tenderresultview');

Route::post('site/gettenderresultslist',[SearchresultController::class,'gettenderresultslist'])->name('gettenderresultslist');

Route::get('result/newemaildetails',[SearchresultController::class,'emailTenderresult'])->name('emailTenderresult');

Route::get('state',[SearchController::class,'state'])->name('state');
Route::get('statesearch',[SearchController::class,'statesearch'])->name('statesearch');
Route::get('stateresult/{id?}',[SearchController::class,'stateresult'])->name('stateresult')->middleware('loginuser');

Route::get('category',[SearchController::class,'category'])->name('category');
Route::get('categorysearch',[SearchController::class,'categorysearch'])->name('categorysearch');
Route::get('categoryresult/{id?}',[SearchController::class,'categoryresult'])->name('categoryresult')->middleware('loginuser');

Route::get('authorities',[SearchController::class,'authorities'])->name('authorities');
Route::get('authoritiessearch',[SearchController::class,'authoritiessearch'])->name('authoritiessearch');
Route::get('authoritiesresult/{id?}',[SearchController::class,'authoritiesresult'])->name('authoritiesresult')->middleware('loginuser');

Route::get('logout',function() {
    Session::flush();
    Auth::logout();
    return redirect('login');
 
});

Route::get('/test',function() {
    // $data = DB::table('tbl_document_result_links')
    //         ->where('id',1)
    //         ->update(array('date'=>'2024-01-01'));
    $data = DB::table('tbl_document_result_links')->first();
    dd($data);
});