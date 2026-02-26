<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Auth;
use Session;
use DB;

class UserResultProduct extends Authenticatable
{
    use HasFactory, Notifiable;

    
    protected $table = 'user_result_product';
    
    protected $fillable = [
        'user_id',
    ];

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
            //$statenamequery = 't.state_name,t.stateid';
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
                           
                        //$searchtype = "(CASE WHEN t.title LIKE '%$keyword%' THEN 'Keyword' WHEN ($keyword_query) THEN 'BOQ' ELSE '' END) AS searchtype";
                        $sql = "SELECT t.id,t.aoc,t.awarded_value,Moneyformat(t.awarded_value) as ti_amount,t.Organisation,t.title,t.state_id,t.state as state_name,t.dt,t.city from tender_result_info as t where 1=1";
                        $sql1 = "SELECT COUNT(*) as total from tender_result_info as t where 1=1";
                    
                    
                            /*$sql .= " AND (( ";
                            $sql1 .= " AND (( ";
                            foreach ($searchKeyword as $i => $j) {
                                if ($i == 0) {
                                    $sql .= " t.title LIKE '%" . $j . "%'";
                                    $sql1 .= " t.title LIKE '%" . $j . "%'";
                                } else {
                                    $sql .= " or t.title LIKE '%" . $j . "%'";
                                    $sql1 .= " or t.title LIKE '%" . $j . "%'";
                                }
                            }*/
                            
                            //$sql .= " ) OR ($keyword_query))"; // boq enable $keyword_str
                            //$sql1 .= " ) OR ($keyword_query))"; // boq enable
                            
                            //$sql .= " ))"; // boq disable
                            //$sql1 .= " ))"; // boq disable
                            
