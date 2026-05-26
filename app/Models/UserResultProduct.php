<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Auth;
use DB;
use Session;
class UserResultProduct extends Authenticatable
// extends Model
{
 use HasFactory, Notifiable;

    protected $table = 'user_result_product';
    
    protected $fillable = [
        'user_id',
    ];
    //
    public function actionGettendersdata($name,$type){
        $delhi_ncr = array('Bhiwani', 'Faridabad', 'Gurgaon', 'Jhajjar', 'Mahendragarh', 'Panipat', 'Rewari', 'Rohtak', 'Sonipat', 'Mewat', 'Palwal', 'Jind', 'Karnal', 'Baghpat', 'Bulandshahr', 'Gautam Buddha Nagar', 'Ghaziabad', 'Muzaffarnagar', 'Meerut', 'Hapur', 'Alwar', 'Bharatpur', 'Noida', 'Delhi', 'New Delhi', 'SHAKURBASTI', 'TUGLAKABAD', 'Sakurbasit', 'Adarsh Nagar', 'Badli', 'Brar Square', 'Bijwasan', 'Chanakyapuri', 'Shivaji Bridge', 'Azadpur', 'Dayabasti', 'Delhi Cantt', 'Delhi Sarai Rohilla', 'Delhi KishanGanj', 'Old Delhi', 'Indrapuri', 'Shahdara', 'Sadar Bazar', 'Delhi Safdarjung', 'Ghevra', 'Holambi Kalan', 'Khera Kalan', 'Lodi Colony', 'Lajpat Nagar', 'Mangolpuri', 'Mundka', 'Naya Azadpur', 'Nangloi', 'Naraina Vihar', 'Narela', 'Delhi Hazrat Nizamuddin', 'Okhla', 'Pragati Maidan', 'Palam', 'Patel Nagar', 'Rajlu Garhi', 'Sardar Patel Road', 'Sandal Kalan', 'Shahabad Mohamadpur', 'Sarojini Nagar', 'Sewa Nagar', 'Delhi Sabzi Mandi', 'Tilak Bridge', 'Vivek Vihar', 'Vivekanand Puri Halt');
        $my_amount = 9999999999;
        $page1 = 0;
        $per_page = 10;
        $keyword = "";
        $selectedstateid = "";
        $selectedstatename = "";
        $statenamequery = "";
        $selectedcity = "";
        $selectedagencyid = "";
        $selectedagencyname = "";
        $selectedcategoryid = "";
        $selectedcategoryname = "";
        $selectedsubcategoryid = "";
        $selectedsubcategoryname = "";
        $selectedcityid = "";
        if($type == 'state'){
            $name = str_replace('-', ' ', $name);
            $name = str_replace('tender result', '', $name);
            $name = str_replace('online tender', '', $name);
            $name = trim($name);
            
            $getagencydata = DB::table('state')
                ->where(DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name, '/', ''), '(', ''),')',''),'.',''),',',''),'&','')"), $name)
                ->first();
            $selectedstateid = $getagencydata->id; 
            $selectedstatename = $getagencydata->name; 
        }else if($type == 'agency'){
            $name = str_replace('-', ' ', $name);
            $name = str_replace('tender result', '', $name);
            $name = str_replace('online tender', '', $name);
            $name = trim($name);
           
            $getagencydata = DB::table('agency')
                ->where(DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(agencyname, '/', ''), '(', ''),')',''),'.',''),',',''),'&','')"), $name)
                ->first();
            
            $selectedagencyid = $getagencydata->agencyid;
            $selectedagencyname = $getagencydata->agencyname; 
            
        }else if($type == 'category'){
            $name = str_replace('-', ' ', $name);
            $name = str_replace('tender result', '', $name);
            $name = str_replace('online tender', '', $name);
            $name = trim($name);
            //dd($name);
            $getagencydata = DB::table('category')
                ->where(DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name, '/', ''), '(', ''),')',''),'.',''),',',''),'&','')"), $name)
                ->first();
            $selectedcategoryid = $getagencydata->id;
            $selectedcategoryname = $getagencydata->name;
            
        }else if($type == 'subcategory'){
             
            $name = str_replace('-', ' ', $name);
            $name = str_replace('tender result', '', $name);
            $name = str_replace('online tender', '', $name);
            $name = trim($name);
            
            $getagencydata = DB::table('subcategory')
                ->select('subcategory.*', 'category.name as cname')
                ->leftjoin('category', 'subcategory.categoryid', '=', 'category.id')
                ->where(DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(subcategory.name, '/', ''), '(', ''),')',''),'.',''),',',''),'&','')"), $name)
                ->first();
            $selectedcategoryid = $getagencydata->categoryid; 
            $selectedcategoryname = $getagencydata->cname; 
            $selectedsubcategoryid = $getagencydata->id; 
            $selectedsubcategoryname = $getagencydata->name; 
        }else if($type == 'city'){
            
            $cityname = str_replace('-', ' ', $name);
            $cityname = str_replace('tender result', '', $cityname);
            $cityname = str_replace('online tender', '', $cityname);
            $cityname = trim($cityname);
            
            $getcitydata = DB::table('city')
                ->select('city.*', 'state.name as sname')
                ->leftjoin('state', 'city.state_id', '=', 'state.id')
                ->where("city.name", $cityname)
                ->first();
            
            $selectedstateid = $getcitydata->state_id; 
            $selectedstatename = $getcitydata->sname; 
            $selectedcity = $getcitydata->name; 
            $selectedcityid = $getcitydata->id;  
            
        }else{
            if(isset($name) && $name){
              $keyword = $name;  
            }
        }
        
        if(trim($keyword) != ""){
            $keyword_items = preg_replace('/[^a-z A-Z 0-9]/', ' ', $keyword); 
            $arr_keyword = explode(' ',trim($keyword_items));
            $keyword_str = '';
            //print_r($arr_keyword);die();
            foreach($arr_keyword as $k => $val){
                $kval = strtolower($val);
                $kval = trim($kval);
                if(strlen($kval) > 2){
                $kval = '+'.$kval.' ';
                $keyword_str .= $kval;
                }
            } 
            $keyword_str = trim($keyword_str);
            $keyword_query = "MATCH (t.title) AGAINST ('$keyword_str' IN BOOLEAN MODE)";  
              
            $my_sub = '';
            $searchKeyword = array();
            $my_sub_id = array();
            $searc_session = $keyword;
            $str2 = str_replace(', ', ',', $searc_session);
            $str_3 = rtrim($str2, ',');
            $searchKeyword = explode(',', $str_3);
            $searchplan2 = implode(' ', $searchKeyword);
            $searchKeyword1 = explode(" ", $searchplan2);
            $keyword_len = count($searchKeyword);
            $l_k_array = '"' . implode('","', $searchKeyword) . '"';
            
            if(Auth::check()){
            }else{
            }
            $sql = "SELECT t.id,t.aoc,t.awarded_value,Moneyformat(t.awarded_value) as ti_amount,t.Organisation,t.selected_bidder,t.title,t.state_id,t.state as state_name,t.dt,t.city from tender_result_info as t where 1=1";
            $sql1 = "SELECT COUNT(*) as total from tender_result_info as t where 1=1";
            
            $sql .= " AND ($keyword_query)"; //fulltext
            $sql1 .= " AND ($keyword_query)";

        }else{
            if(Auth::check()){  
            }else{
            }
            if($type == 'category' || $type == 'subcategory'){
                    $sql = "SELECT t.id,t.aoc,t.awarded_value,Moneyformat(t.awarded_value) as ti_amount,t.Organisation,t.selected_bidder,t.title,t.state_id,t.state as state_name,t.dt,t.city from tender_result_info as t
                    INNER JOIN tender_result_category as tc ON t.id = tc.rid
                    where 1=1";
                    $sql1 = "SELECT COUNT(DISTINCT t.id) as total from tender_result_info as t INNER JOIN tender_result_category as tc ON t.id = tc.rid where 1=1";
            }else{
                    $sql = "SELECT t.id,t.aoc,t.awarded_value,Moneyformat(t.awarded_value) as ti_amount,t.Organisation,t.selected_bidder,t.title,t.state_id,t.state as state_name,t.dt,t.city from tender_result_info as t where 1=1";
                    $sql1 = "SELECT COUNT(*) as total from tender_result_info as t where 1=1";
                
                }
        }
        //   echo $sql1;die();
          $sqlstring = "";
      
          if($type == 'state'){
              $sqlstring .= " AND t.state_id='$selectedstateid'";   
          }else if($type == 'agency'){
              $sqlstring .= " AND t.agency_id='$selectedagencyid'";
          }else if($type == 'category'){
              $sqlstring .= " AND tc.categoryid='$selectedcategoryid'";
          }else if($type == 'subcategory'){
              $sqlstring .= " AND (tc.categoryid='$selectedcategoryid' AND tc.subcategory='$selectedsubcategoryid')";
          }else if($type == 'city'){
            if($selectedstateid!= "" && $cityname != ""){
              $sqlstring .= " AND (t.state_id=$selectedstateid AND t.city='$cityname')";
            }
          }else{
          }
        $sql .= $sqlstring;
        $sql1 .= $sqlstring;
       
       if($type == 'category' || $type == 'subcategory'){
           $sql .= " GROUP BY t.id ORDER BY t.id DESC LIMIT $page1,$per_page";
       }else if($type == 'keyword'){
           $sql .= " LIMIT $page1,$per_page";
       }else{
            if(trim($keyword) != ""){
            $sql .= " ORDER BY t.id DESC LIMIT $page1,$per_page";
            }else{         
            $sql .= " ORDER BY t.id DESC LIMIT $page1,$per_page";
            }
       }
        //$name,$type
        if($type == 'state'){
        }
        
        if($type == 'agency'){
        }
        
        if($type == 'keyword'){
        }
        
        // echo $sql." ".$sql1;die();
        $liveTender = array();
        $liveTender = DB::select($sql);
        $total = 0;
        $records = array();
        if(!empty($liveTender)){
            $records = DB::select($sql1);
            $total = $records[0]->total;
            foreach($records as $sk => $sval){
                 $total += $sval->total;
            }
            $total = $records[0]->total;
        }
        $userloginData = array();
        $dataT = array();
        $dataT['dataTender'] = $liveTender;
        $dataT['datatendercount'] = $total;
        $dataT['keyword'] = $keyword;
        $dataT['userproduct'] = $userloginData;
        $dataT['selectedstateid'] = $selectedstateid;
        $dataT['selectedstatename'] = $selectedstatename;
        $dataT['selectedcity'] = $selectedcity; 
        $dataT['selectedcityid'] = $selectedcityid; 
        $dataT['selectedagencyid'] = $selectedagencyid; 
        $dataT['selectedagencyname'] = $selectedagencyname; 
        $dataT['selectedcategoryid'] = $selectedcategoryid; 
        $dataT['selectedcategoryname'] = $selectedcategoryname;
        $dataT['selectedsubcategoryid'] = $selectedsubcategoryid; 
        $dataT['selectedsubcategoryname'] = $selectedsubcategoryname; 
        
        return $dataT;   
        
    }
    //gettenderresultslist
    public function tenderresultsearching($type){
        
        if($type == "dashboard"){
            $myuserproduct = Session::get('loginuser.tenderresult.filter.0'); 
            $userproduct['input_s_keyword'] = $myuserproduct['keyword'];
            $userproduct['input_s_product'] = $myuserproduct['productid'];
            $userproduct['input_s_category'] = $myuserproduct['categoryid'];
            $userproduct['input_s_subcategory'] = $myuserproduct['subcategoryid'];
            $userproduct['input_s_eproduct'] = $myuserproduct['exe_productid'];
            $userproduct['input_s_ecategory'] = $myuserproduct['exe_categoryid'];
            $userproduct['input_s_esubcategory'] = $myuserproduct['exe_subcategoryid'];
            $userproduct['input_isexactkeyword_values'] = $myuserproduct['is_exact_keyword'];
            $userproduct['input_s_org'] = $myuserproduct['Agency'];
            $userproduct['input_s_eorg'] = $myuserproduct['excluding_agency'];
            $userproduct['input_min_amount'] = $myuserproduct['Min_Amount'];
            $userproduct['input_max_amount'] = $myuserproduct['Max_Amount'];
            $userproduct['input_estimate_values'] = $myuserproduct['no_estimates'];
            $userproduct['input_within_search'] = $myuserproduct['refine_keyword'];
            $userproduct['input_s_ekeyword'] = $myuserproduct['excludingkeyword'];
            $userproduct['input_s_state'] = $myuserproduct['state'];
            $userproduct['input_s_city'] = $myuserproduct['city'];
            $userproduct['input_ntid_search'] = "";
            $userproduct['input_publish_date'] = "";
            $userproduct['input_ntid_search'] = "";
        }else{
            $userproduct = $_POST;
        }
         //echo "<pre>";print_r($_POST);die();
        $flag = 0;
        $page = '';
        $per_page = 10;
        if (isset($_POST['lpage'])) {
            $page = $_POST['lpage'];
            $page1 = ($page * $per_page) - $per_page;
        } else {
            $page1 = 0;
        }
        $filter_search = '';
        $keyword_search = '';
        
        if(Auth::check()){
        }else{  // not set login session   
        }
        $cdate = date('Y-m-d');
        $max_dt = date('Y-m-d', strtotime('-1 day', strtotime($cdate)));
        
        if(isset($userproduct['data']) && $userproduct['data'] == 'fresh'){
            $table_name = 'live_tenders';
            $cate_table_name = 'livetendercategory';
            $table_items = "live_tenderinfo_items";
            $condition = 't.dt >="'. $max_dt .'"';
        }else if(isset($userproduct['data']) && $userproduct['data'] == 'favourite'){
            $table_name = 'tenderinfo_2017';
            $cate_table_name = 'tendercategory_2017';
            $table_items = "tenderinfo_items";
            $condition = 'date(t.submitdate) >="'. date('Y-m-d') .'"'; 
        }else if(isset($userproduct['data']) && $userproduct['data'] == 'archive'){
            $table_name = 'tenderinfo_2017';
            $cate_table_name = 'tendercategory_2017';
            $table_items = "tenderinfo_items";
            $condition = 'date(t.submitdate) < "'. date('Y-m-d') .'"';
        }else if(isset($userproduct['data']) && $userproduct['data'] == 'archive2021'){
            $table_name = 'tender_2021';
            $cate_table_name = 'tendercategory_2021';
            $table_items = "tenderinfo_items";
            $condition = '1=1';
        }else if(isset($userproduct['data']) && $userproduct['data'] == 'archive2020'){
            $table_name = 'tender_2020';
            $cate_table_name = 'tendercategory_2020';
            $table_items = "tenderinfo_items";
            $condition = '1=1';
        }else{
            $table_name = 'live_tenders';
            $cate_table_name = 'livetendercategory';
            $table_items = "live_tenderinfo_items";
            $condition = "1=1";
        }
        
        $table_name = 'tender_result_info';
        $cate_table_name = 'tender_result_category';
        
        //after login
        $sql = "";
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->user_id;
        } 
        
        //for frontend logic 
        if($type == "searching"){  
        }
        
        if(isset($userproduct['data']) && $userproduct['data'] == 'favourite'){
            if (Auth::check()) {	
            }else{    
            }	
		}else{
            if ((isset($userproduct['input_s_product']) && $userproduct['input_s_product'] == "") && (isset($userproduct['input_s_category']) && $userproduct['input_s_category'] == "") && (isset($userproduct['input_s_subcategory']) && $userproduct['input_s_subcategory'] == "") && (isset($userproduct['input_s_eproduct']) && $userproduct['input_s_eproduct'] == "") && (isset($userproduct['input_s_ecategory']) && $userproduct['input_s_ecategory'] == "") && (isset($userproduct['input_s_esubcategory']) && $userproduct['input_s_esubcategory'] == "") && (isset($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != "")) {
                
                $sqlrecord = "SELECT t.id,t.aoc,t.awarded_value,Moneyformat(t.awarded_value) as ti_amount,t.Organisation,t.selected_bidder,t.title,t.state_id,t.state as state_name,t.dt,t.city from $table_name as t
                    where ".$condition;
                $sqltotal = "SELECT COUNT(*) as total from $table_name as t 
                    where ".$condition;
                    
                $sqltotaldashboard = "SELECT COUNT(DISTINCT CASE WHEN t.submitdate >= '$cdate' THEN t.ourrefno ELSE NULL END) as totallive, Count(DISTINCT CASE WHEN t.dt = '$max_dt' THEN t.ourrefno ELSE NULL END) AS totalfresh from $table_name as t  where 1=1";
                
            }else if ((isset($userproduct['input_s_product']) && $userproduct['input_s_product'] == "") && (isset($userproduct['input_s_category']) && $userproduct['input_s_category'] == "") && (isset($userproduct['input_s_subcategory']) && $userproduct['input_s_subcategory'] == "") && (isset($userproduct['input_s_eproduct']) && $userproduct['input_s_eproduct'] == "") && (isset($userproduct['input_s_ecategory']) && $userproduct['input_s_ecategory'] == "") && (isset($userproduct['input_s_esubcategory']) && $userproduct['input_s_esubcategory'] == "") && (isset($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] == "")) {
                    
                $sqlrecord = "SELECT t.id,t.aoc,t.awarded_value,Moneyformat(t.awarded_value) as ti_amount,t.Organisation,t.selected_bidder,t.title,t.state_id,t.state as state_name,t.dt,t.city from $table_name as t
                    where ".$condition;
                $sqltotal = "SELECT COUNT(*) as total from $table_name as t 
                    where ".$condition;
                    
                $sqltotaldashboard = "SELECT COUNT(DISTINCT CASE WHEN t.submitdate >= '$cdate' THEN t.ourrefno ELSE NULL END) as totallive, Count(DISTINCT CASE WHEN t.dt = '$max_dt' THEN t.ourrefno ELSE NULL END) AS totalfresh from $table_name as t  where 1=1";
                
            }else{
                $sqlrecord = "SELECT t.id,t.aoc,t.awarded_value,Moneyformat(t.awarded_value) as ti_amount,t.Organisation,t.selected_bidder,t.title,t.state_id,t.state as state_name,t.dt,t.city from $table_name as t
                    LEFT JOIN $cate_table_name as tc ON t.id = tc.rid
                    where ".$condition;
                $sqltotal = "SELECT COUNT(DISTINCT t.id) as total from $table_name as t 
                    LEFT JOIN $cate_table_name as tc ON t.id = tc.rid 
                    where ".$condition;
                
                $sqltotaldashboard = "SELECT  COUNT(DISTINCT CASE WHEN t.submitdate >= '$cdate' THEN t.ourrefno ELSE NULL END) as totallive, Count(DISTINCT CASE WHEN t.dt = '$max_dt' THEN t.ourrefno ELSE NULL END) AS totalfresh from $table_name as t";
                $sqltotaldashboard .=" LEFT JOIN $cate_table_name as tc ON t.ourrefno = tc.ourrefno";
                $sqltotaldashboard .=" LEFT JOIN category as ct ON ct.id=tc.categoryid";
                $sqltotaldashboard .=" LEFT JOIN industry as ti ON ti.id=ct.industry_id";
                $sqltotaldashboard .=" where 1=1";
            }
        }
        //echo $sqlrecord; die();
        if (!empty($userproduct['input_ntid_search']) && $userproduct['input_ntid_search'] != "" && isset($userproduct['input_ntid_search'])) {
            $ntids = $_POST['input_ntid_search'];
            $sql .= " AND t.id IN($ntids)";
        }
        
        if (!empty($userproduct['input_publish_date']) && $userproduct['input_publish_date'] != "" && isset($userproduct['input_publish_date'])) {
            $fdt = $_POST['input_publish_date'];
            $sql .= " AND t.dt='$fdt'";
        }
        /********** boq item query start***********/
        if(!empty($checkforboq)){
            foreach($checkforboq as $kboq => $kvboq){
                if($kvboq['match'] == 'Yes'){ // yes then not match BOQ 
                }else{ // match BOQ
                }
            }
        }
        $sql_items = "";
        if (!empty($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != "") {
            $userkeyword = explode(",", $userproduct['input_s_keyword']);
            $userkeyword = array_filter($userkeyword); 
            for ($i = 0; $i < count($userkeyword); $i++) {
                $sql_items .= " lti.item LIKE '%" . $userkeyword[$i] . "%' OR ";
            }
            $sql_items = trim($sql_items);
            $sql_items = rtrim($sql_items,'OR');
            $sql_items = trim($sql_items); 
            
            $sql_items = " OR ($sql_items)";
        }
        
        $sql_items = "";
        /********** boq item query end***********/
        if (!empty($userproduct['input_s_product']) || !empty($userproduct['input_s_category']) || !empty($userproduct['input_s_subcategory']) || !empty($userproduct['input_s_eproduct']) || !empty($userproduct['input_s_ecategory']) || !empty($userproduct['input_s_esubcategory'])) {
                
                $product_ids = $userproduct['input_s_product'];
                $cat_ids = $userproduct['input_s_category'];
                $subcat_ids = $userproduct['input_s_subcategory'];
                $eproduct_ids = $userproduct['input_s_eproduct'];
                $ecat_ids = $userproduct['input_s_ecategory'];
                $esubcat_ids = $userproduct['input_s_esubcategory'];
                
                $str_query = "";
                if (!empty($userproduct['input_s_product']) || !empty($userproduct['input_s_category']) || !empty($userproduct['input_s_subcategory'])) {
                        if ($product_ids != "") {
                            $str_query .= " tc.industryid IN (" . $product_ids . ") OR";
                        }
                        if ($cat_ids != "") {
                            $str_query .= " tc.categoryid IN (" . $cat_ids . ") OR";
                        }
                        if ($subcat_ids != "") {
                            $str_query .= " tc.subcategory IN (" . $subcat_ids . ") OR";
                        }
                        $str_query = trim($str_query);
                        $str_query = rtrim($str_query,'OR');
                        $str_query = trim($str_query);
                }
                $str_query2 = "";
                if (!empty($userproduct['input_s_eproduct']) || !empty($userproduct['input_s_ecategory']) || !empty($userproduct['input_s_esubcategory'])) {
                    $str_query2 .= "SELECT ilc.rid FROM $cate_table_name as ilc LEFT JOIN category as iec ON ilc.categoryid=iec.id WHERE ";
                    if ($eproduct_ids != "") {
                        $str_query2 .= " iec.industry_id IN (" . $eproduct_ids . ") OR"; //AND g
                    }
                    if ($ecat_ids != "") {
                        $str_query2 .= " ilc.categoryid IN (" . $ecat_ids . ") OR"; //AND g
                    }
                    if ($esubcat_ids != "") {
                        $str_query2 .= " ilc.subcategory IN (" . $esubcat_ids . ") OR"; //AND g
                    }
                    $str_query2 = trim($str_query2);
                    $str_query2 = rtrim($str_query2,'OR'); //AND g
                    $str_query2 = trim($str_query2);
                }
                    $sql .= " AND ( ";
                    if($str_query != "" && $str_query2 != ""){
                        $sql .=  "(".$str_query.")";
                    }else if($str_query != ""){    
                        $sql .=  "(".$str_query.")";
                    }else if($str_query2 != ""){    
                    }
                    
                    if (isset($userproduct['input_isexactkeyword_values']) && $userproduct['input_isexactkeyword_values'] == 1) {
                        if (!empty($userproduct['input_s_keyword'])) {
                            if (!empty($userproduct['input_s_product']) || !empty($userproduct['input_s_category']) || !empty($userproduct['input_s_subcategory'])) {
                                $sql .= " OR ( ";
                            } else {
                                $sql .= " ( ";
                            }
                            
                            $userkeyword = explode(",", $userproduct['input_s_keyword']);
                            $userkeyword = array_filter($userkeyword);
                            $sstr_ekeyword = "";
                            for ($i = 0; $i < count($userkeyword); $i++) {
                                $sstr_ekeyword .= " t.title LIKE '% " . $userkeyword[$i] . " %' OR ";
                            }
                            $sstr_ekeyword = trim($sstr_ekeyword);
                            $sstr_ekeyword = rtrim($sstr_ekeyword,'OR');
                            $sstr_ekeyword = trim($sstr_ekeyword);
                            $sql .= $sstr_ekeyword;
                            $sql .= " ) ";
                        }
                    } else {
                        if($type == "searching"){
                            if (!empty($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != "") {
                                $arr_seleced_keywords = explode(',',$userproduct['input_s_keyword']);  
                                $keyword_query = "";
                                foreach($arr_seleced_keywords as $selecykey => $selectvalue){
                                    $keyword_items = preg_replace('/[^a-z A-Z 0-9]/', ' ', $selectvalue); 
                                    $arr_keyword = explode(' ',trim($keyword_items));
                                    $keyword_str = '';
                                    foreach($arr_keyword as $k => $val){
                                        $kval = strtolower($val);
                                        $kval = trim($kval);
                                        if(strlen($kval) > 2){
                                        $kval = '+'.$kval.' ';
                                        $keyword_str .= $kval;
                                        }
                                    } 
                                    $keyword_str = trim($keyword_str);
                                    $keyword_query .= " (MATCH (t.title) AGAINST ('$keyword_str' IN BOOLEAN MODE)) OR"; 
                                }
                                $keyword_query = trim($keyword_query);
                                $keyword_query = rtrim($keyword_query,'OR');
                                $keyword_query = trim($keyword_query);
                                $sql .= " OR (".$keyword_query.")";
                                //echo $sql;die(); 
                            }
                        }else{ 
                            if (!empty($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != "") {
                                //$sql .= " OR ( ";
                                if (!empty($userproduct['input_s_product']) || !empty($userproduct['input_s_category']) || !empty($userproduct['input_s_subcategory'])) {
                                    $sql .= " OR ( ";
                                } else {
                                    $sql .= " ( ";
                                }
                                $userkeyword = explode(",", $userproduct['input_s_keyword']);
                                $userkeyword = array_filter($userkeyword);
                                $sstr_keyword = "";
                                for ($i = 0; $i < count($userkeyword); $i++) {
                                        $sstr_keyword .= " t.title LIKE '%" . $userkeyword[$i] . "%' OR ";
                                }
                                $sstr_keyword = trim($sstr_keyword);
                                $sstr_keyword = rtrim($sstr_keyword,'OR');
                                $sstr_keyword = trim($sstr_keyword);
                                $sql .= $sstr_keyword;
                                $sql .= " ) ";
                            } 
                        }
                    }
            $sql .= " $sql_items ) "; // gautishpatel
            if($str_query2 != ""){    
                $sql .=  " AND t.id NOT IN (".$str_query2.")";
            }
            //echo $sql;die();
        } else { // only keywordwise
            if (isset($userproduct['input_isexactkeyword_values']) && $userproduct['input_isexactkeyword_values'] == 1) {
                if (!empty($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != "") {
                    $userkeyword = explode(",", $userproduct['input_s_keyword']);
                    $userkeyword = array_filter($userkeyword); 
                    for ($i = 0; $i < count($userkeyword); $i++) {
                        if (count($userkeyword) == 1) {
                            $sql .= " AND (t.title  LIKE '% " . $userkeyword[$i] . " %' $sql_items)";
                        }
                        if (count($userkeyword) > 1) {
                            if ($i == 0) {
                                $sql .= " AND ((t.title LIKE '% " . $userkeyword[$i] . " %' OR ";
                            } else if ($i == (count($userkeyword) - 1)) {
                                $sql .= " t.title LIKE '% " . $userkeyword[$i] . " %') $sql_items)";
                            } else {
                                $sql .= " t.title LIKE '% " . $userkeyword[$i] . " %' OR ";
                            }
                        }
                    }
                }
            } else {
                if($type == "searching"){
                    if (!empty($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != "") {
                            $arr_seleced_keywords = explode(',',$userproduct['input_s_keyword']);  
                            $keyword_query = "";
                            foreach($arr_seleced_keywords as $selecykey => $selectvalue){
                                $keyword_items = preg_replace('/[^a-z A-Z 0-9]/', ' ', $selectvalue); 
                                $arr_keyword = explode(' ',trim($keyword_items));
                                $keyword_str = '';
                                //print_r($arr_keyword);die();
                                foreach($arr_keyword as $k => $val){
                                    $kval = strtolower($val);
                                    $kval = trim($kval);
                                    if(strlen($kval) > 2){
                                    $kval = '+'.$kval.' ';
                                    $keyword_str .= $kval;
                                    }
                                } 
                                $keyword_str = trim($keyword_str);
                                $keyword_query .= " (MATCH (t.title) AGAINST ('$keyword_str' IN BOOLEAN MODE)) OR"; 
                            }
                            $keyword_query = trim($keyword_query);
                            $keyword_query = rtrim($keyword_query,'OR');
                            $keyword_query = trim($keyword_query);
                            $sql .= " AND (".$keyword_query.")";
                            //echo $sql;die(); 
                    }
                }else{  
                    if (!empty($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != "") {
                        
                        $userkeyword = explode(",", $userproduct['input_s_keyword']);
                        $userkeyword = array_filter($userkeyword); 
                        for ($i = 0; $i < count($userkeyword); $i++) {
                            if (count($userkeyword) == 1) {
                                $sql .= " AND (t.title  LIKE '%" . $userkeyword[$i] . "%' $sql_items)";
                            }
                            if (count($userkeyword) > 1) {
                                if ($i == 0) {
                                    $sql .= " AND ((t.title LIKE '%" . $userkeyword[$i] . "%' OR ";
                                } else if ($i == (count($userkeyword) - 1)) {
                                    $sql .= " t.title LIKE '%" . $userkeyword[$i] . "%') $sql_items)";
                                } else {
                                    $sql .= " t.title LIKE '%" . $userkeyword[$i] . "%' OR ";
                                }
                            }
                        }
                    }
                }
            }
        }
        //echo $sql;die();
        
        if (isset($userproduct['input_s_org']) && $userproduct['input_s_org'] != 0 && $userproduct['input_s_org'] != "") {
            $sql .= " AND t.agency_id IN (" . $userproduct['input_s_org'] . ")";
        }
        if (isset($userproduct['input_s_eorg']) && $userproduct['input_s_eorg'] != 0 && $userproduct['input_s_eorg'] != "") {
            $sql .= " AND t.agency_id NOT IN (" . $userproduct['input_s_eorg'] . ")";
        }
        if (isset($userproduct['input_estimate_values']) && $userproduct['input_estimate_values'] == 1) {    
            if (!empty($userproduct['input_min_amount']) && !empty($userproduct['input_max_amount'])) {
                    $sql .= " AND ((`t`.`awarded_value` >= '" . $userproduct['input_min_amount'] . "' AND `t`.`awarded_value` <= '" . $userproduct['input_max_amount'] . "') OR `t`.`awarded_value` = 0)";
            } else if (!empty($userproduct['input_min_amount']) && empty($userproduct['input_max_amount'])) {
                $sql .= " AND (`t`.`awarded_value` >= '" . $userproduct['input_min_amount'] . "' OR `t`.`awarded_value` = 0)";
            } else if (empty($userproduct['input_min_amount']) && !empty($userproduct['input_max_amount'])) {
                $sql .= " AND (`t`.`awarded_value` <= '" . $userproduct['input_max_amount'] . "' OR `t`.`awarded_value` = 0)";
            }
        }else{
            if (!empty($userproduct['input_min_amount']) && !empty($userproduct['input_max_amount']) && $userproduct['input_min_amount'] != "" && $userproduct['input_max_amount'] != "") {
                    $sql .= " AND (`t`.`awarded_value` >= '" . $userproduct['input_min_amount'] . "' AND `t`.`awarded_value` <= '" . $userproduct['input_max_amount'] . "')";
            } else if (!empty($userproduct['input_min_amount']) && empty($userproduct['input_max_amount'])) {
                $sql .= " AND (`t`.`awarded_value` >= '" . $userproduct['input_min_amount'] . "')";
            } else if (empty($userproduct['input_min_amount']) && !empty($userproduct['input_max_amount'])) {
                $sql .= " AND (`t`.`awarded_value` <= '" . $userproduct['input_max_amount'] . "')";
            }
        }
        
        if (!empty($userproduct['input_within_search']) && $userproduct['input_within_search'] != "") {
            $userrefinekeyword = explode(",", $userproduct['input_within_search']);
            $userrefinekeyword = array_filter($userrefinekeyword); 
            for ($i = 0; $i < count($userrefinekeyword); $i++) {
                if (count($userrefinekeyword) == 1) {
                    $sql .= " AND t.title  LIKE '%" . $userrefinekeyword[$i] . "%'";
                }
                if (count($userrefinekeyword) > 1) {
                    if ($i == 0) {
                        $sql .= " AND (t.title LIKE '%" . $userrefinekeyword[$i] . "%' OR ";
                    } else if ($i == (count($userrefinekeyword) - 1)) {
                        $sql .= " t.title LIKE '%" . $userrefinekeyword[$i] . "%')";
                    } else {
                        $sql .= " t.title LIKE '%" . $userrefinekeyword[$i] . "%' OR ";
                    }
                }
            }
        }
        
        if (isset($userproduct['input_s_ekeyword']) && $userproduct['input_s_ekeyword'] != '') {
            $userexcludingkeyword = explode(",", $userproduct['input_s_ekeyword']);
            for ($j = 0; $j < count($userexcludingkeyword); $j++) {
                if (count($userexcludingkeyword) == 1) {
                    $sql .= " AND t.title NOT LIKE '%" . $userexcludingkeyword[$j] . "%'";
                }
                if (count($userexcludingkeyword) > 1) {
                    if ($j == 0) {
                        $sql .= " AND (t.title NOT LIKE '%" . $userexcludingkeyword[$j] . "%' AND ";
                    } else if ($j == (count($userexcludingkeyword) - 1)) {
                        $sql .= " t.title NOT LIKE '%" . $userexcludingkeyword[$j] . "%')";
                    } else {
                        $sql .= " t.title NOT LIKE '%" . $userexcludingkeyword[$j] . "%' AND ";
                    }
                }
            }
        }
        $state_ncr = array();
        $state_ncr1 = array();
        
        if (isset($userproduct['input_s_state']) && $userproduct['input_s_state'] != 0 && $userproduct['input_s_state'] != "") {
            $state_ncr = explode(',', $userproduct['input_s_state']);
            if (isset($userproduct['input_s_city']) && $userproduct['input_s_city'] == '' && !empty($state_ncr) && in_array('380017', $state_ncr)) {
                $sql .= " AND ( t.state_id IN (" . $userproduct['input_s_state'] . ")";
                $sql .= " or t.city IN ('Bhiwani','Faridabad','Gurgaon','Jhajjar','Mahendragarh','Panipat','Rewari','Rohtak','Sonipat', 'Mewat' , 'Palwal' , 'Jind' , 'Karnal' , 'Baghpat' , 'Bulandshahr' ,'Gautam Buddha Nagar', 'Ghaziabad' , 'Muzaffarnagar' , 'Meerut' , 'Hapur' , 'Alwar' , 'Bharatpur','Noida','Delhi','New Delhi','SHAKURBASTI','TUGLAKABAD','Sakurbasit','Adarsh Nagar','Badli','Brar Square','Bijwasan','Chanakyapuri','Shivaji Bridge','Azadpur','Dayabasti','Delhi Cantt','Delhi Sarai Rohilla','Delhi KishanGanj','Old Delhi','Indrapuri','Shahdara','Sadar Bazar','Delhi Safdarjung','Ghevra','Holambi Kalan','Khera Kalan','Lodi Colony','Lajpat Nagar','Mangolpuri','Mundka','Naya Azadpur','Nangloi','Naraina Vihar','Narela','Delhi Hazrat Nizamuddin','Okhla','Pragati Maidan','Palam','Patel Nagar','Rajlu Garhi','Sardar Patel Road','Sandal Kalan','Shahabad Mohamadpur','Sarojini Nagar','Sewa Nagar','Delhi Sabzi Mandi','Tilak Bridge','Vivek Vihar','Vivekanand Puri Halt')";
                $sql .= " )";
            } else {
                $sql .= " AND t.state_id IN (" . $userproduct['input_s_state'] . ")";
            }
        }

        if (isset($userproduct['input_s_city']) && $userproduct['input_s_city'] != '') {
            $city_explode = explode(',', $userproduct['input_s_city']);
            $city1 = "'" . implode("','", $city_explode) . "'";
            $sql .= " AND t.city IN (" . $city1 . ")";
        }
        
        $sqltot = $sqltotal;
        $sqltot .= $sql;
        if($type == "dashboard"){
        $sqltotaldashboard .= $sql;
        }
        $sql .= " GROUP by `t`.`id`  ";
        if (isset($userproduct['sortby']) && !empty($userproduct['sortby'])) {
            if ($userproduct['sortby'] == 'hl') {
                $sql .= " order by t.awarded_value desc";
            } else if ($userproduct['sortby'] == 'lh') {
                $sql .= " order by t.awarded_value asc";
            } else if ($userproduct['sortby'] == 'ad') {
                $sql .= " order by aoc asc";
            } else if ($userproduct['sortby'] == 'da') {
                $sql .= " order by aoc desc";
            }else{
                    $sql .= " order by t.id desc";
            }
        } else {
            $sql .= " order by t.id desc";
        }
        $total_count = 0;
        $livecount = 0;
        if (!empty($sql)) {
            if($type == "dashboard"){
                $resultdata = array();
                $resultdata = DB::select($sqltotaldashboard);
            }else{
                $sqlrec = $sqlrecord; 
                $sqlrec .= $sql;
                $sqlrec .= " limit $page1,$per_page";
                
                $resultdata = array();
                $resultdata = DB::select($sqlrec);
                if($page == 1){
                    //echo $sqltot;die();
                    
                    if(isset($userproduct['data'])){
                        if($userproduct['data'] == "archive" || $userproduct['data'] == "archive2021" || $userproduct['data'] == "archive2020"){
                             $total_count = "";
                             $livecount = "";
                        }else{
                            if(!empty($resultdata)){
                                $records = DB::select($sqltot);
                                $total_count = $records[0]->total ?? 0;

                                $a = $total_count / $per_page;
                                $livecount = ceil($a);
                            }
                            // if(!empty($resultdata)){
                            //     if($type == "searching"){
                            //     $records =DB::select($sqltot);
                            //     $total_count = $records[0]->total;
                            //     $a = $total_count / $per_page;
                            //     $livecount = ceil($a);
                            //     $total_count = "";
                            //     $livecount = "";
                            //     }else{
                            //     $total_count = "";
                            //     $livecount = "";
                            //     }
                            // }
                        }
                    }else{
                        $total_count = 0;
                        $a = $total_count / $per_page;
                        $livecount = ceil($a);
                    }
                }
            }
        } else {
            $resultdata = array();
            $total_count = 0;
            $livecount = 0;
        }
        $arrdata = array();
        $arrdata['resultdata'] = $resultdata;
        $arrdata['total_count'] = $total_count;
        $arrdata['livecount'] = $livecount;
        $arrdata['userkeyword'] = (isset($userproduct['input_s_keyword'])) ? $userproduct['input_s_keyword'] : '';
        
        return $arrdata; 
        exit;
    }

    public function tenderresultdetails($id)
    {
        $model = DB::table('tender_result_info')
                    ->where('id', $id)
                    ->first();

        if (!$model) {
            $model = DB::table('tender_result_info')
                        ->orderBy('id', 'desc')
                        ->first();
        }

        $title = strtolower($model->title ?? '');
        $words = array_filter(explode(' ', $title));

        $matchedKeywords = DB::table('keyword')
            ->where(function ($query) use ($words) {
                foreach ($words as $word) {
                    $query->orWhere('name', 'LIKE', '%' . $word . '%');
                }
            })
            ->limit(10) // ✅ ONLY 10 keywords
            ->pluck('name')
            ->toArray();

        return [
            'data' => $model,
            'keywords' => $matchedKeywords
        ];
    }

    public function checktenderresultdownload($id){
        $is_download = 0;
        $msg = "";
        $tendertodate = "";
        $user = Auth::user();
        $todays = date('Y-m-d');
        
        if(Auth::check()){
            $T = $user->is_result;
            $usertype = $user->status;
            if(Session::has('tenderresulttodate')){
                $tendertodate = Session::get('tenderresulttodate');
            }
            
            if($T == 1){
                
                if($usertype == "Paid"){
                    if ($tendertodate >= $todays) { // || $bidding_status == "Live"
                        //dd($id);  
                        if(Session::has('loginuser')){
                            $myuserproduct = Session::get('loginuser.tenderresult.filter.0');
                            if($myuserproduct['state'] == "" || is_null($myuserproduct['state'])){ // all state
                                $is_download = 1;
                                $msg = "success";
                            }else{
                                $statearray = explode(',',$myuserproduct['state']);
                                if(in_array($id,$statearray)){
                                    $is_download = 1;  
                                    $msg = "success";
                                }else{
                                    $is_download = 0;  
                                    $msg = "Tender not match your state! you can download only your relevant state tender!";
                                }
                            }
                        }else{
                            $is_download = 0;  
                            $msg = "session issue";
                        }
                    }else{
                        $is_download = 0;
                        $msg = "Your service has been expired! please contact to admin.";
                    }
                }else{
                    $is_download = 0;
                    $msg = "You are free trail user! please contact to admin.";
                }
            }else{
                $is_download = 0;
                $msg = "You are not tender user! please subscribe first.";
            }
        }else{
            $is_download = 0;
            $msg = "guestuser";
        }
        $data = array();
        $data['is_download'] = $is_download;
        $data['msg'] = $msg;
        
        return $data;
    }

    //backend code 
    // public function tenderresultsearching($type){
        
    //     if($type == "dashboard"){
            
    //         $myuserproduct = Session::get('loginuser.tenderresult.filter.0'); 
    //         $userproduct['input_s_keyword'] = $myuserproduct['keyword'];
    //         $userproduct['input_s_product'] = $myuserproduct['productid'];
    //         $userproduct['input_s_category'] = $myuserproduct['categoryid'];
    //         $userproduct['input_s_subcategory'] = $myuserproduct['subcategoryid'];
    //         $userproduct['input_s_eproduct'] = $myuserproduct['exe_productid'];
    //         $userproduct['input_s_ecategory'] = $myuserproduct['exe_categoryid'];
    //         $userproduct['input_s_esubcategory'] = $myuserproduct['exe_subcategoryid'];
    //         $userproduct['input_isexactkeyword_values'] = $myuserproduct['is_exact_keyword'];
    //         $userproduct['input_s_org'] = $myuserproduct['Agency'];
    //         $userproduct['input_s_eorg'] = $myuserproduct['excluding_agency'];
    //         $userproduct['input_min_amount'] = $myuserproduct['Min_Amount'];
    //         $userproduct['input_max_amount'] = $myuserproduct['Max_Amount'];
    //         $userproduct['input_estimate_values'] = $myuserproduct['no_estimates'];
    //         $userproduct['input_within_search'] = $myuserproduct['refine_keyword'];
    //         $userproduct['input_s_ekeyword'] = $myuserproduct['excludingkeyword'];
    //         $userproduct['input_s_state'] = $myuserproduct['state'];
    //         $userproduct['input_s_city'] = $myuserproduct['city'];
    //         $userproduct['input_ntid_search'] = "";
    //         $userproduct['input_publish_date'] = "";
    //         $userproduct['input_ntid_search'] = "";
            
            
    //     }else{
    //         $userproduct = $_POST;
    //     }
    //      //echo "<pre>";print_r($_POST);die();
    //     $flag = 0;
    //     $page = '';
    //     $per_page = 10;
    //     if (isset($_POST['lpage'])) {
    //         $page = $_POST['lpage'];
    //         $page1 = ($page * $per_page) - $per_page;
    //     } else {
    //         $page1 = 0;
    //     }
    //     $filter_search = '';
    //     $keyword_search = '';
        
    //     if(Auth::check()){
    //     }else{  // not set login session   
    //     }
        
    //     $cdate = date('Y-m-d');
    //     $max_dt = date('Y-m-d', strtotime('-1 day', strtotime($cdate)));
        
    //     if(isset($userproduct['data']) && $userproduct['data'] == 'fresh'){
    //         $table_name = 'live_tenders';
    //         $cate_table_name = 'livetendercategory';
    //         $table_items = "live_tenderinfo_items";
    //         $condition = 't.dt >="'. $max_dt .'"';
    //     }else if(isset($userproduct['data']) && $userproduct['data'] == 'favourite'){
    //         $table_name = 'tenderinfo_2017';
    //         $cate_table_name = 'tendercategory_2017';
    //         $table_items = "tenderinfo_items";
    //         $condition = 'date(t.submitdate) >="'. date('Y-m-d') .'"'; 
    //     }else if(isset($userproduct['data']) && $userproduct['data'] == 'archive'){
    //         $table_name = 'tenderinfo_2017';
    //         $cate_table_name = 'tendercategory_2017';
    //         $table_items = "tenderinfo_items";
    //         $condition = 'date(t.submitdate) < "'. date('Y-m-d') .'"';
    //     }else if(isset($userproduct['data']) && $userproduct['data'] == 'archive2021'){
    //         $table_name = 'tender_2021';
    //         $cate_table_name = 'tendercategory_2021';
    //         $table_items = "tenderinfo_items";
    //         $condition = '1=1';
    //     }else if(isset($userproduct['data']) && $userproduct['data'] == 'archive2020'){
    //         $table_name = 'tender_2020';
    //         $cate_table_name = 'tendercategory_2020';
    //         $table_items = "tenderinfo_items";
    //         $condition = '1=1';
    //     }else{
    //         $table_name = 'live_tenders';
    //         $cate_table_name = 'livetendercategory';
    //         $table_items = "live_tenderinfo_items";
    //         $condition = "1=1";
    //     }
        
    //     $table_name = 'tender_result_info';
    //     $cate_table_name = 'tender_result_category';
        
    //     //after login
    //     $sql = "";
    //     if (Auth::check()) {
    //         $user = Auth::user();
    //         $user_id = $user->user_id;
            
    //     } 
        
    //     //for frontend logic 
    //     if($type == "searching"){
    //     }
    //     if(isset($userproduct['data']) && $userproduct['data'] == 'favourite'){
    //         if (Auth::check()) {		
    //         }else{
    //         }	
    //     }else{
    //         if ((isset($userproduct['input_s_product']) && $userproduct['input_s_product'] == "") && (isset($userproduct['input_s_category']) && $userproduct['input_s_category'] == "") && (isset($userproduct['input_s_subcategory']) && $userproduct['input_s_subcategory'] == "") && (isset($userproduct['input_s_eproduct']) && $userproduct['input_s_eproduct'] == "") && (isset($userproduct['input_s_ecategory']) && $userproduct['input_s_ecategory'] == "") && (isset($userproduct['input_s_esubcategory']) && $userproduct['input_s_esubcategory'] == "") && (isset($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != "")) {
                
    //                 $sqlrecord = "SELECT t.id,t.aoc,t.awarded_value,Moneyformat(t.awarded_value) as ti_amount,t.Organisation,t.title,t.state_id,t.state as state_name,t.dt,t.city from $table_name as t
    //                 where ".$condition;
    //                 $sqltotal = "SELECT COUNT(*) as total from $table_name as t 
    //                 where ".$condition;
                    
    //             $sqltotaldashboard = "SELECT COUNT(DISTINCT CASE WHEN t.submitdate >= '$cdate' THEN t.ourrefno ELSE NULL END) as totallive, Count(DISTINCT CASE WHEN t.dt = '$max_dt' THEN t.ourrefno ELSE NULL END) AS totalfresh from $table_name as t  where 1=1";
                
    //         }else if ((isset($userproduct['input_s_product']) && $userproduct['input_s_product'] == "") && (isset($userproduct['input_s_category']) && $userproduct['input_s_category'] == "") && (isset($userproduct['input_s_subcategory']) && $userproduct['input_s_subcategory'] == "") && (isset($userproduct['input_s_eproduct']) && $userproduct['input_s_eproduct'] == "") && (isset($userproduct['input_s_ecategory']) && $userproduct['input_s_ecategory'] == "") && (isset($userproduct['input_s_esubcategory']) && $userproduct['input_s_esubcategory'] == "") && (isset($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] == "")) {
                    
    //                 $sqlrecord = "SELECT t.id,t.aoc,t.awarded_value,Moneyformat(t.awarded_value) as ti_amount,t.Organisation,t.title,t.state_id,t.state as state_name,t.dt,t.city from $table_name as t
    //                 where ".$condition;
    //                 $sqltotal = "SELECT COUNT(*) as total from $table_name as t 
    //                 where ".$condition;
                    
    //             $sqltotaldashboard = "SELECT COUNT(DISTINCT CASE WHEN t.submitdate >= '$cdate' THEN t.ourrefno ELSE NULL END) as totallive, Count(DISTINCT CASE WHEN t.dt = '$max_dt' THEN t.ourrefno ELSE NULL END) AS totalfresh from $table_name as t  where 1=1";
                
    //         }else{
                
    //                 $sqlrecord = "SELECT t.id,t.aoc,t.awarded_value,Moneyformat(t.awarded_value) as ti_amount,t.Organisation,t.title,t.state_id,t.state as state_name,t.dt,t.city from $table_name as t
    //                 LEFT JOIN $cate_table_name as tc ON t.id = tc.rid
    //                 where ".$condition;
    //                 $sqltotal = "SELECT COUNT(DISTINCT t.id) as total from $table_name as t 
    //                 LEFT JOIN $cate_table_name as tc ON t.id = tc.rid 
    //                 where ".$condition;
                
    //             $sqltotaldashboard = "SELECT  COUNT(DISTINCT CASE WHEN t.submitdate >= '$cdate' THEN t.ourrefno ELSE NULL END) as totallive, Count(DISTINCT CASE WHEN t.dt = '$max_dt' THEN t.ourrefno ELSE NULL END) AS totalfresh from $table_name as t";
    //             $sqltotaldashboard .=" LEFT JOIN $cate_table_name as tc ON t.ourrefno = tc.ourrefno";
    //             $sqltotaldashboard .=" LEFT JOIN category as ct ON ct.id=tc.categoryid";
    //             $sqltotaldashboard .=" LEFT JOIN industry as ti ON ti.id=ct.industry_id";
    //             $sqltotaldashboard .=" where 1=1";
    //         }
    //     }
    //     //echo $sqlrecord; die();
    //     if (!empty($userproduct['input_ntid_search']) && $userproduct['input_ntid_search'] != "" && isset($userproduct['input_ntid_search'])) {
    //         $ntids = $_POST['input_ntid_search'];
    //         $sql .= " AND t.id IN($ntids)";
    //     }
    //     if (!empty($userproduct['input_publish_date']) && $userproduct['input_publish_date'] != "" && isset($userproduct['input_publish_date'])) {
    //         $fdt = $_POST['input_publish_date'];
    //         $sql .= " AND t.dt='$fdt'";
    //     }
    //     /********** boq item query start***********/
    //     if(!empty($checkforboq)){
    //         foreach($checkforboq as $kboq => $kvboq){
    //             if($kvboq['match'] == 'Yes'){ // yes then not match BOQ    
    //             }else{ // match BOQ  
    //             }
    //         }
    //     }
    //     $sql_items = "";
    //     if (!empty($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != "") {
    //         $userkeyword = explode(",", $userproduct['input_s_keyword']);
    //         $userkeyword = array_filter($userkeyword); 
    //         for ($i = 0; $i < count($userkeyword); $i++) {
    //             $sql_items .= " lti.item LIKE '%" . $userkeyword[$i] . "%' OR ";
    //         }
    //         $sql_items = trim($sql_items);
    //         $sql_items = rtrim($sql_items,'OR');
    //         $sql_items = trim($sql_items); 
            
    //         $sql_items = " OR ($sql_items)";
    //     }
        
    //     $sql_items = "";
    //     /********** boq item query end***********/
        
    //     if (!empty($userproduct['input_s_product']) || !empty($userproduct['input_s_category']) || !empty($userproduct['input_s_subcategory']) || !empty($userproduct['input_s_eproduct']) || !empty($userproduct['input_s_ecategory']) || !empty($userproduct['input_s_esubcategory'])) {
                
    //         $product_ids = $userproduct['input_s_product'];
    //         $cat_ids = $userproduct['input_s_category'];
    //         $subcat_ids = $userproduct['input_s_subcategory'];
    //         $eproduct_ids = $userproduct['input_s_eproduct'];
    //         $ecat_ids = $userproduct['input_s_ecategory'];
    //         $esubcat_ids = $userproduct['input_s_esubcategory'];
            
    //         $str_query = "";
    //         if (!empty($userproduct['input_s_product']) || !empty($userproduct['input_s_category']) || !empty($userproduct['input_s_subcategory'])) {
    //                 if ($product_ids != "") {
    //                     $str_query .= " tc.industryid IN (" . $product_ids . ") OR";
    //                 }
    //                 if ($cat_ids != "") {
    //                     $str_query .= " tc.categoryid IN (" . $cat_ids . ") OR";
    //                 }
    //                 if ($subcat_ids != "") {
    //                     $str_query .= " tc.subcategory IN (" . $subcat_ids . ") OR";
    //                 }
    //                 $str_query = trim($str_query);
    //                 $str_query = rtrim($str_query,'OR');
    //                 $str_query = trim($str_query);
    //         }
    //         $str_query2 = "";
    //         if (!empty($userproduct['input_s_eproduct']) || !empty($userproduct['input_s_ecategory']) || !empty($userproduct['input_s_esubcategory'])) {
    //             $str_query2 .= "SELECT ilc.rid FROM $cate_table_name as ilc LEFT JOIN category as iec ON ilc.categoryid=iec.id WHERE ";
    //             if ($eproduct_ids != "") {
    //                 $str_query2 .= " iec.industry_id IN (" . $eproduct_ids . ") OR"; //AND g
    //             }
    //             if ($ecat_ids != "") {
    //                 $str_query2 .= " ilc.categoryid IN (" . $ecat_ids . ") OR"; //AND g
    //             }
    //             if ($esubcat_ids != "") {
    //                 $str_query2 .= " ilc.subcategory IN (" . $esubcat_ids . ") OR"; //AND g
    //             }
    //             $str_query2 = trim($str_query2);
    //             $str_query2 = rtrim($str_query2,'OR'); //AND g
    //             $str_query2 = trim($str_query2);
    //         }
    //         $sql .= " AND ( ";
    //         if($str_query != "" && $str_query2 != ""){
    //             $sql .=  "(".$str_query.")";
    //         }else if($str_query != ""){    
    //             $sql .=  "(".$str_query.")";
    //         }else if($str_query2 != ""){  
    //         }
            
    //         if (isset($userproduct['input_isexactkeyword_values']) && $userproduct['input_isexactkeyword_values'] == 1) {
    //             if (!empty($userproduct['input_s_keyword'])) {
    //                 if (!empty($userproduct['input_s_product']) || !empty($userproduct['input_s_category']) || !empty($userproduct['input_s_subcategory'])) {
    //                     $sql .= " OR ( ";
    //                 } else {
    //                     $sql .= " ( ";
    //                 }
                    
    //                 $userkeyword = explode(",", $userproduct['input_s_keyword']);
    //                 $userkeyword = array_filter($userkeyword);
    //                 $sstr_ekeyword = "";
    //                 for ($i = 0; $i < count($userkeyword); $i++) {
    //                     $sstr_ekeyword .= " t.title LIKE '% " . $userkeyword[$i] . " %' OR ";
    //                 }
    //                 $sstr_ekeyword = trim($sstr_ekeyword);
    //                 $sstr_ekeyword = rtrim($sstr_ekeyword,'OR');
    //                 $sstr_ekeyword = trim($sstr_ekeyword);
    //                 $sql .= $sstr_ekeyword;
    //                 $sql .= " ) ";
    //             }
    //         } else {
    //             if($type == "searching"){
    //                 if (!empty($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != "") {
    //                         $arr_seleced_keywords = explode(',',$userproduct['input_s_keyword']);  
    //                         $keyword_query = "";
    //                         foreach($arr_seleced_keywords as $selecykey => $selectvalue){
    //                             $keyword_items = preg_replace('/[^a-z A-Z 0-9]/', ' ', $selectvalue); 
    //                             $arr_keyword = explode(' ',trim($keyword_items));
    //                             $keyword_str = '';
    //                             //print_r($arr_keyword);die();
    //                             foreach($arr_keyword as $k => $val){
    //                                 $kval = strtolower($val);
    //                                 $kval = trim($kval);
    //                                 if(strlen($kval) > 2){
    //                                 $kval = '+'.$kval.' ';
    //                                 $keyword_str .= $kval;
    //                                 }
    //                             } 
    //                             $keyword_str = trim($keyword_str);
    //                             $keyword_query .= " (MATCH (t.title) AGAINST ('$keyword_str' IN BOOLEAN MODE)) OR"; 
    //                         }
    //                         $keyword_query = trim($keyword_query);
    //                         $keyword_query = rtrim($keyword_query,'OR');
    //                         $keyword_query = trim($keyword_query);
    //                         $sql .= " OR (".$keyword_query.")";
    //                         //echo $sql;die(); 
    //                 }
    //             }else{ 
    //                 if (!empty($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != "") {
    //                     //$sql .= " OR ( ";
    //                     if (!empty($userproduct['input_s_product']) || !empty($userproduct['input_s_category']) || !empty($userproduct['input_s_subcategory'])) {
    //                         $sql .= " OR ( ";
    //                     } else {
    //                         $sql .= " ( ";
    //                     }
    //                     $userkeyword = explode(",", $userproduct['input_s_keyword']);
    //                     $userkeyword = array_filter($userkeyword);
    //                     $sstr_keyword = "";
    //                     for ($i = 0; $i < count($userkeyword); $i++) {
    //                             $sstr_keyword .= " t.title LIKE '%" . $userkeyword[$i] . "%' OR ";
    //                     }
    //                     $sstr_keyword = trim($sstr_keyword);
    //                     $sstr_keyword = rtrim($sstr_keyword,'OR');
    //                     $sstr_keyword = trim($sstr_keyword);
    //                     $sql .= $sstr_keyword;
    //                     $sql .= " ) ";
    //                 } 
    //             }
    //         }
                    
    //         $sql .= " $sql_items ) "; // gautishpatel
            
    //         if($str_query2 != ""){    
    //             $sql .=  " AND t.id NOT IN (".$str_query2.")";
    //         }
    //         //echo $sql;die();
    //     } else { // only keywordwise
    //         if (isset($userproduct['input_isexactkeyword_values']) && $userproduct['input_isexactkeyword_values'] == 1) {
                
    //             if (!empty($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != "") {
    //                 $userkeyword = explode(",", $userproduct['input_s_keyword']);
    //                 $userkeyword = array_filter($userkeyword); 
    //                 for ($i = 0; $i < count($userkeyword); $i++) {
    //                     if (count($userkeyword) == 1) {
    //                         $sql .= " AND (t.title  LIKE '% " . $userkeyword[$i] . " %' $sql_items)";
    //                     }
    //                     if (count($userkeyword) > 1) {
    //                         if ($i == 0) {
    //                             $sql .= " AND ((t.title LIKE '% " . $userkeyword[$i] . " %' OR ";
    //                         } else if ($i == (count($userkeyword) - 1)) {
    //                             $sql .= " t.title LIKE '% " . $userkeyword[$i] . " %') $sql_items)";
    //                         } else {
    //                             $sql .= " t.title LIKE '% " . $userkeyword[$i] . " %' OR ";
    //                         }
    //                     }
    //                 }
    //             }
    //         } else {
                
    //             if($type == "searching"){
    //                 if (!empty($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != "") {
    //                         $arr_seleced_keywords = explode(',',$userproduct['input_s_keyword']);  
    //                         $keyword_query = "";
    //                         foreach($arr_seleced_keywords as $selecykey => $selectvalue){
    //                             $keyword_items = preg_replace('/[^a-z A-Z 0-9]/', ' ', $selectvalue); 
    //                             $arr_keyword = explode(' ',trim($keyword_items));
    //                             $keyword_str = '';
    //                             //print_r($arr_keyword);die();
    //                             foreach($arr_keyword as $k => $val){
    //                                 $kval = strtolower($val);
    //                                 $kval = trim($kval);
    //                                 if(strlen($kval) > 2){
    //                                 $kval = '+'.$kval.' ';
    //                                 $keyword_str .= $kval;
    //                                 }
    //                             } 
    //                             $keyword_str = trim($keyword_str);
    //                             $keyword_query .= " (MATCH (t.title) AGAINST ('$keyword_str' IN BOOLEAN MODE)) OR"; 
    //                         }
    //                         $keyword_query = trim($keyword_query);
    //                         $keyword_query = rtrim($keyword_query,'OR');
    //                         $keyword_query = trim($keyword_query);
    //                         $sql .= " AND (".$keyword_query.")";
    //                         //echo $sql;die(); 
    //                 }
    //             }else{  
                    
    //                 if (!empty($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != "") {
                        
    //                     $userkeyword = explode(",", $userproduct['input_s_keyword']);
    //                     $userkeyword = array_filter($userkeyword); 
    //                     for ($i = 0; $i < count($userkeyword); $i++) {
    //                         if (count($userkeyword) == 1) {
    //                             $sql .= " AND (t.title  LIKE '%" . $userkeyword[$i] . "%' $sql_items)";
    //                         }
    //                         if (count($userkeyword) > 1) {
    //                             if ($i == 0) {
    //                                 $sql .= " AND ((t.title LIKE '%" . $userkeyword[$i] . "%' OR ";
    //                             } else if ($i == (count($userkeyword) - 1)) {
    //                                 $sql .= " t.title LIKE '%" . $userkeyword[$i] . "%') $sql_items)";
    //                             } else {
    //                                 $sql .= " t.title LIKE '%" . $userkeyword[$i] . "%' OR ";
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }
    //     //echo $sql;die();
        
    //     if (isset($userproduct['input_s_org']) && $userproduct['input_s_org'] != 0 && $userproduct['input_s_org'] != "") {
    //         $sql .= " AND t.agency_id IN (" . $userproduct['input_s_org'] . ")";
    //     }
    //     if (isset($userproduct['input_s_eorg']) && $userproduct['input_s_eorg'] != 0 && $userproduct['input_s_eorg'] != "") {
    //         $sql .= " AND t.agency_id NOT IN (" . $userproduct['input_s_eorg'] . ")";
    //     }
    //     if (isset($userproduct['input_estimate_values']) && $userproduct['input_estimate_values'] == 1) {    
    //         if (!empty($userproduct['input_min_amount']) && !empty($userproduct['input_max_amount'])) {
    //                 $sql .= " AND ((`t`.`awarded_value` >= '" . $userproduct['input_min_amount'] . "' AND `t`.`awarded_value` <= '" . $userproduct['input_max_amount'] . "') OR `t`.`awarded_value` = 0)";
    //         } else if (!empty($userproduct['input_min_amount']) && empty($userproduct['input_max_amount'])) {
    //             $sql .= " AND (`t`.`awarded_value` >= '" . $userproduct['input_min_amount'] . "' OR `t`.`awarded_value` = 0)";
    //         } else if (empty($userproduct['input_min_amount']) && !empty($userproduct['input_max_amount'])) {
    //             $sql .= " AND (`t`.`awarded_value` <= '" . $userproduct['input_max_amount'] . "' OR `t`.`awarded_value` = 0)";
    //         }
    //     }else{
    //         if (!empty($userproduct['input_min_amount']) && !empty($userproduct['input_max_amount']) && $userproduct['input_min_amount'] != "" && $userproduct['input_max_amount'] != "") {
    //                 $sql .= " AND (`t`.`awarded_value` >= '" . $userproduct['input_min_amount'] . "' AND `t`.`awarded_value` <= '" . $userproduct['input_max_amount'] . "')";
    //         } else if (!empty($userproduct['input_min_amount']) && empty($userproduct['input_max_amount'])) {
    //             $sql .= " AND (`t`.`awarded_value` >= '" . $userproduct['input_min_amount'] . "')";
    //         } else if (empty($userproduct['input_min_amount']) && !empty($userproduct['input_max_amount'])) {
    //             $sql .= " AND (`t`.`awarded_value` <= '" . $userproduct['input_max_amount'] . "')";
    //         }
    //     }
        
    //     if (!empty($userproduct['input_within_search']) && $userproduct['input_within_search'] != "") {
    //         $userrefinekeyword = explode(",", $userproduct['input_within_search']);
    //         $userrefinekeyword = array_filter($userrefinekeyword); 
    //         for ($i = 0; $i < count($userrefinekeyword); $i++) {
    //             if (count($userrefinekeyword) == 1) {
    //                 $sql .= " AND t.title  LIKE '%" . $userrefinekeyword[$i] . "%'";
    //             }
    //             if (count($userrefinekeyword) > 1) {
    //                 if ($i == 0) {
    //                     $sql .= " AND (t.title LIKE '%" . $userrefinekeyword[$i] . "%' OR ";
    //                 } else if ($i == (count($userrefinekeyword) - 1)) {
    //                     $sql .= " t.title LIKE '%" . $userrefinekeyword[$i] . "%')";
    //                 } else {
    //                     $sql .= " t.title LIKE '%" . $userrefinekeyword[$i] . "%' OR ";
    //                 }
    //             }
    //         }
    //     }
    //     if (isset($userproduct['input_s_ekeyword']) && $userproduct['input_s_ekeyword'] != '') {
    //         $userexcludingkeyword = explode(",", $userproduct['input_s_ekeyword']);
    //         for ($j = 0; $j < count($userexcludingkeyword); $j++) {
    //             if (count($userexcludingkeyword) == 1) {
    //                 $sql .= " AND t.title NOT LIKE '%" . $userexcludingkeyword[$j] . "%'";
    //             }
    //             if (count($userexcludingkeyword) > 1) {
    //                 if ($j == 0) {
    //                     $sql .= " AND (t.title NOT LIKE '%" . $userexcludingkeyword[$j] . "%' AND ";
    //                 } else if ($j == (count($userexcludingkeyword) - 1)) {
    //                     $sql .= " t.title NOT LIKE '%" . $userexcludingkeyword[$j] . "%')";
    //                 } else {
    //                     $sql .= " t.title NOT LIKE '%" . $userexcludingkeyword[$j] . "%' AND ";
    //                 }
    //             }
    //         }
    //     }
    //     $state_ncr = array();
    //     $state_ncr1 = array();
    //     if (isset($userproduct['input_s_state']) && $userproduct['input_s_state'] != 0 && $userproduct['input_s_state'] != "") {
    //         $state_ncr = explode(',', $userproduct['input_s_state']);
    //         if (isset($userproduct['input_s_city']) && $userproduct['input_s_city'] == '' && !empty($state_ncr) && in_array('380017', $state_ncr)) {
    //             $sql .= " AND ( t.state_id IN (" . $userproduct['input_s_state'] . ")";
    //             $sql .= " or t.city IN ('Bhiwani','Faridabad','Gurgaon','Jhajjar','Mahendragarh','Panipat','Rewari','Rohtak','Sonipat', 'Mewat' , 'Palwal' , 'Jind' , 'Karnal' , 'Baghpat' , 'Bulandshahr' ,'Gautam Buddha Nagar', 'Ghaziabad' , 'Muzaffarnagar' , 'Meerut' , 'Hapur' , 'Alwar' , 'Bharatpur','Noida','Delhi','New Delhi','SHAKURBASTI','TUGLAKABAD','Sakurbasit','Adarsh Nagar','Badli','Brar Square','Bijwasan','Chanakyapuri','Shivaji Bridge','Azadpur','Dayabasti','Delhi Cantt','Delhi Sarai Rohilla','Delhi KishanGanj','Old Delhi','Indrapuri','Shahdara','Sadar Bazar','Delhi Safdarjung','Ghevra','Holambi Kalan','Khera Kalan','Lodi Colony','Lajpat Nagar','Mangolpuri','Mundka','Naya Azadpur','Nangloi','Naraina Vihar','Narela','Delhi Hazrat Nizamuddin','Okhla','Pragati Maidan','Palam','Patel Nagar','Rajlu Garhi','Sardar Patel Road','Sandal Kalan','Shahabad Mohamadpur','Sarojini Nagar','Sewa Nagar','Delhi Sabzi Mandi','Tilak Bridge','Vivek Vihar','Vivekanand Puri Halt')";
    //             $sql .= " )";
    //         } else {
    //             $sql .= " AND t.state_id IN (" . $userproduct['input_s_state'] . ")";
    //         }
    //     }

    //     if (isset($userproduct['input_s_city']) && $userproduct['input_s_city'] != '') {
    //         $city_explode = explode(',', $userproduct['input_s_city']);
    //         $city1 = "'" . implode("','", $city_explode) . "'";
    //         $sql .= " AND t.city IN (" . $city1 . ")";
    //     }
        
    //     $sqltot = $sqltotal;
    //     $sqltot .= $sql;
    //     if($type == "dashboard"){
    //     $sqltotaldashboard .= $sql;
    //     }
    //     $sql .= " GROUP by `t`.`id`  ";
    //     if (isset($userproduct['sortby']) && !empty($userproduct['sortby'])) {
    //         if ($userproduct['sortby'] == 'hl') {
    //             $sql .= " order by t.awarded_value desc";
    //         } else if ($userproduct['sortby'] == 'lh') {
    //             $sql .= " order by t.awarded_value asc";
    //         } else if ($userproduct['sortby'] == 'ad') {
    //             $sql .= " order by aoc asc";
    //         } else if ($userproduct['sortby'] == 'da') {
    //             $sql .= " order by aoc desc";
    //         }else{
    //                 $sql .= " order by t.id desc";
    //         }
    //     } else {
    //         $sql .= " order by t.id desc";
    //     }
    //     $total_count = 0;
    //     $livecount = 0;
    //     if (!empty($sql)) {
            
    //         if($type == "dashboard"){
    //             $resultdata = array();
    //             $resultdata = DB::select($sqltotaldashboard);
    //         }else{
    //             $sqlrec = $sqlrecord; 
    //             $sqlrec .= $sql;
    //             $sqlrec .= " limit $page1,$per_page";
                
    //             //echo $sqlrec;
    //             //echo $sqltot;die();
    //             $resultdata = array();
    //             $resultdata = DB::select($sqlrec);
    //             if($page == 1){
    //                 //echo $sqltot;die();
                    
    //                 if(isset($userproduct['data'])){
    //                     if($userproduct['data'] == "archive" || $userproduct['data'] == "archive2021" || $userproduct['data'] == "archive2020"){
    //                          $total_count = "";
    //                          $livecount = "";
    //                     }else{
                            
    //                         if(!empty($resultdata)){
    //                             if($type == "searching"){
    //                             $total_count = "";
    //                             $livecount = "";
    //                             }else{
    //                             $total_count = "";
    //                             $livecount = "";
    //                             }
    //                         }
    //                     }
    //                 }else{
                      
    //                     //print_r($records);die();
    //                     $total_count = 0;
    //                     $a = $total_count / $per_page;
    //                     $livecount = ceil($a);
    //                 }
    //             }
    //         }
    //     } else {
    //         $resultdata = array();
    //         $total_count = 0;
    //         $livecount = 0;
    //     }
        
    //     $arrdata = array();
        
    //     $arrdata['resultdata'] = $resultdata;
    //     $arrdata['total_count'] = $total_count;
    //     $arrdata['livecount'] = $livecount;
    //     $arrdata['userkeyword'] = (isset($userproduct['input_s_keyword'])) ? $userproduct['input_s_keyword'] : '';
        
    //     return $arrdata; 
    //     exit;
    // }

}
