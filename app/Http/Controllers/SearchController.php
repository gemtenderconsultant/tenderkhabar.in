<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use App\Models\UserProduct;
class SearchController extends Controller
{
    //home page ma je keywork search kari 6e a ne redireact kar 6e search-tender view file ne 
    public function searchtenders()
    {   
        $keyword = '';
        if(isset($_GET['searchbox'])){
            $keyword = trim($_GET['searchbox']);
            $exactkeyword = trim($_GET['searchbox']);
            $keyword = str_replace(' ','-',$keyword);
        }
        $keyword = strtolower($keyword);
        return redirect('/search-tender/'.$keyword);
    }
    // search tender file a seachkeyword ne call kare 6e and data lavi ne send kare 6e 
    public function searchkeyword($id = null){
        $keyword = preg_replace('/[^a-z A-Z 0-9]/', ' ', $id); 
        $type = 'keyword';
        $list_user = new UserProduct;
        $models = $list_user->actionGettendersdata($keyword,$type);
        // //dd($models);
        $allEvents = $models['dataTender'];
        $total = $models['datatendercount'];
        $keyword = $models['keyword'];
        $state_data = DB::table('state')
            ->where('countryid',356)
            ->where('id', '<>' , 380017)
            ->get();
        $department_data = DB::table('agency')
            ->where('agencyid', '<>' , 148261)
            ->get();
       
        return view('search-tender',compact('allEvents','total','keyword','type','state_data','department_data'));
    }
    //search tender ma filter mate use thay 6e 
    public function gettenderslist(){
        
        $stype = 'searching';
        $list_user = new UserProduct;
        $result = $list_user->tendersearching($stype);
        // dd($result);
        $resultdata = $result['resultdata'];
        $total_count = $result['total_count'];
        $livecount = $result['livecount'];
        $userkeyword = $result['userkeyword'];
       	// print_r($resultdata);die();
        if(!empty($resultdata)){
            $returnhtml = '';
            $returnhtml = view('renderfile.frontendtenderview',compact('resultdata','userkeyword'))->render(); 
            $returnhtml = mb_convert_encoding($returnhtml, "UTF-8", "auto");
             
            $data['res1'] = $returnhtml;
            $data['total_count'] = $total_count;
            $data['res2'] = $total_count;
            return response()->json($data);
        }else {
            $msg = '';
            $data['res1'] = $msg;
            $data['total_count'] = $total_count;
            $data['res2'] = " ";
            return response()->json($data);
        }
        
    }
    
    public function tenderdetail($id){ 
       $id = preg_replace('/[^0-9]/', '', $id);
        $id = trim($id);
        
        $data = array();
        $userproduct = new UserProduct;
        $data = $userproduct->tenderdetails($id);
        $tenderstateid = $data->stateid;
        $ntid = $data->ourrefno;
        $TenderNo = $data->TenderNo;
        
        $stateAccess = $userproduct->checktenderdownload($tenderstateid);
        /* NEW CONDITION (user + tender wise payment) */
        $userTenderAccess = false;

        if (Auth::check()) {
            $userTenderAccess = DB::table('tender_user_access')
                ->where('user_id', Auth::id())
                ->where('tender_id', $id)
                ->where('is_download', 1)
                ->exists();
        }
$isLoggedIn = Auth::check();
        /* ✅ ANY ONE TRUE → ALLOW DOWNLOAD */
        $checkdownload['is_download'] = 0;

        /* 🔹 SINGLE TENDER ACCESS */
        if ($userTenderAccess) {
            $checkdownload['is_download'] = 1;
        }

        /* 🔹 PLAN BASED ACCESS (State / Dept / Keyword) */
        if (
                isset($stateAccess) &&
                ($stateAccess['is_download'] ?? 0) == 1
            ) {
                $checkdownload['is_download'] = 1;
            }
        $documentlink = array();
        $tenderdocuments = array();
        $corrigendumhistory = array();
        $boq_items = array();
        $boq_items_count = array();
        if($checkdownload['is_download'] == 1){
            $documentlink = DB::table('tbl_document_links')->first();
            $tenderdocuments = DB::table('tender_doc')->where('ourrefno',$ntid)->get();
            if(Auth::check()){
                $corrigendumhistory = DB::table('corrigendum_history')->where('TenderNo',$TenderNo)->get();
            }
        }
        $boq_items = array();
        $boq_items = DB::table('tenderinfo_items')->where('ourrefno',$ntid)->limit(5)->get();
        $boq_items_count = array();
        if(count($boq_items) > 0){
          $boq_items_count = DB::table('tenderinfo_items')->select(DB::raw('COUNT(*) as totalitem'),DB::raw('SUM(quantity) as totalqty'))->where('ourrefno',$ntid)->first();  
        }
        return view('tenderdetails',compact('data','checkdownload','documentlink','tenderdocuments','corrigendumhistory','boq_items','boq_items_count','isLoggedIn'));
    }

