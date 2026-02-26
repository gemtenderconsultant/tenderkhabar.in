<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Session;
use DB;
use App\Models\UserResultProduct;

class SearchresultController extends Controller
{   
    public function searchresult() 
    {   

        $keyword = '';
        if(isset($_GET['searchbox'])){
            $keyword = trim($_GET['searchbox']);
            $exactkeyword = trim($_GET['searchbox']);
            $keyword = str_replace(' ','-',$keyword);
        }
        $keyword = strtolower($keyword);
        return redirect('/searchresult/'.$keyword);
    }
    
    public function searchresultkeyword($id = null){
        
        $keyword = preg_replace('/[^a-z A-Z 0-9]/', ' ', $id); 
        $type = 'keyword';
        $list_user = new UserResultProduct;
        $models = $list_user->actionGettendersdata($keyword,$type);
        
        $allEvents = $models['dataTender'];
        //dd($allEvents);
        $total = $models['datatendercount'];

        $keyword = $models['keyword'];
        /*$selectedstateid = $models['selectedstateid'];
        $selectedstatename = $models['selectedstatename'];
        $userloginData = $models['userproduct'];*/
        $state_data = DB::table('state')->where('countryid',356)->where('id', '<>' , 380017)->get();

        return view('bid-result-info-frontend',compact('allEvents','total','keyword','type','state_data'));
    }
    public function searchresultagency($id = null){
        $keyword = preg_replace('/[^a-z A-Z 0-9]/', ' ', $id); 
        $type = 'agency';
        $list_user = new UserResultProduct;
        $models = $list_user->actionGettendersdata($keyword,$type);
        $allEvents = $models['dataTender'];
        $total = $models['datatendercount'];
        $keyword = $models['keyword'];
        /*$selectedstateid = $models['selectedstateid'];
        $selectedstatename = $models['selectedstatename'];
        $userloginData = $models['userproduct'];*/
        $selectedagencyid = $models['selectedagencyid'];
        $selectedagencyname = $models['selectedagencyname'];
        
        return view('bid-result-info-frontend',compact('allEvents','total','keyword','type','selectedagencyid','selectedagencyname'));
    }
    public function searchresultstate($id = null){
        $keyword = preg_replace('/[^a-z A-Z 0-9]/', ' ', $id); 
        $type = 'state';
        $list_user = new UserResultProduct;
        $models = $list_user->actionGettendersdata($keyword,$type);
        $allEvents = $models['dataTender'];
        $total = $models['datatendercount'];
        $keyword = $models['keyword'];
        $selectedstateid = $models['selectedstateid'];
        $selectedstatename = $models['selectedstatename'];
        //$userloginData = $models['userproduct'];
        
        return view('bid-result-info-frontend',compact('allEvents','total','keyword','type','selectedstateid','selectedstatename'));
    }
    public function searchresultcategory($id = null){
        $keyword = preg_replace('/[^a-z A-Z 0-9]/', ' ', $id); 
        $type = 'category';
        $list_user = new UserResultProduct;
        $models = $list_user->actionGettendersdata($keyword,$type);
        
        $allEvents = $models['dataTender'];
        $total = $models['datatendercount'];
        $keyword = $models['keyword'];
        /*$selectedstateid = $models['selectedstateid'];
        $selectedstatename = $models['selectedstatename'];
        $userloginData = $models['userproduct'];
        $selectedagencyid = $models['selectedagencyid'];
        $selectedagencyname = $models['selectedagencyname'];*/
        $selectedcategoryid = $models['selectedcategoryid'];
        $selectedcategoryname = $models['selectedcategoryname'];
        
        return view('bid-result-info-frontend',compact('allEvents','total','keyword','type','selectedcategoryid','selectedcategoryname'));
    }
    public function searchresultsubcategory($id = null){
        $keyword = preg_replace('/[^a-z A-Z 0-9]/', ' ', $id); 
        $type = 'subcategory';
        $list_user = new UserResultProduct;
        $models = $list_user->actionGettendersdata($keyword,$type);
        
        $allEvents = $models['dataTender'];
        $total = $models['datatendercount'];
        $keyword = $models['keyword'];
        /*$selectedstateid = $models['selectedstateid'];
        $selectedstatename = $models['selectedstatename'];
        $userloginData = $models['userproduct'];
        $selectedagencyid = $models['selectedagencyid'];
        $selectedagencyname = $models['selectedagencyname'];*/
        $selectedcategoryid = $models['selectedcategoryid'];
        $selectedcategoryname = $models['selectedcategoryname'];
        $selectedsubcategoryid = $models['selectedsubcategoryid'];
        $selectedsubcategoryname = $models['selectedsubcategoryname'];
        
        return view('bid-result-info-frontend',compact('allEvents','total','keyword','type','selectedcategoryid','selectedcategoryname','selectedsubcategoryid','selectedsubcategoryname'));
    }
    public function searchresultcity($id = null){
        $keyword = preg_replace('/[^a-z A-Z 0-9]/', ' ', $id); 
        $type = 'city';
        $list_user = new UserResultProduct;
        $models = $list_user->actionGettendersdata($keyword,$type);
        
        $allEvents = $models['dataTender'];
        $total = $models['datatendercount'];
        $keyword = $models['keyword'];
        $selectedstateid = $models['selectedstateid'];
        $selectedstatename = $models['selectedstatename'];
        $selectedcityname = $models['selectedcity'];
        $selectedcityid = $models['selectedcityid'];
        
        
        //$userloginData = $models['userproduct'];
        
        return view('bid-result-info-frontend',compact('allEvents','total','keyword','type','selectedstateid','selectedstatename','selectedcityname','selectedcityid'));
    }
    public function gettenderresultslist(){
        
        $stype = 'searching';

        $list_user = new UserResultProduct;
        $result = $list_user->tenderresultsearching($stype);
        $resultdata = $result['resultdata'];
        $total_count = $result['total_count'];
        $livecount = $result['livecount'];
        $userkeyword = $result['userkeyword'];
       
        if(!empty($resultdata)){
            $returnhtml = '';
            $returnhtml = view('renderfile.frontendtenderresultview',compact('resultdata','userkeyword'))->render(); 
            $returnhtml = mb_convert_encoding($returnhtml, "UTF-8", "auto");
            
            $data['res1'] = $returnhtml;
            $data['total_count'] = $total_count;
            $data['res2'] = $total_count;
            //echo json_encode($data);
            return response()->json($data);
        }else {
            $msg = '';
            $data['res1'] = $msg;
            $data['total_count'] = $total_count;
            $data['res2'] = " ";
            //echo json_encode($data);
            return response()->json($data);
        }
        
    }
    
