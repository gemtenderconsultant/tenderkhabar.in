<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use Session;
use App\Models\User;
use App\Models\UserProduct;
//use App\Models\SavedUserProduct;
//use App\Models\WorkSubscription;
use App\Models\UserResultProduct;
//use App\Models\Tenderlike;
//use App\Models\Usersubscription;
//use App\Models\Userresultsubscription;
use DB;
class checkUserLogin
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $user;

    /**
     * Create a new middleware instance.
     *
     * @param  Guard  $user
     * @return void
     */
    public function __construct(Guard $user)
    {   
        $this->user = $user;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if(Auth::check()){
            $user = Auth::user();

            /*if(!$request->session()->has('favouritetenders')){
                
                $saved_user_favourite = Tenderlike::select('tenderlike.*')
                    ->where('tenderlike.user_id',$user->user_id)
                ->get(); // ->toArray()
                $tenderfavourite = array();
                foreach($saved_user_favourite as $fk => $v){
                    $tenderfavourite[$fk] = $v->tender_id;
                }
                $request->session()->put('favouritetenders',$tenderfavourite);
            }*/
            
            if(!$request->session()->has('loginuser')){
                $request->session()->flush();
                $request->session()->start();
                //$user = Auth::user();
                $session_data = array();
                $result_session_data = array();
                $worksubscription = array();
                $globalsubscription = array();
                $ToDate = "";
                $T = $user->is_tender;
                $R = $user->is_result;
                
                //$W = $user->workuser;
                //$G = $user->globaltenders;
                
                if(!empty($user->id)){
                    $current_date = \Carbon\Carbon::now()->format('Y-m-d');  
                    $comp = 0; 
                    if($T == 1 || $R == 1){
                        //$ToDate = '0000-00-00';     
                        
                         if($T == 1){
                            if(!$request->session()->has('tendertodate')){

                                 $usersubscription = UserProduct::where('user_id',$user->id)->first();

                                if(!is_null($usersubscription))
                                {
                                    $request->session()->put('tendertodate',$usersubscription->todate);
                                }

                            }
                            $tender_data = UserProduct::select('userproduct.*',
                                                DB::raw('"main" as filter'),
                                                DB::raw(' "My Preference" as filter_name '))
                                            ->where('userproduct.user_id',$user->id)
                                            ->first();
                                      
                                if($tender_data){
                                    $tender_data = $tender_data->toArray(); 
                                    $productid = DB::table('industry')
                                        ->select(DB::raw('GROUP_CONCAT(industry.id) as id'))
                                        ->whereIn('industry.id',explode(',',$tender_data['productid']))
                                        ->first();
                                    $tender_data['productid'] = $productid->id;

                                    $product = DB::table('industry')
                                        ->select(DB::raw('GROUP_CONCAT(REPLACE(industry.name,",","-")) as name'))
                                        ->whereIn('industry.id',explode(',',$tender_data['productid']))
                                        ->first();
                                    $tender_data['productidname'] = $product->name;

                                    $categoryid = DB::table('category')
                                        ->select(DB::raw('GROUP_CONCAT(category.id) as id'))
                                        ->whereIn('category.id',explode(',',$tender_data['categoryid']))
                                        ->first();
                                    $tender_data['categoryid'] = $categoryid->id;

                                    $subcategoryid = DB::table('subcategory')
                                        ->select(DB::raw('GROUP_CONCAT(subcategory.id) as id'))
                                        ->whereIn('subcategory.id',explode(',',$tender_data['subcategoryid']))
                                        ->first();
                                    $tender_data['subcategoryid'] = $subcategoryid->id;


                                    $category = DB::table('category')
                                        ->select(DB::raw('GROUP_CONCAT(REPLACE(category.name,",","-")) as name'))
                                        ->whereIn('category.id',explode(',',$tender_data['categoryid']))
                                        ->first();
                                    $tender_data['categoryidname'] = $category->name;

                                    $subcategory = DB::table('subcategory')
                                        ->select(DB::raw('GROUP_CONCAT(REPLACE(subcategory.name,",","-")) as name'))
                                        ->whereIn('subcategory.id',explode(',',$tender_data['subcategoryid']))
                                        ->first();
                                    $tender_data['subcategoryidname'] = $subcategory->name;

                                    $exe_productid = DB::table('industry')
                                        ->select(DB::raw('GROUP_CONCAT(industry.id) as id'))
                                        ->whereIn('industry.id',explode(',',$tender_data['exe_productid']))
                                        ->first();
                                    $tender_data['exe_productid'] = $exe_productid->id;

                                    $exe_product = DB::table('industry')
                                        ->select(DB::raw('GROUP_CONCAT(REPLACE(industry.name,",","-")) as name'))
                                        ->whereIn('industry.id',explode(',',$tender_data['exe_productid']))
                                        ->first();
                                    $tender_data['eproductidname'] = $exe_product->name;

                                    $exe_categoryid = DB::table('category')
                                        ->select(DB::raw('GROUP_CONCAT(category.id) as id'))
                                        ->whereIn('category.id',explode(',',$tender_data['exe_categoryid']))
                                        ->first();
                                    $tender_data['ecategoryid'] = $exe_categoryid->id;

                                    $exe_category = DB::table('category')
                                        ->select(DB::raw('GROUP_CONCAT(REPLACE(category.name,",","-")) as name'))
                                        ->whereIn('category.id',explode(',',$tender_data['exe_categoryid']))
                                        ->first();
                                    $tender_data['ecategoryidname'] = $exe_category->name;

                                    $exe_subcategory = DB::table('subcategory')
                                        ->select(DB::raw('GROUP_CONCAT(subcategory.id) as id'))
                                        ->whereIn('subcategory.id',explode(',',$tender_data['exe_subcategoryid']))
                                        ->first();
                                    $tender_data['esubcategoryid'] = $exe_subcategory->id;

                                    $exe_subcategory = DB::table('subcategory')
                                        ->select(DB::raw('GROUP_CONCAT(REPLACE(subcategory.name,",","-")) as name'))
                                        ->whereIn('subcategory.id',explode(',',$tender_data['exe_subcategoryid']))
                                        ->first();
                                    $tender_data['esubcategoryidname'] = $exe_subcategory->name;

                                    $stateid = DB::table('state')
                                        ->select(DB::raw('GROUP_CONCAT(state.id) as id'))
                                        ->whereIn('state.id',explode(',',$tender_data['state']))
                                        ->first();
                                    $tender_data['state'] = $stateid->id;

                                    $state = DB::table('state')
                                        ->select(DB::raw('GROUP_CONCAT(REPLACE(state.name,",","-")) as name'))
                                        ->whereIn('state.id',explode(',',$tender_data['state']))
                                        ->first();
                                    $tender_data['state_name'] = $state->name;

                                    $agencyid = DB::table('agency')
                                        ->select(DB::raw('GROUP_CONCAT(agency.agencyid) as id'))
                                        ->whereIn('agency.agencyid',explode(',',$tender_data['Agency']))
                                        ->first();
                                    $tender_data['Agency'] = $agencyid->id;

                                    $agency = DB::table('agency')
                                        ->select(DB::raw('GROUP_CONCAT(REPLACE(agency.agencyname,",","-")) as name'))
                                        ->whereIn('agency.agencyid',explode(',',$tender_data['Agency']))
                                        ->first();
                                    $tender_data['Agency_name'] = $agency->name;
                                    
                                    $exe_agencyid = DB::table('agency')
                                        ->select(DB::raw('GROUP_CONCAT(agency.agencyid) as id'))
                                        ->whereIn('agency.agencyid',explode(',',$tender_data['excluding_agency']))->first();
                                    $tender_data['excluding_agency'] = $exe_agencyid->id;

                                    $exe_agency = DB::table('agency')
                                        ->select(DB::raw('GROUP_CONCAT(REPLACE(agency.agencyname,",","-")) as name'))
                                        ->whereIn('agency.agencyid',explode(',',$tender_data['excluding_agency']))
                                        ->first();
                                    $tender_data['eAgency_name'] = $exe_agency->name;
                                    array_push($session_data,$tender_data);    
                                }

                            $request->session()->put('loginuser.tender.filter',$session_data);
                            
                        }
                        
                        if($R == 1){ 

                            if(!$request->session()->has('tenderresulttodate')){

                                 $userresultsubscription = UserResultProduct::where('user_id',$user->id)->first();

                                if(!is_null($userresultsubscription))
                                {
                                    $request->session()->put('tenderresulttodate',$userresultsubscription->todate);
                                }

                            }
                            
                            $tender_result_data = UserResultProduct::select('user_result_product.*',
                                                DB::raw('"main" as filter'),
                                                DB::raw(' "My Preference" as filter_name '))
                                            ->where('user_result_product.user_id',$user->id)
                                            ->first();

                                if($tender_result_data){
                                    $tender_result_data = $tender_result_data->toArray();
                                    $productid = DB::table('industry')
                                        ->select(DB::raw('GROUP_CONCAT(industry.id) as id'))
                                        ->whereIn('industry.id',explode(',',$tender_result_data['productid']))
                                        ->first();
                                    $tender_result_data['productid'] = $productid->id;

                                    $product = DB::table('industry')
                                        ->select(DB::raw('GROUP_CONCAT(REPLACE(industry.name,",","-")) as name'))
                                        ->whereIn('industry.id',explode(',',$tender_result_data['productid']))
                                        ->first();
                                    $tender_result_data['productidname'] = $product->name;

                                    $categoryid = DB::table('category')
                                        ->select(DB::raw('GROUP_CONCAT(category.id) as id'))
                                        ->whereIn('category.id',explode(',',$tender_result_data['categoryid']))
                                        ->first();
                                    $tender_result_data['categoryid'] = $categoryid->id;

                                    $subcategoryid = DB::table('subcategory')
                                        ->select(DB::raw('GROUP_CONCAT(subcategory.id) as id'))
                                        ->whereIn('subcategory.id',explode(',',$tender_result_data['subcategoryid']))
                                        ->first();
                                    $tender_result_data['subcategoryid'] = $subcategoryid->id;


                                    $category = DB::table('category')
                                        ->select(DB::raw('GROUP_CONCAT(REPLACE(category.name,",","-")) as name'))
                                        ->whereIn('category.id',explode(',',$tender_result_data['categoryid']))
                                        ->first();
                                    $tender_result_data['categoryidname'] = $category->name;

                                    $subcategory = DB::table('subcategory')
                                        ->select(DB::raw('GROUP_CONCAT(REPLACE(subcategory.name,",","-")) as name'))
                                        ->whereIn('subcategory.id',explode(',',$tender_result_data['subcategoryid']))
                                        ->first();
                                    $tender_result_data['subcategoryidname'] = $subcategory->name;

                                    $exe_productid = DB::table('industry')
                                        ->select(DB::raw('GROUP_CONCAT(industry.id) as id'))
                                        ->whereIn('industry.id',explode(',',$tender_result_data['exe_productid']))
                                        ->first();
                                    $tender_result_data['exe_productid'] = $exe_productid->id;

                                    $exe_product = DB::table('industry')
                                        ->select(DB::raw('GROUP_CONCAT(REPLACE(industry.name,",","-")) as name'))
                                        ->whereIn('industry.id',explode(',',$tender_result_data['exe_productid']))
                                        ->first();
                                    $tender_result_data['eproductidname'] = $exe_product->name;

                                    $exe_categoryid = DB::table('category')
                                        ->select(DB::raw('GROUP_CONCAT(category.id) as id'))
                                        ->whereIn('category.id',explode(',',$tender_result_data['exe_categoryid']))
                                        ->first();
                                    $tender_result_data['ecategoryid'] = $exe_categoryid->id;

                                    $exe_category = DB::table('category')
                                        ->select(DB::raw('GROUP_CONCAT(REPLACE(category.name,",","-")) as name'))
                                        ->whereIn('category.id',explode(',',$tender_result_data['exe_categoryid']))
                                        ->first();
                                    $tender_result_data['ecategoryidname'] = $exe_category->name;

                                    $exe_subcategory = DB::table('subcategory')
                                        ->select(DB::raw('GROUP_CONCAT(subcategory.id) as id'))
                                        ->whereIn('subcategory.id',explode(',',$tender_result_data['exe_subcategoryid']))
                                        ->first();
                                    $tender_result_data['esubcategoryid'] = $exe_subcategory->id;

                                    $exe_subcategory = DB::table('subcategory')
                                        ->select(DB::raw('GROUP_CONCAT(REPLACE(subcategory.name,",","-")) as name'))
                                        ->whereIn('subcategory.id',explode(',',$tender_result_data['exe_subcategoryid']))
                                        ->first();
                                    $tender_result_data['esubcategoryidname'] = $exe_subcategory->name;

                                    $stateid = DB::table('state')
                                        ->select(DB::raw('GROUP_CONCAT(state.id) as id'))
                                        ->whereIn('state.id',explode(',',$tender_result_data['state']))
                                        ->first();
                                    $tender_result_data['state'] = $stateid->id;

                                    $state = DB::table('state')
                                        ->select(DB::raw('GROUP_CONCAT(REPLACE(state.name,",","-")) as name'))
                                        ->whereIn('state.id',explode(',',$tender_result_data['state']))
                                        ->first();
                                    $tender_result_data['state_name'] = $state->name;

                                    $agencyid = DB::table('agency')
                                        ->select(DB::raw('GROUP_CONCAT(agency.agencyid) as id'))
                                        ->whereIn('agency.agencyid',explode(',',$tender_result_data['agency']))
                                        ->first();
                                    $tender_result_data['agency'] = $agencyid->id;

                                    $agency = DB::table('agency')
                                        ->select(DB::raw('GROUP_CONCAT(REPLACE(agency.agencyname,",","-")) as name'))
                                        ->whereIn('agency.agencyid',explode(',',$tender_result_data['agency']))
                                        ->first();
                                    $tender_result_data['Agency_name'] = $agency->name;
                                    
                                    $exe_agencyid = DB::table('agency')
                                        ->select(DB::raw('GROUP_CONCAT(agency.agencyid) as id'))
                                        ->whereIn('agency.agencyid',explode(',',$tender_result_data['excluding_agency']))->first();
                                    $tender_result_data['excluding_agency'] = $exe_agencyid->id;

                                    $exe_agency = DB::table('agency')
                                        ->select(DB::raw('GROUP_CONCAT(REPLACE(agency.agencyname,",","-")) as name'))
                                        ->whereIn('agency.agencyid',explode(',',$tender_result_data['excluding_agency']))
                                        ->first();
                                    $tender_result_data['eAgency_name'] = $exe_agency->name;
                                    
                                    array_push($result_session_data,$tender_result_data);    
                                }
                                
                                $request->session()->put('loginuser.tenderresult.filter',$result_session_data);
                    
                       }
                    }  // end T W R G
                } // end empty user
            }
        }
        return $next($request);
    }
}