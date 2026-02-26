<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use Auth;
use DataTables;
use DB;
use Redirect;
use App\Models\UserProduct;
class TenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if(Auth::check()){
            $users = User::latest()->paginate(5);
            return view('admin.users.index',compact('users'))->with('i', (request()->input('page', 1) - 1) * 5);
        }else{
             return redirect()->back();
        }
    }
    
    public function emailTenderDetails(){ 
        
        //echo base64_encode(Auth::user()->user_id); die();
        //$id = preg_replace('/[^0-9]/', '', $id);
        //$id = trim($id);
        $sid = $_GET['tid'];
        $sid= trim($sid);
        $id = base64_decode($sid);
        
        $uid = $_GET['uid'];
        $uid= trim($uid);
        $userid = base64_decode($uid);
        
        $data = array();
        $userproduct = new UserProduct;
        $data = $userproduct->tenderdetails($id);

        $tenderstateid = $data->stateid;
        $ntid = $data->ourrefno;
        $TenderNo = $data->TenderNo;
        $checkdownload = $userproduct->checkemailtenderdownload($tenderstateid,$userid);
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
        return view('tenderview',compact('data','checkdownload','documentlink','tenderdocuments','corrigendumhistory','boq_items','boq_items_count'));
    }

    public function favoritetender(Request $request){
        $user = Auth::user();
        $user_id = $user->user_id;
        $id = $request->get('id');
        $fclass = $request->get('fclass');
        $fclass = trim($fclass);
        if(Session::has('favouritetenders')){
            
            $myfavourite = Session::get('favouritetenders');
            if($fclass == "fa-regular fa-heart"){
                Session::push('favouritetenders', $id);
                $datainsert = [
                    'tender_id' => $id,
                    'user_id' => $user_id,
                    'flag' => 1,
                    'insert_date_time' => date('Y-m-d H:i:s')
                
                 ];
                $tid = DB::table('tenderlike')->insertGetId($datainsert);
                
                $msg = "Added Successfully!";
            }else{
                $key = array_search($id, $myfavourite);
                Session::forget('favouritetenders.'.$key);
                Tenderlike::where('user_id',$user->user_id)->where('tender_id',$id)->delete();
                $msg = "Remove Successfully!";
            }
        }else{
            $tenderfavourite = array();
            $tenderfavourite[0] = $id;
            $request->session()->put('favouritetenders',$tenderfavourite);
            $datainsert = [
                'tender_id' => $id,
                'user_id' => $user_id,
                'flag' => 1,
                'insert_date_time' => date('Y-m-d H:i:s')
            
             ];
            $tid = DB::table('tenderlike')->insertGetId($datainsert);
            $msg = "Added Successfully!";
        }
        return response()->json(
                            ['status'=> 'success',
                             'msg' => $msg]);
    }
}