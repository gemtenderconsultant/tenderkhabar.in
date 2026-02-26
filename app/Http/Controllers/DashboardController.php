<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Session;
use DB;
use App\Models\UserProduct;
class DashboardController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function actiondashboard2()
    {   
        return view('backend.dashboard');
    }
    public function getdatadashboard($filename){
         header('Content-Type: application/json');
         $str = file_get_contents('user_login/'.$filename);
         $json = json_decode($str, true);
         return $json;
    }
    public function setdatadashboard(){
        $stype = 'dashboard';
        $list_user = new UserProduct;
        $result = $list_user->tendersearching($stype);
        $totallive = $result['resultdata'][0]->totallive;
        $totalfresh = $result['resultdata'][0]->totalfresh;
        
        $user = Auth::user();
        $userID = $user->id;
        $tendertodate = Session::get('tendertodate');
        $filename = $userID.".json";
        
        $posts = array();  
        $posts['totallive'] = $totallive;
        $posts['totalfresh'] = $totalfresh;
        $posts['tendertodate'] = $tendertodate;
        
        $fp = fopen('user_login/'.$filename, 'w');
        fwrite($fp, json_encode($posts));
        fclose($fp);
    }
    public function actiondashboard()
    {   
        if(!auth::check()){
            return view('auth/login');
        }else{    

        $list_user = new UserProduct;
        $user = Auth::user();
        $userID = $user->id;
        $filename = $userID.".json";
        if (!file_exists('user_login/'.$filename)) { 
                
            $this->setdatadashboard();
            $json = $this->getdatadashboard($filename);
            
        }else{
            date_default_timezone_set('Asia/Kolkata');
            //$filetime =  "$filename was last modified: " . date ("m d Y H:i:s", filemtime('user_login/'.$filename));
            $filedate = date("Y-m-d", filemtime('user_login/'.$filename));
            $filetime = date("H:i:s", filemtime('user_login/'.$filename));
            $today_date = date('Y-m-d');
            $prev_date = date('Y-m-d', strtotime('-1 day'));
           
            if($filedate >= $prev_date && $filedate <= $today_date){
                $current_time = date('H:i:s');
                if($filedate == $prev_date){
                    
                    if($current_time < "10:00:00"){
                            $json = $this->getdatadashboard($filename);
                        }else{
                            $this->setdatadashboard();
                            $json = $this->getdatadashboard($filename);
                        }
                }else{
                    if($current_time > "10:00:00" && $filetime >= "10:00:00"){
                      
                        $json = $this->getdatadashboard($filename);
                        
                    }else{
                        
                        if($current_time < "10:00:00"){
                            $json = $this->getdatadashboard($filename);
                            
                        }else{
                            $this->setdatadashboard();
                            $json = $this->getdatadashboard($filename);
                        }
                    }
                }
            }else{
                $this->setdatadashboard();
                $json = $this->getdatadashboard($filename);
            }
        }
       
        $totallive = $json['totallive'];
        $totalfresh = $json['totalfresh'];
        $tendertodate = $json['tendertodate'];
        return view('backend.dashboard',compact('totallive','totalfresh','tendertodate'));
        }
    }

    public function actiontenderresult(Request $request)
    {   
         if(Auth::check()){
         $page = "tenderlisting";
         //return view('bid-tender-info-backend',compact('page'));
         $allEvents = array();
         //return view('backend.tender-result');
         return view('backend.tender-result',compact('allEvents','page'));
        }else{  // not set login session 
             //return redirect()->back();
             return redirect('login');
        }
    }
}
