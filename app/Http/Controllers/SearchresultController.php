<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Session;
use DB;
use App\Models\UserResultProduct;

class SearchresultController extends Controller
{ 

  public function logintenderresults(){
        if(Auth::check()){
         $page = "tenderresultlisting";
         //return view('bid-tender-info-backend',compact('page'));
         $allEvents = array();
         return view('backend.result-search',compact('allEvents','page'));
        }else{  // not set login session 
             //return redirect()->back();
             return redirect('login');
        }
    }
    public function searchresults() 
    {   
        $keyword = '';
        if(isset($_GET['searchbox'])){
            $keyword = trim($_GET['searchbox']);
            $exactkeyword = trim($_GET['searchbox']);
            $keyword = str_replace(' ','-',$keyword);
        }
        $keyword = strtolower($keyword);
        return redirect('/search-result/'.$keyword);
    }
    public function searchresultkeyword($id = null){
        
        $keyword = preg_replace('/[^a-z A-Z 0-9]/', ' ', $id); 
        $type = 'keyword';
        $list_user = new UserResultProduct;
        $models = $list_user->actionGettendersdata($keyword,$type);
        
        $allEvents = $models['dataTender'];
        // dd($models);
        $total = $models['datatendercount'];

        $keyword = $models['keyword'];
        $state_data = DB::table('state')->where('countryid',356)->where('id', '<>' , 380017)->get();
        $department_data = DB::table('agency')
            ->where('agencyid', '<>' , 148261)
            ->get();
        return view('search-result',compact('allEvents','total','keyword','type','state_data','department_data'));
        // return view('search-result');
    }
    public function tenderresultview($id){ 
        $id = preg_replace('/[^0-9]/', '', $id);
        $id = trim($id);
        $dataArr = array();
        $userproduct = new UserResultProduct;
        $dataArr = $userproduct->tenderresultdetails($id);
        $data = $dataArr['data']; // actual model
        $keywords = $dataArr['keywords']; // keywords
        $tenderstateid = $data->state_id;
        $ntid = $data->id;
        $TenderNo = $data->tender_id;
        // dd($keywords);

        $checkdownload = $userproduct->checktenderresultdownload($tenderstateid);
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
        
        return view('resultdetails',compact('data','keywords','checkdownload','documentlink','tenderdocuments','corrigendumhistory','boq_items','boq_items_count','bidderlist'));
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
            return response()->json($data);
        }else {
            $msg = '';
            $data['res1'] = $msg;
            $data['total_count'] = $total_count;
            $data['res2'] = " ";
            return response()->json($data);
        }
        
    }

    //backend code 
     public function backendgettenderresultlist(){
        $stype = 'tenderresultlisting';
        $list_user = new UserResultProduct;
        $result = $list_user->tenderresultsearching($stype);
        //  dd($result);
        $resultdata = $result['resultdata'];
        $total_count = $result['total_count'];
        $livecount = $result['livecount'];
        $userkeyword = $result['userkeyword'];
       
        if(!empty($resultdata)){
            
            $returnhtml = ''; 
            $returnhtml = view('renderfile.backendtenderresult',compact('resultdata','userkeyword'))->render(); 
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

    public function backendtenderresultview(){ 
        $sid = $_GET['id'];
        $sid= trim($sid);
        $id = base64_decode($sid);
        
        $data = array();
        $userproduct = new UserResultProduct;
        $dataArr = $userproduct->tenderresultdetails($id);
        $data = $dataArr['data']; // actual model
        $keywords = $dataArr['keywords']; // keywords
        $tenderstateid = $data->state_id;
        $ntid = $data->id;
        $TenderNo = $data->tender_id;
        $checkdownload = $userproduct->checktenderresultdownload($tenderstateid);
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
        
        
        return view('backend.resultdetails',compact('data','checkdownload','documentlink','tenderdocuments','corrigendumhistory','boq_items','boq_items_count','bidderlist'));
    }
}