    public function logintenderresults(){
        if(Auth::check()){
         $page = "tenderresultlisting";
         //return view('bid-tender-info-backend',compact('page'));
         $allEvents = array();
         return view('backend.bid-result-info-backend',compact('allEvents','page'));
        }else{  // not set login session 
             //return redirect()->back();
             return redirect('login');
        }
    }
    public function backendgettenderresultlist(){
        $stype = 'tenderresultlisting';
        $list_user = new UserResultProduct;
        $result = $list_user->tenderresultsearching($stype);
        
        $resultdata = $result['resultdata'];
        $total_count = $result['total_count'];
        $livecount = $result['livecount'];
        $userkeyword = $result['userkeyword'];
       
        if(!empty($resultdata)){
            
            //dd($resultdata);
            $returnhtml = ''; 
            $returnhtml = view('renderfile.backendtenderresultview',compact('resultdata','userkeyword'))->render(); 
            //dd($returnhtml);
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
            //echo json_encode($data);
            return response()->json($data);
        }
        
    }
    public function tenderresultview($id){ 
        
        $id = preg_replace('/[^0-9]/', '', $id);
        $id = trim($id);
        
        $data = array();
        $userproduct = new UserResultProduct;
        $data = $userproduct->tenderresultdetails($id);
        $tenderstateid = $data->state_id;
        $ntid = $data->id;
        $TenderNo = $data->tender_id;
        //dd($data);
        //$user = Auth::user();
        //$status = $user->status;
        //$usertype = $user->user_active_indicator;
        //$T = $user->tenderuser;
        //$W = $user->workuser;
        //$R = $user->result_user;
        // if(Session::has('tendertodate')){
        //     $tendertodate = Session::get('tendertodate');
        // }
        // if(Session::has('tenderresulttodate')){
        //   $tenderresulttodate = Session::get('tenderresulttodate');
        // }
        $checkdownload = $userproduct->checktenderresultdownload($tenderstateid);
        //$sqlboq_items = "SELECT * FROM `tenderinfo_items` WHERE ourrefno='$id' LIMIT 5";
        //$sqlboq_items_count = "SELECT COUNT(*) as totalitem,SUM(quantity) as totalqty FROM `tenderinfo_items` WHERE ourrefno=$id";
        //$TenderNo = $model[0]['TenderNo'];
        //$TenderNo = "2021_HSL_87177_1";
        //$sql_corridetail = "SELECT * FROM corrigendum_history WHERE TenderNo='$TenderNo'";
        /*$sql_checkdocument = "SELECT * FROM tbl_document_links";
        $command = $connection->createCommand($sql_checkdocument);
        $dataReader = $command->query();
        $data_check = $dataReader->readAll();
        $documentcheckdate = $data_check[0]['date'];
        $documentcheckpath = $data_check[0]['url'];*/
        $documentlink = array();
        $tenderdocuments = array();
        $corrigendumhistory = array();
        $boq_items = array();
        $boq_items_count = array();
        
        /*if($checkdownload['is_download'] == 1){
            $documentlink = DB::table('tbl_document_links')->first();
            $tenderdocuments = DB::table('tender_doc')->where('ourrefno',$ntid)->get();
       
            if(Auth::check()){
                $corrigendumhistory = DB::table('corrigendum_history')->where('TenderNo',$TenderNo)->get();
            }
        }
        
        $boq_items = DB::table('tenderinfo_items')->where('ourrefno',$ntid)->limit(5)->get();
        if(count($boq_items) > 0){
          $boq_items_count = DB::table('tenderinfo_items')->select(DB::raw('COUNT(*) as totalitem'),DB::raw('SUM(quantity) as totalqty'))->where('ourrefno',$ntid)->first();  
        }*/
        $bidderlist = array();
        if($checkdownload['is_download'] == 1){
            $documentlink = DB::table('tbl_document_result_links')->first();
        $bidderlist = DB::table('tender_result_bidder')->where('tender_id',$TenderNo)->get();
        }
        
        return view('tenderresultview',compact('data','checkdownload','documentlink','tenderdocuments','corrigendumhistory','boq_items','boq_items_count','bidderlist'));
    }
    
