<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use Session;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use DB;

class UserProfile extends Model
{
     
    protected $table = 'userproduct'; 
    protected $fillable = [
        'user_id',
        'keyword',
    ];
    public function getUserdata($userid){
        $usersubscription = self::where('user_id',$userid)->first();

        if(!is_null($usersubscription))
        {
            session()->put('tendertodate',$usersubscription->todate);
        }
        $tender_data = self::select('userproduct.*',
                            DB::raw('"main" as filter'),
                            DB::raw(' "My Preference" as filter_name '))
                        ->where('userproduct.user_id',$userid)
                        ->first();
        $session_data = [];                           
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

        session()->put('loginuser.tender.filter',$session_data);
        return $session_data;
    }             
}