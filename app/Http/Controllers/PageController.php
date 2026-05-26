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

  public function otherportal(Request $request){
    return view('otherportal');
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
  //city filter
  public function getfiltercity(Request $request){
    $html = '';
    if($request->has('data')){
      if (in_array('380017', $request->data)) {
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
              $html.='
               <label class="search-tender-option"><input class="form-check-input city" name="city" type="checkbox" value="'.$value->name.'" data="'.$value->name.'" id="city_'.$value->id.'" > 
               '.$value->name.'
               </label>';
          }
        }  
        return Response::json(array('success' => true,'msg'=>"City List",'data'=>$html), 200);
      }
    }else{
      return Response::json(array('success' => false,'msg'=>"Invalid Request",'data'=>$html), 200);
    }
  }
  public function getfiltercityselect2(Request $request){
    $html = '';
    if($request->has('data')){
      if (in_array('380017', $request->data)) {
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
            $html.='
               <label class="search-result-option"><input class="city" name="city" type="checkbox" value="'.$value->name.'" data="'.$value->name.'" id="city_'.$value->id.'" > 
               '.$value->name.'
               </label>';
          }
        }  
        return Response::json(array('success' => true,'msg'=>"City List",'data'=>$html), 200);
      }
    }else{
      return Response::json(array('success' => false,'msg'=>"Invalid Request",'data'=>$html), 200);
    }
  }
  public function getfiltercityselect2advance(Request $request){
    $html = '';
    if($request->has('data')){
      if (in_array('380017', $request->data)) {
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