    public function backendgettenderslist(){
        $stype = 'tenderlisting';
        $list_user = new UserProduct;
        $result = $list_user->tendersearching($stype);
        // dd($result);
        $resultdata = $result['resultdata'];
        $total_count = $result['total_count'];
        $livecount = $result['livecount'];
        $userkeyword = $result['userkeyword'];
       
        if(!empty($resultdata)){
            $returnhtml = '';
            $returnhtml = view('renderfile.backendtenderview',compact('resultdata','userkeyword'))->render(); 
            $returnhtml = mb_convert_encoding($returnhtml, "UTF-8", "auto");
            
            $data['res1'] = $returnhtml;
            $data['total_count'] = $total_count;
            $data['res2'] = $total_count;
            return response()->json($data);
        }else {
            $msg = '';
            $data['res1'] = $msg;
            $data['total_count'] = $total_count;
            $data['res2'] = "";
            //echo json_encode($data);
            return response()->json($data);
        }
    }

    public function backendtenderview(){ 
        
        if(Auth::check()){
            $sid = $_GET['id'];
            $sid= trim($sid);
             $id = base64_decode($sid);
            $data = array();
            $userproduct = new UserProduct;
            $data = $userproduct->tenderdetails($id);
            
            $tenderstateid = $data->stateid;
            $ntid = $data->ourrefno;
            $TenderNo = $data->TenderNo;
            $stateAccess = $userproduct->checktenderdownload($tenderstateid);
        
             /* NEW CONDITION (user + tender wise payment) */
            $userTenderAccess = DB::table('tender_user_access')
                ->where('user_id', Auth::id())
                ->where('tender_id', $id)
                ->where('is_download', 1)
                ->exists();
        
        /* ✅ ANY ONE TRUE → ALLOW DOWNLOAD */
        $checkdownload['is_download'] = 0;

        /* 🔹 SINGLE TENDER ACCESS */
        if ($userTenderAccess) {
            $checkdownload['is_download'] = 1;
        }

        /* 🔹 PLAN BASED ACCESS (State / Dept / Keyword) */
        if (isset($stateAccess) && ($stateAccess['is_download'] ?? 0) == 1) {
                $checkdownload['is_download'] = 1;
        }
            $documentlink = array();
            $tenderdocuments = array();
            $corrigendumhistory = array();
            if($checkdownload['is_download'] == 1){
                $documentlink = DB::table('tbl_document_links')->first();
                $tenderdocuments = DB::table('tender_doc')->where('ourrefno',$ntid)->get();
           
                if(Auth::check()){
                    $corrigendumhistory = DB::table('corrigendum_history')->where('TenderNo',$TenderNo)->get();
                }
            }
            $boq_items = array();
            $boq_items = DB::table('tenderinfo_items')->where('ourrefno',$ntid)->limit(5)->get();
            $boq_items_count = array();
            if(count($boq_items) > 0){
              $boq_items_count = DB::table('tenderinfo_items')->select(DB::raw('COUNT(*) as totalitem'),DB::raw('SUM(quantity) as totalqty'))->where('ourrefno',$ntid)->first();  
            }
            
            return view('backend.tenderdetails',compact('data','checkdownload','documentlink','tenderdocuments','corrigendumhistory','boq_items','boq_items_count'));
        }else{
            return redirect('/login');
        }
    }

    public function state(){
       $query = request()->input('state'); // form માંથી આવેલ value
        if($query != ""){
            $state_data = DB::table('state')
                    ->where('countryid', 356)
                    ->where('id', '<>', 380017)
                    ->when($query, function ($state) use ($query) {
                        $state->where('name', 'LIKE', "%{$query}%");
                    })
                    ->get();
        }else{
            $state_data = DB::table('state')
                ->where('countryid',356)
                ->where('id', '<>' , 380017)
                ->get();
        }
       return view('view-all-state', compact('state_data'));
    }

    public function statesearch() {
        $id = '';
        if(isset($_GET['searchbox'])){
            $id = trim($_GET['searchbox']);
            $id = $id;
        }
        $id = strtolower($id);
        return redirect('/stateresult/'.$id);
    }

    public function stateresult($id = null) {
        $id = $id;
        $type = 'state';
        $list_user = new UserProduct;
        $models = $list_user->statesearching($id,$type);
        // dd($models);
        $allEvents = $models['dataTender'];
        $total = $models['datatendercount'];
        $statename = $models['selectedstatename'];
        $state_data = DB::table('state')
            ->where('countryid',356)
            ->where('id', '<>' , 380017)
            ->get();

        $department_data = DB::table('agency')
            ->where('agencyid', '<>' , 148261)
            ->get();
        return view('stateresult',compact('allEvents','total','type','statename','state_data','department_data'));;

    }

    public function category(){
        $query = request()->input('category'); // form માંથી આવેલ value
        if($query != ""){
            $category_data = DB::table('keyword')
            ->where('id', '<>' , 19646)
            ->when($query, function ($category) use ($query) {
                $category->where('name', 'LIKE', "%{$query}%");
            })
            ->get();
            
        }else{
            $category_data = DB::table('keyword')
            ->where('id', '<>' , 19646)
            ->get();
        }
       return view('view-all-categories', compact('category_data'));
    }