    public function backendtenderresultview(){ 
        
        //$id = preg_replace('/[^0-9]/', '', $id);
        //$id = trim($id);
        $sid = $_GET['id'];
        $sid= trim($sid);
        $id = base64_decode($sid);
        
        $data = array();
        $userproduct = new UserResultProduct;
        $data = $userproduct->tenderresultdetails($id);

        $tenderstateid = $data->state_id;
        $ntid = $data->id;
        $TenderNo = $data->tender_id;
        $checkdownload = $userproduct->checktenderresultdownload($tenderstateid);
        $documentlink = array();
        $tenderdocuments = array();
        $corrigendumhistory = array();
        $boq_items = array();
        $boq_items_count = array();
        
        /*if($checkdownload['is_download'] == 1){
            $documentlink = DB::table('tbl_document_links')->first();
            $tenderdocuments = DB::table('tender_doc')->where('ourrefno',$ntid)->get();
       
            if(Auth::check()){
                $corrigendumhistory = DB::table('corrigendum_history')->where('TenderNo',$TenderNo)->get();
            }
        }
        $boq_items = DB::table('tenderinfo_items')->where('ourrefno',$ntid)->limit(5)->get();
        if(count($boq_items) > 0){
          $boq_items_count = DB::table('tenderinfo_items')->select(DB::raw('COUNT(*) as totalitem'),DB::raw('SUM(quantity) as totalqty'))->where('ourrefno',$ntid)->first();  
        }*/
        
        //dd($TenderNo);
        $bidderlist = array();
        if($checkdownload['is_download'] == 1){
            $documentlink = DB::table('tbl_document_result_links')->first();
            $bidderlist = DB::table('tender_result_bidder')->where('tender_id',$TenderNo)->get();
        }
        
        
        return view('backend.result-listing-paid-user',compact('data','checkdownload','documentlink','tenderdocuments','corrigendumhistory','boq_items','boq_items_count','bidderlist'));
    }
    
    public function bidbackendtenderview(){ 
        
        //$id = preg_replace('/[^0-9]/', '', $id);
        //$id = trim($id);
        $sid = $_GET['id'];
        $sid= trim($sid);
        $id = base64_decode($sid);
        
        $data = array();
        $userproduct = new UserProduct;
        $data = $userproduct->bidtenderdetails($id);

        $tenderstateid = $data->stateid;
        $ntid = $data->ourrefno;
        $TenderNo = $data->TenderNo;
        $checkdownload = $userproduct->checktenderdownload($tenderstateid);
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
        //dd($data);
        return view('backend.tender-listing-paid-user',compact('data','checkdownload','documentlink','tenderdocuments','corrigendumhistory','boq_items','boq_items_count'));
    }
    public function emailTenderresult(){ 
        
        $sid = $_GET['tid'];
        $sid= trim($sid);
        $id = base64_decode($sid);
    
        $uid = $_GET['uid'];
        $uid= trim($uid);
        $userid = base64_decode($uid);
        
        //$id = preg_replace('/[^0-9]/', '', $id);
        //$id = trim($id);
        
        $data = array();
        $userproduct = new UserResultProduct;
        $data = $userproduct->tenderresultdetails($id);
        $tenderstateid = $data->state_id;
        $ntid = $data->id;
        $TenderNo = $data->tender_id;
       
        $checkdownload = $userproduct->checkemailtenderresultdownload($tenderstateid,$userid);
        $documentlink = array();
        $tenderdocuments = array();
        $corrigendumhistory = array();
        $boq_items = array();
        $boq_items_count = array();
       
        $bidderlist = array();
        if($checkdownload['is_download'] == 1){
            $documentlink = DB::table('tbl_document_result_links')->first();
            $bidderlist = DB::table('tender_result_bidder')->where('tender_id',$TenderNo)->get();
        }
        return view('tenderresultview',compact('data','checkdownload','documentlink','tenderdocuments','corrigendumhistory','boq_items','boq_items_count','bidderlist'));
    }
}