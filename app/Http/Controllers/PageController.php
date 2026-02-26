<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Auth;
use DataTables;
use DB;
use Redirect;
use Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class PageController extends Controller
{
  public function aboutus(Request $request){
    return view('about-us');
  }
    
  public function home(){
    $data = DB::table('daily_tender_count')->first();
    //dd($data);
    return view('home',compact('data'));
  }
  
  public function contactus(Request $request){
    return view('contact-us');
  }

  public function services(Request $request){
    return view('services');
  }

  public function privacypolicy(Request $request){
    return view('privacy-policy');
  }

  public function pricingplans(Request $request){
    return view('pricing-plans');
  }
 
  public function gem(Request $request)
  {
    return view('gem');
  }

  public function bidding(Request $request)
  {
    return view('bidding');
  }

  public function certification(Request $request)
  {
    return view('certification');
  }
  
  public function searchresult(Request $request)
  { 
    $state_data = DB::table('state')->where('countryid',356)->get();
    
    return view('search-result',compact('state_data'));
  }
  public function userinquirynew(Request $request){
    if($request->ajax()){
      $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'company_name' => 'required',
        'user_primary_phone' => 'required|numeric|digits:10',
        'email' => 'required|email',
        'looking_for' => 'required',
      ]);
      if($validator->fails()) {
        return Response::json(array(
            'success' => false,
            'errors' => $validator->errors()->toArray()
    
        ), 400);
      }else{
        $check = 0;
        if($request->isMethod('post')){
          $check = 1;
        }
        date_default_timezone_set("Asia/Kolkata");
        $insert_date_time = date("Y-m-d H:i:s", time());
        $ip = $_SERVER['REMOTE_ADDR'];
        $mobile_type = (int) $request->get('user_primary_phone');
        $str_filter = $request->get('name')." ".$request->get('company_name')." ".$request->get('looking_for');
        $detect = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
        $userdetect = $detect ? "Mobile" : "Desktop" ;
    
        if ($check == 1 && $mobile_type != 0 && filter_var($request->get('email'), FILTER_VALIDATE_EMAIL) && strpos($str_filter, 'https://') === false && strpos($str_filter, 'http://') === false && strpos($str_filter, 'sex') === false && strpos($str_filter, 'sex') === false){
          
          DB::table('userserviceinquiry')                
          ->insert([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'looking_for' => preg_replace('/[^a-zA-Z0-9]+/', ' ',$request->get('looking_for')),
            'company_name' => $request->get('company_name'),
            'user_primary_phone' => $request->get('user_primary_phone'),
            'insert_date_time' => $insert_date_time,
            'flag' => $request->get('flag'),
            'user_ip' => $ip, 
            'device_type' => $userdetect, 
          ]);
             try {
              // ✅ First API call
              // $apiResponse1 = Http::asForm()->post('https://bidders365.in/crmnew/api/tenderkhabar_api/', [ 
                 $apiResponse1 = Http::asForm()->post('https://gemtenderconsultant.com/crmnew/api/tenderkhabar_api/', [ 
                  'client_name'    => $request->name,
                  'client_email'   => $request->email,
                  'client_phone'   => $request->user_primary_phone,
                  'client_company' => $request->company_name,
                  'message'        => $request->looking_for,
              ]);

              if (!$apiResponse1->successful()) {
                  return response()->json([
                      'success' => false,
                      'msg'     => 'First API connection failed'
                  ], 500);
              }

              $data1 = $apiResponse1->json();

              if (!isset($data1['status']) || $data1['status'] !== 'success') {
                  return response()->json([
                      'success' => false,
                      'msg'     => $data1['message'] ?? 'First API failed'
                  ], 400);
              }

              // ✅ Second API call (example: sending same or different data)
              $apiResponse2 = Http::asForm()->post('https://www.gemtenderconsultant.in/api/tenderkhabar_api/', [
                  'client_name'    => $request->name,
                  'client_email'   => $request->email,
                  'client_phone'   => $request->user_primary_phone,
                  'client_company' => $request->company_name,
                  'message'        => $request->looking_for,
              ]);

              if (!$apiResponse2->successful()) {
                  return response()->json([
                      'success' => false,
                      'msg'     => 'Second API connection failed'
                  ], 500);
              }

              $data2 = $apiResponse2->json();

              if (!isset($data2['status']) || $data2['status'] !== 'success') {
                  return response()->json([
                      'success' => false,
                      'msg'     => $data2['message'] ?? 'Second API failed'
                  ], 400);
              }

              // ✅ Both APIs succeeded
              return response()->json([
                  'success' => true,
                  'msg'     => 'Inquiry submitted successfully to both APIs!',
                  'first_api'  => $data1,
                  'second_api' => $data2,
              ], 200);

          } 
          catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'msg'     => 'Exception: ' . $e->getMessage()
                ], 500);
            }
          //  return Response::json(array('success' => true,'msg'=>"Your Enquiry has been submitted."), 200);
        }   
      }
    }
  }
  public function sortinquiry(Request $request){
    if($request->ajax()){
      $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'user_primary_phone' => 'required|numeric|digits:10',
        'company_name' => 'required',
        'email' => 'required|email',
        'looking_for' => 'required',
      ]);
      if($validator->fails()) {
        return Response::json(array(
            'success' => false,
            'errors' => $validator->errors()->toArray()
    
        ), 400);
      }else{
        $check = 0;
        if($request->isMethod('post')){
          $check = 1;
        }
        date_default_timezone_set("Asia/Kolkata");
        $insert_date_time = date("Y-m-d H:i:s", time());
        $ip = $_SERVER['REMOTE_ADDR'];
        $mobile_type = (int) $request->get('user_primary_phone');
        $str_filter = $request->get('name');
        $detect = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
        $userdetect = $detect ? "Mobile" : "Desktop" ;
    
        if ($check == 1 && $mobile_type != 0 && strpos($str_filter, 'https://') === false && strpos($str_filter, 'http://') === false && strpos($str_filter, 'sex') === false && strpos($str_filter, 'sex') === false){
          
          DB::table('userserviceinquiry')                
          ->insert([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'looking_for' => preg_replace('/[^a-zA-Z0-9]+/', ' ',$request->get('looking_for')),
            'company_name' => $request->get('company_name'),
            'user_primary_phone' => $request->get('user_primary_phone'),
            'insert_date_time' => $insert_date_time,
            'flag' => $request->get('flag'),
            'user_ip' => $ip, 
            'device_type' => $userdetect, 
          ]);
               try {
              // ✅ First API call
              // $apiResponse1 = Http::asForm()->post('https://bidders365.in/crmnew/api/tenderkhabr_sort_api/', [ 
               $apiResponse1 = Http::asForm()->post('https://gemtenderconsultant.com/crmnew/api/tenderkhabr_sort_api/', [ 
                  'client_name'    => $request->name,
                  'client_email'   => $request->email,
                  'client_phone'   => $request->user_primary_phone,
                  'client_company' => $request->company_name,
                  'message'        => $request->looking_for,
              ]);

              if (!$apiResponse1->successful()) {
                  return response()->json([
                      'success' => false,
                      'msg'     => 'First API connection failed'
                  ], 500);
              }

              $data1 = $apiResponse1->json();

              if (!isset($data1['status']) || $data1['status'] !== 'success') {
                  return response()->json([
                      'success' => false,
                      'msg'     => $data1['message'] ?? 'First API failed'
                  ], 400);
              }

              // ✅ Second API call (example: sending same or different data)
              $apiResponse2 = Http::asForm()->post('https://www.gemtenderconsultant.in/api/tenderkhabr_sort_api/', [
                  'client_name'    => $request->name,
                  'client_email'   => $request->email,
                  'client_phone'   => $request->user_primary_phone,
                  'client_company' => $request->company_name,
                  'message'        => $request->looking_for,
              ]);

              if (!$apiResponse2->successful()) {
                  return response()->json([
                      'success' => false,
                      'msg'     => 'Second API connection failed'
                  ], 500);
              }

              $data2 = $apiResponse2->json();

              if (!isset($data2['status']) || $data2['status'] !== 'success') {
                  return response()->json([
                      'success' => false,
                      'msg'     => $data2['message'] ?? 'Second API failed'
                  ], 400);
              }

              // ✅ Both APIs succeeded
              return response()->json([
                  'success' => true,
                  'msg'     => 'Inquiry submitted successfully to both APIs!',
                  'first_api'  => $data1,
                  'second_api' => $data2,
              ], 200);

          } 
          catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'msg'     => 'Exception: ' . $e->getMessage()
                ], 500);
            }
          //  return Response::json(array('success' => true,'msg'=>"Your Enquiry has been submitted."), 200);
        }   
      }
    }
  }
  public function userinquiry(Request $request){
    if($request->ajax()){
      $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'company_name' => 'required',
        'user_primary_phone' => 'required|numeric|digits:10',
        'email' => 'required|email',
        'looking_for' => 'required',
      ]);

      if($validator->fails()) {
        return Response::json(array(
            'success' => false,
            'errors' => $validator->errors()->toArray()
    
        ), 400);
      }else{
        $check = 0;
        if($request->isMethod('post')){
          $check = 1;
        }
        date_default_timezone_set("Asia/Kolkata");
        $insert_date_time = date("Y-m-d H:i:s", time());
        $ip = $_SERVER['REMOTE_ADDR'];
        $mobile_type = (int) $request->get('user_primary_phone');
        $str_filter = $request->get('name')." ".$request->get('company_name')." ".$request->get('looking_for');
        $detect = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
        $userdetect = $detect ? "Mobile" : "Desktop" ;
    
        if ($check == 1 && $mobile_type != 0 && filter_var($request->get('email'), FILTER_VALIDATE_EMAIL) && strpos($str_filter, 'https://') === false && strpos($str_filter, 'http://') === false && strpos($str_filter, 'sex') === false && strpos($str_filter, 'sex') === false){
          
          DB::table('userserviceinquiry')                
          ->insert([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'looking_for' => preg_replace('/[^a-zA-Z0-9]+/', ' ',$request->get('looking_for')),
            'company_name' => $request->get('company_name'),
            'user_primary_phone' => $request->get('user_primary_phone'),
            'insert_date_time' => $insert_date_time,
            'flag' => $request->get('flag'),
            'user_ip' => $ip, 
            'device_type' => $userdetect, 
          ]);
          try {
              // ✅ First API call
              // $apiResponse1 = Http::asForm()->post('https://bidders365.in/crmnew/api/tenderkhabar_api/', [ 
              $apiResponse1 = Http::asForm()->post('https://gemtenderconsultant.com/crmnew/api/tenderkhabar_api/', [ 
                  'client_name'    => $request->name,
                  'client_email'   => $request->email,
                  'client_phone'   => $request->user_primary_phone,
                  'client_company' => $request->company_name,
                  'message'        => $request->looking_for,
              ]);

              if (!$apiResponse1->successful()) {
                  return response()->json([
                      'success' => false,
                      'msg'     => 'First API connection failed'
                  ], 500);
              }

              $data1 = $apiResponse1->json();

              if (!isset($data1['status']) || $data1['status'] !== 'success') {
                  return response()->json([
                      'success' => false,
                      'msg'     => $data1['message'] ?? 'First API failed'
                  ], 400);
              }

              // ✅ Second API call (example: sending same or different data)
              $apiResponse2 = Http::asForm()->post('https://www.gemtenderconsultant.in/api/tenderkhabar_api/', [
                  'client_name'    => $request->name,
                  'client_email'   => $request->email,
                  'client_phone'   => $request->user_primary_phone,
                  'client_company' => $request->company_name,
                  'message'        => $request->looking_for,
              ]);

              if (!$apiResponse2->successful()) {
                  return response()->json([
                      'success' => false,
                      'msg'     => 'Second API connection failed'
                  ], 500);
              }

              $data2 = $apiResponse2->json();

              if (!isset($data2['status']) || $data2['status'] !== 'success') {
                  return response()->json([
                      'success' => false,
                      'msg'     => $data2['message'] ?? 'Second API failed'
                  ], 400);
              }

              // ✅ Both APIs succeeded
              return response()->json([
                  'success' => true,
                  'msg'     => 'Inquiry submitted successfully to both APIs!',
                  'first_api'  => $data1,
                  'second_api' => $data2,
              ], 200);

          } 
          catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'msg'     => 'Exception: ' . $e->getMessage()
                ], 500);
            }
          // return Response::json(array('success' => true,'msg'=>"Your Enquiry has been submitted."), 200);
        }   
      }
    }
  }
  public function getfiltercity(Request $request){
    $html = '';
    if($request->has('data')){
      if (in_array('380017', $request->data)) {
        //$my_new_city = implode(',', $my_cities);
        //$my_cities = $request->data;
        //$my_cities[] = '356033';
        $my_new_city = $request->data;
      } else {
        $my_new_city = $request->data;
      }
      $ids = array_map('intval', $my_new_city);  
      $data = DB::table('city')
          ->whereIn('state_id',$ids)
          ->orderby('name','asc')
          ->get();
       
      if($data->count() > 0){
        foreach ($data as $key => $value) {
          if (!empty($value->name)) {
              $html.='<div class="form-check m-1 main">
                <input class="form-check-input city" name="city" type="checkbox" value="'.$value->name.'" data="'.$value->name.'" id="city_'.$value->id.'" >
                <label class="form-check-label" for="city_'.$value->id.'">
                    '.$value->name.'
                </label>
              </div>';
          }
        }  
        return Response::json(array('success' => true,'msg'=>"City List",'data'=>$html), 200);
      }
    }else{
      return Response::json(array('success' => false,'msg'=>"Invalid Request",'data'=>$html), 200);
    }
  }

  public function actionGetkeywordlist(Request $request) {
    $data = DB::table('keyword')
          ->select('id','name',DB::raw('LENGTH(name) as lk'));

    if($request->has('keyword') && !empty($request->keyword)){
      $data->where('name','like','%'.$request->keyword.'%');
    }      
    $data->orderby('lk','asc')->limit(20);
    $result = $data->get();
    return Response::json(['status'=>'success','data'=>$result]);
  }

  public function advancesearch()
  {
    $state_data = DB::table('state')
                  ->where('countryid',356)->where('id', '<>' , 380017)
                  ->get();
    return view('advance-search',compact('state_data'));
  }

  public function getfiltercityselect2(Request $request){
    $html = '';
    if($request->has('data')){
      if (in_array('380017', $request->data)) {
        //$my_new_city = implode(',', $my_cities);
        //$my_cities = $request->data;
        //$my_cities[] = '356033';
        $my_new_city = $request->data;
      }else{
        $my_new_city = $request->data;
      }
      $ids = array_map('intval', $my_new_city);  
      $data = DB::table('city')
          ->whereIn('state_id',$ids)
          ->orderby('name','asc')
          ->get();
       
      if($data->count() > 0){
        foreach ($data as $key => $value) {
          if (!empty($value->name)) {
            $html.='<option value="'.$value->name.'" data="'.$value->id.'">'.$value->name.'</option>';
          }
        }  
        return Response::json(array('success' => true,'msg'=>"City List",'data'=>$html), 200);
      }
    }else{
      return Response::json(array('success' => false,'msg'=>"Invalid Request",'data'=>$html), 200);
    }
  }

  public function changepasswordform(Request $request)
  {
      if(Auth::check()){
        return view('backend/change-password');  
      }else{
        return redirect::route('login');  
      }

  }

  public function changePassword(Request $request)
  { 
      $request->validate([
        'current_password' => ['required'],
        'new_password' => ['required', 'min:8','confirmed'],
      ]);
      if (!Hash::check($request->current_password, Auth::user()->password)) {
        return back()->withErrors(['current_password' => 'Current password is incorrect']);
      }
      Auth::user()->update([
        'password' => Hash::make($request->new_password),
      ]);
      return back()->with('status', 'Password changed successfully!');
  }
}