    public function categorysearch() {
        $id = '';
        if(isset($_GET['searchbox'])){
            $id = trim($_GET['searchbox']);
            $exactkeyword = trim($_GET['searchbox']);
            $id = str_replace(' ','-',$id);;
        }
        $id = strtolower($id);
        return redirect('/categoryresult/'.$id);
    }

    public function categoryresult($id = null) {
        $id = preg_replace('/[^a-z A-Z 0-9]/', ' ', $id); 
        $type = 'keyword';
        $list_user = new UserProduct;
        $models = $list_user->statesearching($id,$type);
        // dd($models);
        $allEvents = $models['dataTender'];
        $total = $models['datatendercount'];
        $category = $models['keyword'];

        $state_data = DB::table('state')
            ->where('countryid',356)
            ->where('id', '<>' , 380017)
            ->get();
        $department_data = DB::table('agency')
            ->where('agencyid', '<>' , 148261)
            ->get();
        return view('categoryresult',compact('allEvents','total','type','category','state_data','department_data'));;

    }

    public function authorities(){
        $query = request()->input('agency'); // form માંથી આવેલ value
        if($query != ""){
            $authorities_data = DB::table('agency')
                ->where('agencyid', '<>' , 148261)
                ->when($query, function ($agency) use ($query) {
                    $agency->where('agencyname', 'LIKE', "%{$query}%");
                })
                ->get();
        }
        else{
            $authorities_data = DB::table('agency')
            ->where('agencyid', '<>' , 148261)
            ->get();
        }
            // dd($authorities_data);
         
       return view('view-all-authorities', compact('authorities_data'));
    }

    public function authoritiessearch() {
        $id = '';
        if(isset($_GET['searchbox'])){
            $id = trim($_GET['searchbox']);
            $id = $id;
        }
        $id = strtolower($id);
        return redirect('/authoritiesresult/'.$id);
    }

    public function authoritiesresult($id = null) {
        $id = $id;
        $type = 'agency';
        $list_user = new UserProduct;
        $models = $list_user->statesearching($id,$type);
        // dd($models);
        $allEvents = $models['dataTender'];
        $total = $models['datatendercount'];
        $agencyname = $models['selectedagencyname'];
        $state_data = DB::table('state')
            ->where('countryid',356)
            ->where('id', '<>' , 380017)
            ->get();
        $department_data = DB::table('agency')
            ->where('agencyid', '<>' , 148261)
            ->get();
        return view('authoritiesresult',compact('allEvents','total','type','agencyname','state_data','department_data'));

    }

    public function getadvance(){
            $state_data = DB::table('state')
                  ->where('countryid',356)->where('id', '<>' , 380017)
                  ->get();
            $authorities_data = DB::table('agency')
            ->where('agencyid', '<>' , 148261)
            ->get();
            if ($state_data) {
                return response()->json([
                    'status' => 'success',
                    'data' => $state_data,
                    'agency' => $authorities_data
                ]);
            }
            return response()->json([
                'status' => 'error'
            ]);
    }

    public function postadvancesearch(Request $request,$id = null){
        $keyword = "";
        if($request->has('keyword') && $request->get('keyword') != ""){
            $keyword = $request->get('keyword');
        }

        $within_search = "";
        if($request->has('search') && $request->get('search') != ""){
            $within_search = $request->get('search');
        }
        $selecetd_state = "";
        $selecetd_city_data = "";
        if($request->has('state')){
            $selecetd_state = $request->get('state');
            $selecetd_city_data = DB::table('city')
                    ->select('id','name')
                    ->wherein('state_id',$request->state)->get();        
        }
        $selected_city = "";
        if($request->has('city')){
            $selected_city = $request->get('city');
        }
        $selecetd_min_amount = "";
        if($request->has('min_amount')){
            $selecetd_min_amount = $request->get('min_amount');
        }

        $selecetd_max_amount = "";
        if($request->has('max_amount')){
            $selecetd_max_amount = $request->get('max_amount');
        }

        $selecetd_estimate_values = "";
        if($request->has('estimate_values')){
            $selecetd_estimate_values = $request->get('estimate_values');
        }
        $selecetd_gcid = "";
        if($request->has('ntid')){
            $selecetd_gcid = $request->get('ntid');
        }
       
        $state_data = DB::table('state')
            ->where('countryid',356)
            ->where('id', '<>' , 380017)
            ->get();
        $department_data = DB::table('agency')
            ->where('agencyid', '<>' , 148261)
            ->get();
        $selecetd_agency_data = "";
        if($request->has('agency') && !empty($request->agency)){
            $selecetd_agency_data = DB::table('agency')
                    ->select('agencyid','agencyname')
                    ->wherein('agencyid',$request->agency)->get();        
        }    
        $page = "advancesearch";
        return view('search-tender',compact('keyword','state_data','within_search','selecetd_state','selecetd_min_amount','selecetd_max_amount','selecetd_estimate_values','selecetd_agency_data','department_data','selecetd_gcid','keyword','selecetd_city_data','selected_city','page'));
    }
}