                            $sql .= " AND ($keyword_query)"; //fulltext
                            $sql1 .= " AND ($keyword_query)";
                        
                    
                   
        }else{
            
           if(Auth::check()){
               
           }else{
               
           }
                if($type == 'category' || $type == 'subcategory'){
                    
                    
                     $sql = "SELECT t.id,t.aoc,t.awarded_value,Moneyformat(t.awarded_value) as ti_amount,t.Organisation,t.title,t.state_id,t.state as state_name,t.dt,t.city from tender_result_info as t
                     INNER JOIN tender_result_category as tc ON t.id = tc.rid
                     where 1=1";
                     $sql1 = "SELECT COUNT(DISTINCT t.id) as total from tender_result_info as t INNER JOIN tender_result_category as tc ON t.id = tc.rid where 1=1";
                  
                    
                }else{
                     $sql = "SELECT t.id,t.aoc,t.awarded_value,Moneyformat(t.awarded_value) as ti_amount,t.Organisation,t.title,t.state_id,t.state as state_name,t.dt,t.city from tender_result_info as t where 1=1";
                     $sql1 = "SELECT COUNT(*) as total from tender_result_info as t where 1=1";
                    
                 }
           
            
        }
            
          //echo $sql1;die();
          $sqlstring = "";
      
          //$sqlstring .= " AND t.link2 != 'https://www.nationaltenders_manually.com'";
          //$sql1 .= " AND t.link2 != 'https://www.nationaltenders_manually.com'";
          if($type == 'state'){
              //$sqlstring .= " AND t.state_name='$name'";
              $sqlstring .= " AND t.state_id='$selectedstateid'"; 
              //$sql1 .= " AND t.state_name='$name'";
          }else if($type == 'agency'){
              /*if($name == 'government e marketplace gem'){
               $sqlstring .= " AND (t.TenderNo LIKE '%GEM%')";
               //$sql1 .= " AND (t.TenderNo LIKE '%GEM%')";   
              }else{
              $sqlstring .= " AND t.agencyid='$selectedagencyid'";
              //$sql1 .= " AND t.agencyid='$selectedagencyid'";
              }*/
              
              $sqlstring .= " AND t.agency_id='$selectedagencyid'";
          }else if($type == 'category'){
              $sqlstring .= " AND tc.categoryid='$selectedcategoryid'";
              //$sql1 .= " AND tc.categoryid='$selectedcategoryid'";
          }else if($type == 'subcategory'){
              $sqlstring .= " AND (tc.categoryid='$selectedcategoryid' AND tc.subcategory='$selectedsubcategoryid')";
              //$sql1 .= " AND (tc.categoryid='$selectedcategoryid' AND tc.subcategory='$selectedsubcategoryid')";
          }else if($type == 'city'){
              if($selectedstateid!= "" && $cityname != ""){
              $sqlstring .= " AND (t.state_id=$selectedstateid AND t.city='$cityname')";
              //$sql1 .= " AND (t.stateid=$selectedstateid AND t.city='$cityname')";
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
            //$order_by = "CASE WHEN instr(t.Work, '$keyword') = 0 then 1 else 0 end,instr(t.Work, '$keyword')"; 
            //$sql .= " ORDER BY $order_by DESC LIMIT $page1,$per_page";
            //$order_by = "CASE WHEN instr(t.Work, '$keyword') = 0 then 1 else 0 end,instr(t.Work, '$keyword')"; 
            $sql .= " ORDER BY t.id DESC LIMIT $page1,$per_page";
            }else{         
            $sql .= " ORDER BY t.id DESC LIMIT $page1,$per_page";
            }
       }
        //$name,$type
        if($type == 'state'){
            //$sql1 = str_replace("COUNT(*) as total","t.state_name,t.stateid,COUNT(*) as total",$sql1); //gautish
            //echo $sql." ".$sql1;die();
        }
        
        if($type == 'agency'){
            //echo $name;
            //echo $sql." ".$sql1;die();
        }
        
        if($type == 'keyword'){
            
             /*if(trim($keyword) != ""){
                if (Auth::check()) {
                    //$sql1 .= $sqlstring;
                }else{
                    
                    if (!empty($sub_id)) {
                    
                        if($if_check_cat == "Yes"){ // in execlude category
                          //$sql1 .= $sqlstring;
                        }else{
                        $sql1 = str_replace("SELECT COUNT(DISTINCT t.ourrefno) as total","SELECT COUNT(DISTINCT ourrefno) as total FROM (SELECT t.ourrefno",$sql1);
                        $sql1 .= " UNION ALL SELECT lti.ourrefno from live_tenderinfo_items as lti INNER JOIN live_tenders as it ON it.ourrefno=lti.ourrefno WHERE date(it.submitdate) >= '".date('Y-m-d')."' and ($keyword_query)";
                        $sql1 .= " ) as tbl";
                        }
                    }else{
                        $sql1 = str_replace("SELECT COUNT(DISTINCT t.ourrefno) as total","SELECT COUNT(DISTINCT ourrefno) as total FROM (SELECT t.ourrefno",$sql1);
                        $sql1 .= " UNION ALL SELECT lti.ourrefno from live_tenderinfo_items as lti INNER JOIN live_tenders as it ON it.ourrefno=lti.ourrefno WHERE date(it.submitdate) >= '".date('Y-m-d')."' and ($keyword_query)";
                        $sql1 .= " ) as tbl";
                    }
                    
                    
                    
                }
                  
              }else{
                  //$sql1 .= $sqlstring;
              }*/
      
            
            
            //echo $sql." ".$sql1;die();
        }
        
        //echo $sql." ".$sql1;die();
        $liveTender = array();
        $liveTender = DB::select($sql);
         
        $total = 0;
        /*if(!empty($liveTender)){
            $records = DB::select($sql1);
            $total = $records[0]->total;
            
        }*/
        //if($total != 0){
           
        //}
        
        // if($type == 'state'){
        //     $selectedstatename = $records[0]['state_name'];
        //     $selectedstateid = $records[0]['stateid'];
        // }
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
        // $search_type = '';
        // $search_type = $_POST['search_type'];
        $filter_search = '';
        $keyword_search = '';
        
        if(Auth::check()){
            
         
        }else{  // not set login session 
         
             
        }
        
        $cdate = date('Y-m-d');
        $max_dt = date('Y-m-d', strtotime('-1 day', strtotime($cdate)));
        
        if(isset($userproduct['data']) && $userproduct['data'] == 'fresh'){
        // $sql_fresh_d = "SELECT MAX(dt) as max_date from live_tenders";
        // $max_dt = $max_fresh_dt['0']['max_date'];
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
            //$condition = 'date(t.submitdate) >= "'. date('Y-m-d') .'"';
            $condition = "1=1";
        }
        
        $table_name = 'tender_result_info';
        $cate_table_name = 'tender_result_category';
        //$table_items = "live_tenderinfo_items";
        
        //after login
        $sql = "";
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->user_id;
            
        } 
        
        //for frontend logic 
        if($type == "searching"){
            
            /*if (!empty($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != "") {
               
                if (Auth::check()) {
                    
                }else{
                     
                    //$searc_session = preg_replace('/[^a-z A-Z 0-9]/', ' ', $userproduct['input_s_keyword']);
                    $searc_session = $userproduct['input_s_keyword'];
                    $str2 = str_replace(', ', ',', $searc_session);
                    $str_3 = rtrim($str2, ',');
                    $searchKeyword = explode(',', $str_3); 
                    $searchKeyword = array_unique(array_filter($searchKeyword)); 
                    $filterkeyarray = array();
                    foreach($searchKeyword as $ski=> $sk){
                        $filterkeyarray[$ski] = trim(preg_replace('/[^a-z A-Z 0-9]/', ' ', $sk));
                    }
                    $l_k_array = '"' . implode('","', $filterkeyarray) . '"';
                    
                   
                    $checksubcategorysql = "SELECT keyword.name,keyword.subcategory,CASE WHEN search_exclude_subcategory.subcat IS NULL THEN 'No' ELSE 'Yes' END AS search FROM `keyword` LEFT JOIN search_exclude_subcategory ON keyword.subcategory=search_exclude_subcategory.subcat WHERE keyword.name IN($l_k_array)";
                    //echo $checksubcategorysql;die();
                    $matchsubcategory = DB::select($checksubcategorysql);
                    $if_check_cat = "";
                    $match_subid = array();
                    $inputsubcategory = array();
                    $checkforboq = array();
                    if (!empty($matchsubcategory)) {
                        foreach ($matchsubcategory as $ksub => $vsub) {
                            $match_subid[$ksub]['id'] = $vsub->subcategory;
                            $match_subid[$ksub]['match'] = $vsub->search;
                            $match_subid[$ksub]['name'] = $vsub->name;
                            //$if_check_cat = $vsub->search;
                            
                        }
                        if($if_check_cat == "Yes"){ // in execlude category
                        
                        }else{
                            
                        }
                        
                        $boqkey = 0;
                        foreach ($match_subid as $kmsub => $vmsub) {
                            $inputsubcategory[$kmsub] = $vmsub['id'];
                            if(in_array($vmsub['name'],$filterkeyarray)){
                               $checkforboq[$boqkey]['name'] = $vmsub['name'];
                               $checkforboq[$boqkey]['match'] = $vmsub['match'];
                               $boqkey++;
                            }
                        }
                        foreach ($filterkeyarray as $fk => $fv) {
                          $keycheck = array_keys(array_combine(array_keys($match_subid), array_column($match_subid, 'name')),$fv);
                          if(empty($keycheck)){
                            array_push($checkforboq,array('name'=>$fv,'match' => 'No'));
                          }
                        }
                        
                        $inputsubcategory = array_unique(array_filter($inputsubcategory));
                        if(!empty($inputsubcategory)){
                            $selectsubcategory = '';
                            if($userproduct['input_s_subcategory'] != ""){
                                $selectsubcategory = $userproduct['input_s_subcategory'].','.implode(',', $inputsubcategory); //selected subcategory merge
                            }else{
                               $selectsubcategory = implode(',', $inputsubcategory);
                            }
                            $userproduct['input_s_subcategory'] = $selectsubcategory; // keyword subcategory and selected subcategory merge
                        }
                        
                        //echo $selectsubcategory;die();
                        
                    }
                
                }
                
            }*/
            
        }
        
            if(isset($userproduct['data']) && $userproduct['data'] == 'favourite'){
            if (Auth::check()) {
                
                /*$sqlrecord = "SELECT t.ourrefno,t.purfromdate,t.Work,t.submitdate,t.earnestamount,t.doccost,t.tenderamount,Moneyformat(t.tenderamount) as ti_amount,DATE_FORMAT(t.submitdate, '%a %D %b, %Y') as show_ti_submit_date,t.city,t.org_name as agencyname,t.state_name as name,tc.categoryid,tc.ourrefno,tc.subcategory,'India' as country,tl.user_id,tl.tender_id from $table_name as t
    					INNER JOIN $cate_table_name as tc ON t.ourrefno = tc.ourrefno
    					LEFT JOIN category as ct ON ct.id=tc.categoryid 
    					LEFT JOIN industry as ti ON ti.id=ct.industry_id 
    				    LEFT JOIN tenderlike as tl ON tl.tender_id = t.ourrefno where t.ourrefno = tc.ourrefno  AND tl.user_id=" . $user_id;
    					//	LEFT JOIN $table_items as lti ON t.ourrefno=lti.ourrefno
    			$sqltotal = "SELECT COUNT(*) as total from $table_name as t
    					INNER JOIN $cate_table_name as tc ON t.ourrefno = tc.ourrefno
    					LEFT JOIN category as ct ON ct.id=tc.categoryid 
    					LEFT JOIN industry as ti ON ti.id=ct.industry_id 
    					LEFT JOIN tenderlike as tl ON tl.tender_id = t.ourrefno where t.ourrefno = tc.ourrefno  AND tl.user_id=" . $user_id;*/
    					//LEFT JOIN $table_items as lti ON t.ourrefno=lti.ourrefno
					
            }else{
                
            }	
						
            }else{
                
                if ((isset($userproduct['input_s_product']) && $userproduct['input_s_product'] == "") && (isset($userproduct['input_s_category']) && $userproduct['input_s_category'] == "") && (isset($userproduct['input_s_subcategory']) && $userproduct['input_s_subcategory'] == "") && (isset($userproduct['input_s_eproduct']) && $userproduct['input_s_eproduct'] == "") && (isset($userproduct['input_s_ecategory']) && $userproduct['input_s_ecategory'] == "") && (isset($userproduct['input_s_esubcategory']) && $userproduct['input_s_esubcategory'] == "") && (isset($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != "")) {
                    
                     $sqlrecord = "SELECT t.id,t.aoc,t.awarded_value,Moneyformat(t.awarded_value) as ti_amount,t.Organisation,t.title,t.state_id,t.state as state_name,t.dt,t.city from $table_name as t
                     where ".$condition;
                     $sqltotal = "SELECT COUNT(*) as total from $table_name as t 
                     where ".$condition;
                     
                    $sqltotaldashboard = "SELECT COUNT(DISTINCT CASE WHEN t.submitdate >= '$cdate' THEN t.ourrefno ELSE NULL END) as totallive, Count(DISTINCT CASE WHEN t.dt = '$max_dt' THEN t.ourrefno ELSE NULL END) AS totalfresh from $table_name as t  where 1=1";
                    
                }else if ((isset($userproduct['input_s_product']) && $userproduct['input_s_product'] == "") && (isset($userproduct['input_s_category']) && $userproduct['input_s_category'] == "") && (isset($userproduct['input_s_subcategory']) && $userproduct['input_s_subcategory'] == "") && (isset($userproduct['input_s_eproduct']) && $userproduct['input_s_eproduct'] == "") && (isset($userproduct['input_s_ecategory']) && $userproduct['input_s_ecategory'] == "") && (isset($userproduct['input_s_esubcategory']) && $userproduct['input_s_esubcategory'] == "") && (isset($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] == "")) {
                     
                     $sqlrecord = "SELECT t.id,t.aoc,t.awarded_value,Moneyformat(t.awarded_value) as ti_amount,t.Organisation,t.title,t.state_id,t.state as state_name,t.dt,t.city from $table_name as t
                     where ".$condition;
                     $sqltotal = "SELECT COUNT(*) as total from $table_name as t 
                     where ".$condition;
                     
                    $sqltotaldashboard = "SELECT COUNT(DISTINCT CASE WHEN t.submitdate >= '$cdate' THEN t.ourrefno ELSE NULL END) as totallive, Count(DISTINCT CASE WHEN t.dt = '$max_dt' THEN t.ourrefno ELSE NULL END) AS totalfresh from $table_name as t  where 1=1";
                   
                }else{
                    
                     $sqlrecord = "SELECT t.id,t.aoc,t.awarded_value,Moneyformat(t.awarded_value) as ti_amount,t.Organisation,t.title,t.state_id,t.state as state_name,t.dt,t.city from $table_name as t
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
            
            //$sql .= " AND t.link2 != 'https://www.nationaltenders_manually.com'";
            
            //if (!empty($_POST['search_data'])) {
                //$sql .= " AND t.Work LIKE '%" . $_POST['search_data'] . "%' ";
            //}
            
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
                    
                        //$sql .= " AND ( ";
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
                        
                        //$sql .=  $str_query;
                        //$sql .= " ) ";
                    
                	}
                   $str_query2 = "";
                   if (!empty($userproduct['input_s_eproduct']) || !empty($userproduct['input_s_ecategory']) || !empty($userproduct['input_s_esubcategory'])) {
                    //$sql .= " AND ( ";
                        $str_query2 .= "SELECT ilc.rid FROM $cate_table_name as ilc LEFT JOIN category as iec ON ilc.categoryid=iec.id WHERE ";
                        if ($eproduct_ids != "") {
                            //$str_query2 .= " ti.id NOT IN (" . $eproduct_ids . ") AND";
                            $str_query2 .= " iec.industry_id IN (" . $eproduct_ids . ") OR"; //AND g
                        }
                        if ($ecat_ids != "") {
                            //$str_query2 .= " tc.categoryid NOT IN (" . $ecat_ids . ") AND";
                            $str_query2 .= " ilc.categoryid IN (" . $ecat_ids . ") OR"; //AND g
                        }
                        if ($esubcat_ids != "") {
                            //$str_query2 .= " tc.subcategory NOT IN (" . $esubcat_ids . ") AND";
                            $str_query2 .= " ilc.subcategory IN (" . $esubcat_ids . ") OR"; //AND g
                        }
                        $str_query2 = trim($str_query2);
                        $str_query2 = rtrim($str_query2,'OR'); //AND g
                        $str_query2 = trim($str_query2);
                        
                        //$sql .=  $str_query2;
                    //$sql .= " ) ";
                   }
                     $sql .= " AND ( ";
                        if($str_query != "" && $str_query2 != ""){
                            $sql .=  "(".$str_query.")";
                            //$sql .=  " AND t.ourrefno NOT IN (".$str_query2.")";
                        }else if($str_query != ""){    
                            $sql .=  "(".$str_query.")";
                        }else if($str_query2 != ""){    
                            //$sql .=  "(".$str_query2.")";
                            //$sql .=  " t.ourrefno NOT IN (".$str_query2.")";
                            
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
            
            
                /*if ($userproduct['categoryid'] != 0 && $userproduct['categoryid'] != '') {
                    $sql .= " AND tc.categoryid IN (" . $userproduct['categoryid'] . ")";
                }
                if ($userproduct['subcategoryid'] != 0 && $userproduct['subcategoryid'] != '') {
                    $sql .= " AND tc.subcategory IN (" . $userproduct['subcategoryid'] . ")";
                }*/
                
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

            /*if (!empty($userproduct['form_of_contract'])) {
                $my_contract = explode(',', $userproduct['form_of_contract']);
                $contract = "'" . implode("','", $my_contract) . "'";
                $sql .= " AND (`t`.`form_of_contract` in ($contract) or `t`.`form_of_contract` ='')";
            }*/
            
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
            /*
              if ($userproduct['state'] != 0) {
              $sql .= " AND t.stateid IN (" . $userproduct['state'] . ")";
              } */
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
            //if(in_array('380017',))
            //for delhi ncr
            /*
              if ($userproduct['city'] != '') {
              $city_explode = explode(',', $userproduct['city']);
              $city1 = "'" . implode("','", $city_explode) . "'";
              $sql .= " AND t.city IN (" . $city1 . ")";
              }
             */

            if (isset($userproduct['input_s_city']) && $userproduct['input_s_city'] != '') {
                $city_explode = explode(',', $userproduct['input_s_city']);
                //check for nearby cities
                 /*$nearby_city = array();
                foreach ($city_explode as $k2 => $j2) {
                    $my_nearby_city = "select cities from nearby_city where cities like '%" . $j2 . "%'";
                    $command_p = $connection->createCommand($my_nearby_city);
                    $dataReader_p = $command_p->query();
                    $nearby_city_list = $dataReader_p->readAll();
                    if (!empty($nearby_city_list['0']['cities'])) {
                        $nearby_city[] = $nearby_city_list['0']['cities'];
                    }
                }

                if (!empty($nearby_city)) {
                    $my_implode_city = implode(',', $nearby_city);
                    $my_explode_city = explode(',', $my_implode_city);
                    $my_explode_city = array_unique(array_filter($my_explode_city));
                    $city_explode = array_merge($city_explode, $my_explode_city);
                }*/
                $city1 = "'" . implode("','", $city_explode) . "'";
                $sql .= " AND t.city IN (" . $city1 . ")";
            }
            
            /*if ($userproduct['websites'] != '') {
                 $websites_explode = explode(',', $userproduct['websites']);
                 $websites = "'" . implode("','", $websites_explode) . "'";
                 $sql .= " AND t.link2 IN (" . $websites . ")";
            }*/
           
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
                //$sql1 = $sql;
                //$sql1 .= " limit 0,200";
                $sqlrec .= " limit $page1,$per_page";
                
                //echo $sqlrec;
                //echo $sqltot;die();
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
                                if($type == "searching"){
                                //$records = DB::select($sqltot);
                                ///$total_count = $records[0]->total;
                                //$a = $total_count / $per_page;
                                //$livecount = ceil($a);
                                $total_count = "";
                                $livecount = "";
                                }else{
                                $total_count = "";
                                $livecount = "";
                                }
                            }
                        }
                    }else{
                      
                        //print_r($records);die();
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
        //$arrdata['data'] = $userproduct['data'];
        $arrdata['userkeyword'] = (isset($userproduct['input_s_keyword'])) ? $userproduct['input_s_keyword'] : '';
        
        return $arrdata; 
        exit;
    }
    public function tenderresultdetails($id){
       
       $model = DB::table('tender_result_info')
                    ->where('id',$id)
                    ->first();
        /*if(empty($model)){
        $model = DB::table('tender_2021')
                    ->where('ourrefno',$id)
                    ->first();
        }
        if(empty($model)){
        $model = DB::table('tender_2020')
                    ->where('ourrefno',$id)
                    ->first();
        }*/
        
        if(!$model){
        //$sql = "SELECT t.*,t.org_name as agencyname,'India' as country,t.state_name as name FROM `tenderinfo_2017` `t` ORDER BY t.ourrefno DESC LIMIT 1";
        $model = DB::table('tender_result_info')
                    ->orderby('id','desc')
                    ->first();
        }
        return $model;
        
    }
    public function bidtenderdetails($id){
        $model = DB::table('bid_tenderinfo')
                    ->where('ourrefno',$id)
                    ->first();
          return $model;          
           //dd($model);         
    }
    public function checktenderresultdownload($id){
        $is_download = 0;
        $msg = "";
        $tendertodate = "";
        $user = Auth::user();
        $todays = date('Y-m-d');
        
        if(Auth::check()){
            $T = $user->is_result;
            //$status = $user->status;
            $usertype = $user->status;
            //$W = $user->workuser;
            //$R = $user->result_user;
            if(Session::has('tenderresulttodate')){
                $tendertodate = Session::get('tenderresulttodate');
            }
            // if(Session::has('tenderresulttodate')){
            //   $tenderresulttodate = Session::get('tenderresulttodate');
            // }
            
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
    public function checkemailtenderresultdownload($id,$userid){
        $is_download = 0;
        $msg = "";
        $tendertodate = "";
        $user = DB::table('users')->where('id',$userid)->first();
        $todays = date('Y-m-d');
        
        if($user){
            $T = $user->is_result;
            $status = $user->status;
            //$usertype = $user->user_active_indicator;
            //$W = $user->workuser;
            //$R = $user->result_user;
            
            // $tendertodate = "";
            // $usersubscription = DB::table('user_result_subscription')->where('user_id',$userid)->first();
            // dd($usersubscription);
            // if($usersubscription){
            // $tendertodate = $usersubscription->todate;
            // }
            
            $userproductstate = "";
            $userproduct = DB::table('user_result_product')->where('user_id',$userid)->first();

            if($userproduct){
                $userproductstate = $userproduct->state;
                $tendertodate = $userproduct->todate;
            }
            // if(Session::has('tenderresulttodate')){
            //   $tenderresulttodate = Session::get('tenderresulttodate');
            // }
            
           
            if($T == 1){
                    if($status == "Paid"){
                       if ($tendertodate >= $todays) { // || $bidding_status == "Live"
                          //dd($id);  
                          if($tendertodate != ""){
                             
                                //$myuserproduct = Session::get('loginuser.tenderresult.filter.0');
                                if($userproductstate == "" || is_null($userproductstate)){ // all state
                                  $is_download = 1;
                                  $msg = "success";
                                }else{
                                    $statearray = explode(',',$userproductstate);
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
}
