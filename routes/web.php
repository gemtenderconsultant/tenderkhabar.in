<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SearchresultController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserproductController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\UserserviceinquiryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PayuController;

Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/', function () {
    return view('index');
});
//navbar 
Route::get('/about-us', [PageController::class, 'aboutus'])->name('about-us');
Route::get('/contact-us', [PageController::class, 'contactus'])->name('contact-us');
Route::get('/otherportal', [PageController::class, 'otherportal'])->name('otherportal');
Route::get('/gem', [PageController::class, 'gem'])->name('gem');
Route::get('/bidding', [PageController::class, 'bidding'])->name('bidding');
Route::get('/certification', [PageController::class, 'certification'])->name('certification');
Route::get('/pricing-plans', [PageController::class, 'pricingplans'])->name('pricing-plans');

Auth::routes();
//profile 
Route::get('profile', [ProfileController::class, 'show'])->name('profile')->middleware(['auth']);
//website front view 
Route::get('searchtenders',[SearchController::class,'searchtenders'])->name('searchtenders');
Route::get('search-tender/{id?}',[SearchController::class,'searchkeyword'])->name('searchkeyword')->middleware('loginuser');
Route::get('tenderdetail/{id}',[SearchController::class,'tenderdetail'])->name('tenderdetail');
Route::post('gettenderslist',[SearchController::class,'gettenderslist'])->name('gettenderslist');
Route::get('advancesearch/search-tender/{id?}',[SearchController::class,'postadvancesearch'])->name('postadvancesearch')->middleware('loginuser');

Route::get('searchresults',[SearchresultController::class,'searchresults'])->name('searchresults');
Route::get('search-result/{id?}',[SearchresultController::class,'searchresultkeyword'])->name('searchresultkeyword');
Route::get('resultdetail/{id}',[SearchresultController::class,'resultdetail'])->name('resultdetail');
Route::get('tenderresultview/{id}',[SearchresultController::class,'tenderresultview'])->name('tenderresultview');
Route::post('gettenderresultslist',[SearchresultController::class,'gettenderresultslist'])->name('gettenderresultslist');

//backend tenderlist
Route::get('dashboard', [DashboardController::class, 'actiondashboard'])->name('dashboards')->middleware('loginuser');
Route::post('tenderlist/viewdashboardtenderlist',[SearchController::class,'backendgettenderslist'])->name('backendgettenderslist');
Route::post('tenderlist/viewdashboardtenderresultlist',[SearchresultController::class,'backendgettenderresultlist'])->name('backendgettenderresultlist');
Route::get('tenderdetails',[SearchController::class,'backendtenderview'])->name('backendtenderview');
Route::get('resultdetails',[SearchresultController::class,'backendtenderresultview'])->name('backendtenderresultview');

//login user page after 
Route::get('tender-listing', [DashboardController::class, 'actiontenderresult'])->name('tendersearch')->middleware('loginuser');
Route::get('tenderresults',[SearchresultController::class,'logintenderresults'])->name('logintenderresults')->middleware('loginuser');

// filter tender
Route::post('filtercity', [PageController::class, 'getfiltercity'])->name('city-filter');
// filter resulttender
Route::post('filtercitys', [PageController::class, 'getfiltercityselect2'])->name('city-filter-select2');
Route::post('filtercitysadvance', [PageController::class, 'getfiltercityselect2advance'])->name('city-filter-select2-advance');

//backend filter 
Route::post('tenderlist/filterdelete',[TenderController::class,'filterdelete'])->name('tenderlist-filterdelete');
Route::post('favoritetender',[TenderController::class,'favoritetender'])->name('favoritetender');
Route::get('change-password2',[PageController::class,'changepasswordform'])->name('changepassword2')->middleware('loginuser');
Route::post('/change-password2', [PageController::class, 'changePassword'])->name('password.update2');

//frontview 
Route::get('state',[SearchController::class,'state'])->name('state');
Route::get('statesearch',[SearchController::class,'statesearch'])->name('statesearch');
Route::get('stateresult/{id?}',[SearchController::class,'stateresult'])->name('stateresult')->middleware('loginuser');

Route::get('category',[SearchController::class,'category'])->name('category');
Route::get('categorysearch',[SearchController::class,'categorysearch'])->name('categorysearch');
Route::get('categoryresult/{id?}',[SearchController::class,'categoryresult'])->name('categoryresult')->middleware('loginuser');

Route::get('authorities',[SearchController::class,'authorities'])->name('authorities');
Route::get('authoritiessearch',[SearchController::class,'authoritiessearch'])->name('authoritiessearch');
Route::get('authoritiesresult/{id?}',[SearchController::class,'authoritiesresult'])->name('authoritiesresult')->middleware('loginuser');

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showAdminLoginForm'])->name('admin.login-view');
    Route::post('/admin', [AdminController::class, 'adminLogin'])->name('admin.login');
    Route::get('/dashboard', [AdminController::class, 'admindashboard'])->name('dashboard');
    Route::get('/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');

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
    Route::get('inquriylist',[AdminController::class,'inquriylist'])->name('inquriylist');
    
    Route::get('userserviceinquiry',[UserserviceinquiryController::class,'index'])->name('userserviceinquiry');
    Route::get('userserviceinquirylist',[UserserviceinquiryController::class,'userserviceinquirylist'])->name('userserviceinquirylist');

    Route::post('update-password',[AdminController::class,'updatepassword'])->name('update-password');

    Route::get('emails',[AdminController::class,'adminemails'])->name('adminemails');
    Route::get('emailcredit',[AdminController::class,'emailcredit'])->name('emailcredit');
    Route::get('emailreport',[AdminController::class,'smsreport'])->name('emailreport');
    Route::get('ajaxsmsreport',[AdminController::class,'ajaxsmsreport'])->name('ajaxsmsreport');

    Route::get('ajax-user-select',[AdminController::class,'ajaxuserselect'])->name('ajax-user-select');
    Route::any('change-pwd',[AdminController::class,'changepwd'])->name('changepwd')->middleware('loginuser');
    Route::post('/admin/change-password', [AdminController::class, 'changePassword'])->name('changePassword');
});
Route::get('/get-user/{id}', [UserController::class, 'getUser'])->name('get-user');
Route::get('/get-admin/{id}', [AdminController::class, 'getAdmin'])->name('get-admin');
Route::get('/advan-search-btn', [SearchController::class, 'getadvance']);

Route::get('logout',function() {
    Session::flush();
    Auth::logout();
    return redirect('login');
});
Route::post('/payu', [PayuController::class, 'payu'])->name('payment.payu');   // STEP 1
Route::post('/payu/pay', [PayuController::class, 'pay'])->name('payu.pay');    // STEP 2
Route::post('/payment/success', [PayuController::class, 'success'])->name('payu.success');
Route::post('/payment/failed', [PayuController::class, 'failed'])->name('payu.failed');
Route::get('/payment/receipt', [PayuController::class, 'downloadReceipt'])->name('payment.receipt');

Route::post('/singlepayu', [PayuController::class, 'singlepayu'])->name('singlepayment.singlepayu');   // STEP 1
Route::post('/singlepayu/pay', [PayuController::class, 'singlepay'])->name('singlepayu.pay');    // STEP 2
Route::post('/singlepayment/success', [PayuController::class, 'singlesuccess'])->name('singlepayu.success');
Route::post('/singlepayment/failed', [PayuController::class, 'singlefailed'])->name('singlepayu.failed');
