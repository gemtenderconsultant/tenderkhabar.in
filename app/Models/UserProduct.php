<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Auth;
use DB;
use Session;

class UserProduct extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
     //protected $connection = 'mysql2';
     
     protected $table = 'userproduct'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'keyword',
    ];

    public function formatInIndianStyle($get_amt) {
        $amt_explode = explode('.', $get_amt);
        $amt = $amt_explode['0'];
        $amount = strlen($amt_explode['0']);
        if ($amount == 4) {
            $result = substr($amt, 0, 3);
            $my_amount = number_format(($result / 100), 2);
            return $my_amount . " Thousand";
        } else if ($amount == 5) {
            $result = substr($amt, 0, 4);
            $my_amount = number_format(($result / 100), 2);
            return $my_amount . " Thousand";
        } else if ($amount == 6) {
            $result = substr($amt, 0, 3);
            $my_amount = number_format(($result / 100), 2);
            return $my_amount . " Lakh";
        } else if ($amount == 7) {
            $result = substr($amt, 0, 4);
            $my_amount = number_format(($result / 100), 2);
            return $my_amount . " Lakh";
        } else if ($amount == 8) {
            $result = substr($amt, 0, 3);
            $my_amount = number_format(($result / 100), 2);
            return $my_amount . " CR";
        } else if ($amount == 9) {
            $result = substr($amt, 0, 4);
            $my_amount = number_format(($result / 100), 2);
            return $my_amount . " CR";
        } else if ($amount == 10) {
            $result = substr($amt, 0, 5);
            $my_amount = number_format(($result / 100), 2);
            return $my_amount . " CR";
        } else if ($amount == 11) {
            $result = substr($amt, 0, 6);
            $my_amount = number_format(($result / 100), 2);
            return $my_amount . " CR";
        } else if ($amount == 12) {
            $result = substr($amt, 0, 7);
            $my_amount = number_format(($result / 100), 2);
            return $my_amount . " CR";
        } else if ($amount == 13) {
            $result = substr($amt, 0, 8);
            $my_amount = number_format(($result / 100), 2);
            return $my_amount . " CR";
        } else if ($amount == 14) {
            $result = substr($amt, 0, 9);
            $my_amount = number_format(($result / 100), 2);
            return $my_amount . " CR";
        }else{
            return $get_amt;
        }
    }
    public function actionGettendersdata($name,$type){
        //dd($name.$type);
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
            $name = str_replace('tenders', '', $name);
            $name = str_replace('online tender', '', $name);
            $name = trim($name);
            
            $getagencydata = DB::table('state')
                ->where(DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name, '/', ''), '(', ''),')',''),'.',''),',',''),'&','')"), $name)
                ->first();
             if($getagencydata){
                $selectedstateid = $getagencydata->id; 
                $selectedstatename = $getagencydata->name; 
             }else{
                $getagencydata = DB::table('state')
                ->where('id',356007)
                ->first();
                $selectedstateid = $getagencydata->id; 
                $selectedstatename = $getagencydata->name; 
             }   
            //$statenamequery = 't.state_name,t.stateid';
           

        }else if($type == 'agency'){
            $name = str_replace('-', ' ', $name);
            $name = str_replace('tenders', '', $name);
            $name = str_replace('online tender', '', $name);
            $name = trim($name);
            if($name == 'government e marketplace gem'){
                $getagencydata = DB::table('agency')
                ->where('agencyid', 25703)
                ->first();
            }else{
            $getagencydata = DB::table('agency')
                ->where(DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(agencyname, '/', ''), '(', ''),')',''),'.',''),',',''),'&','')"), $name)
                ->first();
            }

            if($getagencydata){
                $selectedagencyid = $getagencydata->agencyid;
                $selectedagencyname = $getagencydata->agencyname; 
            }else{
                $getagencydata = DB::table('agency')
                ->where('agencyid',3002)
                ->first();
                $selectedagencyid = $getagencydata->agencyid;
                $selectedagencyname = $getagencydata->agencyname; 
            }    
            
            
            
        }else if($type == 'category'){
            $name = str_replace('-', ' ', $name);
            $name = str_replace('tenders', '', $name);
            $name = str_replace('online tender', '', $name);
            $name = trim($name);
            $getagencydata = DB::table('category')
                ->where(DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name, '/', ''), '(', ''),')',''),'.',''),',',''),'&','')"), $name)
                ->first();
            if($getagencydata){
                $selectedcategoryid = $getagencydata->id;
                $selectedcategoryname = $getagencydata->name;
            }else{
                $getagencydata = DB::table('category')
                ->where('id',83)
                ->first();
                $selectedcategoryid = $getagencydata->id;
                $selectedcategoryname = $getagencydata->name;
            }    
            
            
        }else if($type == 'subcategory'){
             
            $name = str_replace('-', ' ', $name);
            $name = str_replace('tenders', '', $name);
            $name = str_replace('online tender', '', $name);
            $name = trim($name);
            
            $getagencydata = DB::table('subcategory')
                ->select('subcategory.*', 'category.name as cname')
                ->leftjoin('category', 'subcategory.categoryid', '=', 'category.id')
                ->where(DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(subcategory.name, '/', ''), '(', ''),')',''),'.',''),',',''),'&','')"), $name)
                ->first();
            if($getagencydata){
                $selectedcategoryid = $getagencydata->categoryid; 
                $selectedcategoryname = $getagencydata->cname; 
                $selectedsubcategoryid = $getagencydata->id; 
                $selectedsubcategoryname = $getagencydata->name;  
            } else{

                $getagencydata = DB::table('subcategory')
                ->select('subcategory.*', 'category.name as cname')
                ->leftjoin('category', 'subcategory.categoryid', '=', 'category.id')
                ->where('subcategory.id',569)
                ->first();
                $selectedcategoryid = $getagencydata->categoryid; 
                $selectedcategoryname = $getagencydata->cname; 
                $selectedsubcategoryid = $getagencydata->id; 
                $selectedsubcategoryname = $getagencydata->name; 
            }   
            

        }else if($type == 'city'){
            
            $cityname = str_replace('-', ' ', $name);
            $cityname = str_replace('tenders', '', $cityname);
            $cityname = trim($cityname);
            
            $getcitydata = DB::table('city')
                ->select('city.*', 'state.name as sname')
                ->leftjoin('state', 'city.state_id', '=', 'state.id')
                ->where("city.name", $cityname)
                ->first();
            if($getcitydata){
            $selectedstateid = $getcitydata->state_id; 
            $selectedstatename = $getcitydata->sname; 
            $selectedcity = $getcitydata->name; 
            $selectedcityid = $getcitydata->id;  
            }else{
                $getcitydata = DB::table('city')
                ->select('city.*', 'state.name as sname')
                ->leftjoin('state', 'city.state_id', '=', 'state.id')
                ->where("city.name", 'ahmedabad')
                ->first();
                $selectedstateid = $getcitydata->state_id; 
                $selectedstatename = $getcitydata->sname; 
                $selectedcity = $getcitydata->name; 
                $selectedcityid = $getcitydata->id;  
            }
            
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
              //$keyword_query = "MATCH (t.item) AGAINST ('$keyword_str' IN BOOLEAN MODE)";  // IN BOOLEAN MODE gautish full
              //$keyword_query = "lti.item LIKE '%$keyword%'"; 
              
              $keyword_query = "t.item LIKE '%$keyword%'"; 
              
            //   $count_keyword_query = "MATCH (ti_work) AGAINST ('$keyword_str' IN BOOLEAN MODE)";  // IN BOOLEAN MODE
            //   $order_by = "CASE WHEN instr(t.ti_work, '$keyword') = 0 then 1 else 0 end,instr(t.ti_work, '$keyword')";
             
             
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
                    //echo print_r($searchKeyword);die();
                    //dd($searchKeyword);
                    $l_k_array = '"' . implode('","', $searchKeyword) . '"';
                    
                    $sub_id = DB::table('keyword')
                    ->select('keyword.subcategory', DB::raw('CASE WHEN search_exclude_subcategory.subcat IS NULL THEN "No" ELSE "Yes" END AS search'))
                    ->leftJoin('search_exclude_subcategory', 'keyword.subcategory', '=', 'search_exclude_subcategory.subcat')
                    ->whereIn('keyword.name', $searchKeyword)
                    ->get();
                    
                    //dd($sub_id);
                    $if_check_cat = "";
                    if (count($sub_id) > 0) {
                        foreach ($sub_id as $k => $v) {
                            $my_sub_id[] = $v->subcategory;
                            $if_check_cat = $v->search;
                        }
                        
                        if($if_check_cat == "Yes"){ // in execlude category
                        
                        }else{
                            
                        }
                        $my_sub = implode(',', $my_sub_id);
                    }
                   
                       if(Auth::check()){
                           
                       }else{
                           
                       }
                       
                        if (!empty($my_sub) && $my_sub != '') {
                            
                            if($if_check_cat == "Yes"){ // in execlude category
                            
                            $searchtype = "'Subcategory' AS searchtype";
                            //Moneyformat(t.tenderamount)
                            $sql = "SELECT t.ourrefno,t.purfromdate,t.Work,t.submitdate,t.earnestamount,t.doccost,t.tenderamount,Moneyformat(t.tenderamount) as ti_amount,DATE_FORMAT(t.submitdate, '%a %D %b, %Y') as show_ti_submit_date,t.city,t.org_name as agencyname,t.state_name as name,$searchtype from live_tenders as t INNER JOIN livetendercategory as tc ON t.ourrefno = tc.ourrefno where date(t.submitdate) >= '" . date('Y-m-d') . "'";
                    
                            }else{
                            $searchtype = "(CASE WHEN tc.subcategory = $my_sub THEN 'Subcategory' WHEN ($keyword_query) THEN 'BOQ' ELSE '' END) AS searchtype";
                            //Moneyformat(t.tenderamount)
                            $sql = "SELECT t.ourrefno,t.purfromdate,t.item,t.Work,t.submitdate,t.earnestamount,t.doccost,t.tenderamount,Moneyformat(t.tenderamount) as ti_amount,DATE_FORMAT(t.submitdate, '%a %D %b, %Y') as show_ti_submit_date,t.city,t.org_name as agencyname,t.state_name as name from live_tenders as t
                            INNER JOIN livetendercategory as tc ON t.ourrefno = tc.ourrefno where date(t.submitdate) >= '" . date('Y-m-d') . "'"; // ,$searchtype LEFT JOIN live_tenderinfo_items as lti ON t.ourrefno=lti.ourrefno
                            }
                            $sql1 = "SELECT COUNT(DISTINCT t.ourrefno) as total from live_tenders as t INNER JOIN livetendercategory as tc ON t.ourrefno = tc.ourrefno where date(t.submitdate) >= '" . date('Y-m-d') . "'"; // LEFT JOIN live_tenderinfo_items as lti ON t.ourrefno=lti.ourrefno
                            
                            /*if (!empty($sub_id)) {
                                if($if_check_cat == "Yes"){ // in execlude category
                                }else{
                                    $sql1 = "SELECT COUNT(DISTINCT ourrefno) as total FROM (SELECT t.ourrefno from live_tenders as t                                    
                                            INNER JOIN livetendercategory as tc ON t.ourrefno = tc.ourrefno 
                                        where date(t.submitdate) >= '" . date('Y-m-d') . "'";
                                }
                            }*/ 
                                
                                
                        } else {
                            
                            $searchtype = "(CASE WHEN t.Work LIKE '%$keyword%' THEN 'Keyword' WHEN ($keyword_query) THEN 'BOQ' ELSE '' END) AS searchtype";
                            //Moneyformat(t.tenderamount)
                            $sql = "SELECT t.ourrefno,t.item,t.purfromdate,t.Work,t.submitdate,t.earnestamount,t.doccost,t.tenderamount,Moneyformat(t.tenderamount) as ti_amount,DATE_FORMAT(t.submitdate, '%a %D %b, %Y') as show_ti_submit_date,t.city,t.org_name as agencyname,t.state_name as name from live_tenders as t
                            where t.submitdate >= '" . date('Y-m-d') . "'"; // ,$searchtype LEFT JOIN live_tenderinfo_items as lti ON t.ourrefno=lti.ourrefno
                            
                            $sql1 = "SELECT COUNT(DISTINCT t.ourrefno) as total from live_tenders as t
                            where date(t.submitdate) >= '" . date('Y-m-d') . "'"; // LEFT JOIN live_tenderinfo_items as lti ON t.ourrefno=lti.ourrefno  
                        }
                        
                        $if_check_cat = "Yes"; //disable boq 
                        
                         if (!empty($my_sub) && $my_sub != '') {
                            //$sql .= " and (tc.subcategory in($my_sub) OR ($keyword_query))";
                            //$sql1 .= " and (tc.subcategory in($my_sub) OR ($keyword_query))";
                            if($if_check_cat == "Yes"){ 
                                $sql .= " and (tc.subcategory in($my_sub) OR (t.Work LIKE '%$keyword%'))"; //subcategory and keyword
                                $sql1 .= " and (tc.subcategory in($my_sub) OR (t.Work LIKE '%$keyword%'))";
                            }else{
                                //isboq
                                $sql .= " and (tc.subcategory in($my_sub) OR ($keyword_query))";
                                //$sql1 .= " and (tc.subcategory in($my_sub) OR ($keyword_query))";
                                $sql1 .= " and (tc.subcategory in($my_sub) OR ($keyword_query))";
                            }
                        } else {
                            $sql .= " AND (( ";
                            $sql1 .= " AND (( ";
                            foreach ($searchKeyword as $i => $j) {
                                if ($i == 0) {
                                    $sql .= " t.Work LIKE '%" . $j . "%'";
                                    $sql1 .= " t.Work LIKE '%" . $j . "%'";
                                } else {
                                    $sql .= " or t.Work LIKE '%" . $j . "%'";
                                    $sql1 .= " or t.Work LIKE '%" . $j . "%'";
                                }
                            }
                            
                            //$sql .= " ) OR ($keyword_query))"; // boq enable
                            //$sql1 .= " ) OR ($keyword_query))"; // boq enable
                            
                            $sql .= " ))"; // boq disable
                            $sql1 .= " ))"; // boq disable
                        }
                    
                   
        }else{
            
           if(Auth::check()){
               
           }else{
               
           }
                if($type == 'category' || $type == 'subcategory'){
                    //Moneyformat(t.tenderamount)
                     $sql = "SELECT t.ourrefno,t.purfromdate,t.Work,t.submitdate,t.earnestamount,t.doccost,t.tenderamount,Moneyformat(t.tenderamount) as ti_amount,DATE_FORMAT(t.submitdate, '%a %D %b, %Y') as show_ti_submit_date,t.city,t.org_name as agencyname,t.state_name as name from live_tenders as t 
                     INNER JOIN livetendercategory as tc ON t.ourrefno = tc.ourrefno where date(t.submitdate) >= '" . date('Y-m-d') . "'";
                     $sql1 = "SELECT COUNT(*) as total from live_tenders as t INNER JOIN livetendercategory as tc ON t.ourrefno = tc.ourrefno where date(t.submitdate) >= '" . date('Y-m-d') . "'"; 
                 }else{
                    //Moneyformat(t.tenderamount)
                     $sql = "SELECT t.ourrefno,t.purfromdate,t.Work,t.submitdate,t.earnestamount,t.doccost,t.tenderamount,Moneyformat(t.tenderamount) as ti_amount,DATE_FORMAT(t.submitdate, '%a %D %b, %Y') as show_ti_submit_date,t.city,t.org_name as agencyname,t.state_name as name from live_tenders as t
                     where date(t.submitdate) >= '" . date('Y-m-d') . "'";
                     $sql1 = "SELECT COUNT(*) as total from live_tenders as t where date(t.submitdate) >= '" . date('Y-m-d') . "'"; 
                 }
           
            
        }
        
          $sqlstring = "";
      
          $sqlstring .= " AND t.link2 != 'https://www.nationaltenders_manually.com'";
          //$sql1 .= " AND t.link2 != 'https://www.nationaltenders_manually.com'";
          if($type == 'state'){
              //$sqlstring .= " AND t.state_name='$name'";
              $sqlstring .= " AND t.stateid='$selectedstateid'"; 
              //$sql1 .= " AND t.state_name='$name'";
          }else if($type == 'agency'){
              if($name == 'government e marketplace gem'){
               $sqlstring .= " AND (t.TenderNo LIKE '%GEM%')";
               //$sql1 .= " AND (t.TenderNo LIKE '%GEM%')";   
              }else{
              $sqlstring .= " AND t.agencyid='$selectedagencyid'";
              //$sql1 .= " AND t.agencyid='$selectedagencyid'";
              }
          }else if($type == 'category'){
              $sqlstring .= " AND tc.categoryid='$selectedcategoryid'";
              //$sql1 .= " AND tc.categoryid='$selectedcategoryid'";
          }else if($type == 'subcategory'){
              $sqlstring .= " AND (tc.categoryid='$selectedcategoryid' AND tc.subcategory='$selectedsubcategoryid')";
              //$sql1 .= " AND (tc.categoryid='$selectedcategoryid' AND tc.subcategory='$selectedsubcategoryid')";
          }else if($type == 'city'){
              if($selectedstateid!= "" && $selectedcity != ""){
              $sqlstring .= " AND (t.stateid=$selectedstateid AND t.city='$selectedcity')";
              //$sql1 .= " AND (t.stateid=$selectedstateid AND t.city='$cityname')";
              }
          }else{
              
          }
          
        
        $sql .= $sqlstring;
        $sql1 .= $sqlstring;
     
      
        if(trim($keyword) != ""){
        //$order_by = "CASE WHEN instr(t.Work, '$keyword') = 0 then 1 else 0 end,instr(t.Work, '$keyword')"; 
        //$sql .= " ORDER BY $order_by DESC LIMIT $page1,$per_page";
        //$order_by = "CASE WHEN instr(t.Work, '$keyword') = 0 then 1 else 0 end,instr(t.Work, '$keyword')"; 
        $sql .= " GROUP BY t.ourrefno ORDER BY t.ourrefno DESC LIMIT $page1,$per_page";
        }else{         
        $sql .= " GROUP BY t.ourrefno ORDER BY t.ourrefno DESC LIMIT $page1,$per_page";
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
        
        //$sql1 = str_replace("COUNT(*) as total","t.state_name as name,t.stateid as id,COUNT(DISTINCT t.ourrefno) as total",$sql1);

        //$sql1 = str_replace("COUNT(DISTINCT t.ourrefno) as total","t.state_name as name,t.stateid as id,COUNT(DISTINCT t.ourrefno) as total",$sql1);
        //$sql1 .= " GROUP BY t.stateid";
       
        //echo $sql." ".$sql1;die();
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
        $dataT['records'] = $records;
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
    public function tendersearching($type){
        
        if($type == "dashboard"){
            
            $myuserproduct = Session::get('loginuser.tender.filter.0'); 
            if(isset($myuserproduct)){
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
            $userproduct['input_portal_search'] = $myuserproduct['portal'];
            }else{
                $userproduct['input_s_keyword'] = "";
                $userproduct['input_s_product'] = "";
                $userproduct['input_s_category'] = "";
                $userproduct['input_s_subcategory'] = "";
                $userproduct['input_s_eproduct'] = "";
                $userproduct['input_s_ecategory'] = "";
                $userproduct['input_s_esubcategory'] = "";
                $userproduct['input_isexactkeyword_values'] = "";
                $userproduct['input_s_org'] = "";
                $userproduct['input_s_eorg'] = "";
                $userproduct['input_min_amount'] = "";
                $userproduct['input_max_amount'] = "";
                $userproduct['input_estimate_values'] = "";
                $userproduct['input_within_search'] = "";
                $userproduct['input_s_ekeyword'] = "";
                $userproduct['input_s_state'] = "";
                $userproduct['input_s_city'] = "";
                $userproduct['input_ntid_search'] = "";
                $userproduct['input_publish_date'] = "";
                $userproduct['input_ntid_search'] = "";
                $userproduct['input_portal_search'] = "";
            }
            
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
        }else if(isset($userproduct['data']) && $userproduct['data'] == 'archive2023'){
            $table_name = 'tender_2023';
            $cate_table_name = 'tendercategory_2023';
            $table_items = "tenderinfo_items";
            $condition = '1=1';
        }else if(isset($userproduct['data']) && $userproduct['data'] == 'archive2022'){
            $table_name = 'tender_2022';
            $cate_table_name = 'tendercategory_2022';
            $table_items = "tenderinfo_items";
            $condition = '1=1';
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
            $condition = 'date(t.submitdate) >= "'. date('Y-m-d') .'"';
        }
        
        //after login
        $sql = "";
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id;
            
        } 
        
        //for frontend logic 
        if($type == "searching" && $userproduct['data'] != 'archive'){
            
            if (!empty($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != "") {
               
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
                    
                    /*$sub_id = DB::table('keyword')
                    ->select('keyword.subcategory', DB::raw('CASE WHEN search_exclude_subcategory.subcat IS NULL THEN "No" ELSE "Yes" END AS search'))
                    ->leftJoin('search_exclude_subcategory', 'keyword.subcategory', '=', 'search_exclude_subcategory.subcat')
                    ->whereIn('keyword.name', $searchKeyword)
                    ->get();*/
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
                        if (isset($userproduct['input_isexactkeyword_values']) && $userproduct['input_isexactkeyword_values'] == 1) {
                             $userproduct['input_s_subcategory'] = "";
                        }
                    }
                
                }
                
            }
        }
        
            if(isset($userproduct['data']) && $userproduct['data'] == 'favourite'){
            if (Auth::check()) {
                //Moneyformat(t.tenderamount) 
                $sqlrecord = "SELECT t.TenderNo,t.ourrefno,t.purfromdate,t.Work,t.submitdate,t.earnestamount,t.doccost,t.tenderamount,Moneyformat(t.tenderamount) as ti_amount,DATE_FORMAT(t.submitdate, '%a %D %b, %Y') as show_ti_submit_date,t.city,t.org_name as agencyname,t.stateid,t.documentpath,t.state_name as name,tc.categoryid,tc.ourrefno,tc.subcategory,'India' as country,tl.user_id,tl.tender_id from $table_name as t
                        INNER JOIN $cate_table_name as tc ON t.ourrefno = tc.ourrefno
                        LEFT JOIN category as ct ON ct.id=tc.categoryid 
                        LEFT JOIN industry as ti ON ti.id=ct.industry_id 
                        LEFT JOIN tenderlike as tl ON tl.tender_id = t.ourrefno where t.ourrefno = tc.ourrefno  AND tl.user_id=" . $user_id;
                        //  LEFT JOIN $table_items as lti ON t.ourrefno=lti.ourrefno
                $sqltotal = "SELECT COUNT(*) as total from $table_name as t
                        INNER JOIN $cate_table_name as tc ON t.ourrefno = tc.ourrefno
                        LEFT JOIN category as ct ON ct.id=tc.categoryid 
                        LEFT JOIN industry as ti ON ti.id=ct.industry_id 
                        LEFT JOIN tenderlike as tl ON tl.tender_id = t.ourrefno where t.ourrefno = tc.ourrefno  AND tl.user_id=" . $user_id;
                        //LEFT JOIN $table_items as lti ON t.ourrefno=lti.ourrefno
                    
            }else{
                
            }   
                        
            }else{
                
                if ((isset($userproduct['input_s_product']) && $userproduct['input_s_product'] == "") && (isset($userproduct['input_s_category']) && $userproduct['input_s_category'] == "") && (isset($userproduct['input_s_subcategory']) && $userproduct['input_s_subcategory'] == "") && (isset($userproduct['input_s_eproduct']) && $userproduct['input_s_eproduct'] == "") && (isset($userproduct['input_s_ecategory']) && $userproduct['input_s_ecategory'] == "") && (isset($userproduct['input_s_esubcategory']) && $userproduct['input_s_esubcategory'] == "") && (isset($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != ""))  {
                    //Moneyformat(t.tenderamount)
                    $sqlrecord = "SELECT t.TenderNo,t.ourrefno,t.purfromdate,t.Work,t.submitdate,t.earnestamount,t.doccost,t.tenderamount,Moneyformat(t.tenderamount) as ti_amount,DATE_FORMAT(t.submitdate, '%a %D %b, %Y') as show_ti_submit_date,t.city,t.org_name as agencyname,t.stateid,t.documentpath,t.state_name as name from $table_name as t where ".$condition; // LEFT JOIN $table_items as lti ON t.ourrefno=lti.ourrefno
                    $sqltotal = "SELECT  COUNT(DISTINCT t.ourrefno) as total from $table_name as t  where ".$condition; // LEFT JOIN $table_items as lti ON t.ourrefno=lti.ourrefno
                
                    $sqltotaldashboard = "SELECT COUNT(DISTINCT CASE WHEN t.submitdate >= '$cdate' THEN t.ourrefno ELSE NULL END) as totallive, Count(DISTINCT CASE WHEN t.dt >= '$max_dt' THEN t.ourrefno ELSE NULL END) AS totalfresh from $table_name as t  where 1=1";
                    
                }else if ((isset($userproduct['input_s_product']) && $userproduct['input_s_product'] == "") && (isset($userproduct['input_s_category']) && $userproduct['input_s_category'] == "") && (isset($userproduct['input_s_subcategory']) && $userproduct['input_s_subcategory'] == "") && (isset($userproduct['input_s_eproduct']) && $userproduct['input_s_eproduct'] == "") && (isset($userproduct['input_s_ecategory']) && $userproduct['input_s_ecategory'] == "") && (isset($userproduct['input_s_esubcategory']) && $userproduct['input_s_esubcategory'] == "") && (isset($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] == "")) {
                    //Moneyformat(t.tenderamount)
                    $sqlrecord = "SELECT t.TenderNo,t.ourrefno,t.purfromdate,t.Work,t.submitdate,t.earnestamount,t.doccost,t.tenderamount,Moneyformat(t.tenderamount) as ti_amount,DATE_FORMAT(t.submitdate, '%a %D %b, %Y') as show_ti_submit_date,t.city,t.org_name as agencyname,t.stateid,t.documentpath,t.state_name as name from $table_name as t where ".$condition; // LEFT JOIN $table_items as lti ON t.ourrefno=lti.ourrefno
                    $sqltotal = "SELECT  COUNT(DISTINCT t.ourrefno) as total from $table_name as t  where ".$condition;
                    
                    $sqltotaldashboard = "SELECT COUNT(DISTINCT CASE WHEN t.submitdate >= '$cdate' THEN t.ourrefno ELSE NULL END) as totallive, Count(DISTINCT CASE WHEN t.dt >= '$max_dt' THEN t.ourrefno ELSE NULL END) AS totalfresh from $table_name as t  where 1=1";
                   
                }else{
                    //Moneyformat(t.tenderamount)
                    $sqlrecord = "SELECT t.TenderNo,t.ourrefno,t.purfromdate,t.Work,t.submitdate,t.earnestamount,t.doccost,t.tenderamount,Moneyformat(t.tenderamount) as ti_amount,DATE_FORMAT(t.submitdate, '%a %D %b, %Y') as show_ti_submit_date,t.city,t.org_name as agencyname,t.stateid,t.documentpath,t.state_name as name from $table_name as t"; 
                    $sqlrecord .=" LEFT JOIN $cate_table_name as tc ON t.ourrefno = tc.ourrefno";
                    $sqlrecord .=" LEFT JOIN category as ct ON ct.id=tc.categoryid";
                    $sqlrecord .=" LEFT JOIN industry as ti ON ti.id=ct.industry_id";
                    $sqlrecord .=" where ".$condition; // LEFT JOIN $table_items as lti ON t.ourrefno=lti.ourrefno
                    
                    $sqltotal = "SELECT  COUNT(DISTINCT t.ourrefno) as total from $table_name as t";
                    $sqltotal .=" LEFT JOIN $cate_table_name as tc ON t.ourrefno = tc.ourrefno";
                    $sqltotal .=" LEFT JOIN category as ct ON ct.id=tc.categoryid";
                    $sqltotal .=" LEFT JOIN industry as ti ON ti.id=ct.industry_id";
                    $sqltotal .=" where ".$condition; // LEFT JOIN $table_items as lti ON t.ourrefno=lti.ourrefno
                    
                    $sqltotaldashboard = "SELECT  COUNT(DISTINCT CASE WHEN t.submitdate >= '$cdate' THEN t.ourrefno ELSE NULL END) as totallive, Count(DISTINCT CASE WHEN t.dt >= '$max_dt' THEN t.ourrefno ELSE NULL END) AS totalfresh from $table_name as t";
                    $sqltotaldashboard .=" LEFT JOIN $cate_table_name as tc ON t.ourrefno = tc.ourrefno";
                    $sqltotaldashboard .=" LEFT JOIN category as ct ON ct.id=tc.categoryid";
                    $sqltotaldashboard .=" LEFT JOIN industry as ti ON ti.id=ct.industry_id";
                    $sqltotaldashboard .=" where 1=1";
                }
            }
            
            if (isset($userproduct['input_ntid_search']) && $userproduct['input_ntid_search'] != "") {
                $ntids = $_POST['input_ntid_search'];
                $sql .= " AND t.ourrefno IN($ntids)";
            }
            
            if (isset($userproduct['input_publish_date']) && $userproduct['input_publish_date'] != "") {
                $fdt = $_POST['input_publish_date'];
                $sql .= " AND t.dt='$fdt'";
            }
            
            $sql .= " AND t.link2 != 'https://www.nationaltenders_manually.com'";
            
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
                $userkeyword = array_values(array_filter($userkeyword)); 
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
                                $str_query .= " ti.id IN (" . $product_ids . ") OR";
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
                        $str_query2 .= "SELECT ilc.ourrefno FROM $cate_table_name as ilc LEFT JOIN category as iec ON ilc.categoryid=iec.id WHERE ";
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
                                    $sstr_ekeyword .= " t.Work LIKE '% " . $userkeyword[$i] . " %' OR ";
                                }
                                $sstr_ekeyword = trim($sstr_ekeyword);
                                $sstr_ekeyword = rtrim($sstr_ekeyword,'OR');
                                $sstr_ekeyword = trim($sstr_ekeyword);
                                $sql .= $sstr_ekeyword;
                                $sql .= " ) ";
                            }
                        } else {
        
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
                                     $sstr_keyword .= " t.Work LIKE '%" . $userkeyword[$i] . "%' OR ";
                                }
                                $sstr_keyword = trim($sstr_keyword);
                                $sstr_keyword = rtrim($sstr_keyword,'OR');
                                $sstr_keyword = trim($sstr_keyword);
                                $sql .= $sstr_keyword;
                                $sql .= " ) ";
                            }
                        }
                        
                $sql .= " $sql_items ) "; // gautishpatel
                
                if($str_query2 != ""){    
                    $sql .=  " AND t.ourrefno NOT IN (".$str_query2.")";
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
                                $sql .= " AND (t.Work  LIKE '% " . $userkeyword[$i] . " %' $sql_items)";
                            }
                            if (count($userkeyword) > 1) {
                                if ($i == 0) {
                                    $sql .= " AND ((t.Work LIKE '% " . $userkeyword[$i] . " %' OR ";
                                } else if ($i == (count($userkeyword) - 1)) {
                                    $sql .= " t.Work LIKE '% " . $userkeyword[$i] . " %') $sql_items)";
                                } else {
                                    $sql .= " t.Work LIKE '% " . $userkeyword[$i] . " %' OR ";
                                }
                            }
                        }
                    }
                } else {
                    if (!empty($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != "") {
                        
                        $userkeyword = explode(",", $userproduct['input_s_keyword']);
                        $userkeyword = array_values(array_filter($userkeyword)); 
                        for ($i = 0; $i < count($userkeyword); $i++) {
                            if (count($userkeyword) == 1) {
                                $sql .= " AND (t.Work  LIKE '%" . $userkeyword[$i] . "%' $sql_items)";
                            }
                            if (count($userkeyword) > 1) {
                                if ($i == 0) {
                                    $sql .= " AND ((t.Work LIKE '%" . $userkeyword[$i] . "%' OR ";
                                } else if ($i == (count($userkeyword) - 1)) {
                                    $sql .= " t.Work LIKE '%" . $userkeyword[$i] . "%') $sql_items)";
                                } else {
                                    $sql .= " t.Work LIKE '%" . $userkeyword[$i] . "%' OR ";
                                }
                            }
                        }
                        
                    }
                }
                
                
            }
            //echo $sql;die();
            
            if (isset($userproduct['input_s_org']) && $userproduct['input_s_org'] != 0 && $userproduct['input_s_org'] != "") {
                $sql .= " AND t.agencyid IN (" . $userproduct['input_s_org'] . ")";
            }
            if (isset($userproduct['input_s_eorg']) && $userproduct['input_s_eorg'] != 0 && $userproduct['input_s_eorg'] != "") {
                $sql .= " AND t.agencyid NOT IN (" . $userproduct['input_s_eorg'] . ")";
            }
            if (isset($userproduct['input_estimate_values']) && $userproduct['input_estimate_values'] == 1) {    
                if (!empty($userproduct['input_min_amount']) && !empty($userproduct['input_max_amount'])) {
                     $sql .= " AND ((`t`.`tenderamount` >= '" . $userproduct['input_min_amount'] . "' AND `t`.`tenderamount` <= '" . $userproduct['input_max_amount'] . "') OR `t`.`tenderamount` = 0)";
                } else if (!empty($userproduct['input_min_amount']) && empty($userproduct['input_max_amount'])) {
                    $sql .= " AND (`t`.`tenderamount` >= '" . $userproduct['input_min_amount'] . "' OR `t`.`tenderamount` = 0)";
                } else if (empty($userproduct['input_min_amount']) && !empty($userproduct['input_max_amount'])) {
                    $sql .= " AND (`t`.`tenderamount` <= '" . $userproduct['input_max_amount'] . "' OR `t`.`tenderamount` = 0)";
                }
            }else{
                if (!empty($userproduct['input_min_amount']) && !empty($userproduct['input_max_amount']) && $userproduct['input_min_amount'] != "" && $userproduct['input_max_amount'] != "") {
                     $sql .= " AND (`t`.`tenderamount` >= '" . $userproduct['input_min_amount'] . "' AND `t`.`tenderamount` <= '" . $userproduct['input_max_amount'] . "')";
                } else if (!empty($userproduct['input_min_amount']) && empty($userproduct['input_max_amount'])) {
                    $sql .= " AND (`t`.`tenderamount` >= '" . $userproduct['input_min_amount'] . "')";
                } else if (empty($userproduct['input_min_amount']) && !empty($userproduct['input_max_amount'])) {
                    $sql .= " AND (`t`.`tenderamount` <= '" . $userproduct['input_max_amount'] . "')";
                }
            }
            
            if (!empty($userproduct['input_within_search']) && $userproduct['input_within_search'] != "") {
                $userrefinekeyword = explode(",", $userproduct['input_within_search']);
                $userrefinekeyword = array_filter($userrefinekeyword); 

                if (isset($userproduct['input_isexactkeyword_values']) && $userproduct['input_isexactkeyword_values'] == 1) {
                    for ($i = 0; $i < count($userrefinekeyword); $i++) {
                        if (count($userrefinekeyword) == 1) {
                            $sql .= " AND t.Work  LIKE '% " . $userrefinekeyword[$i] . " %'";
                        }
                        if (count($userrefinekeyword) > 1) {
                            if ($i == 0) {
                                $sql .= " AND (t.Work LIKE '% " . $userrefinekeyword[$i] . " %' OR ";
                            } else if ($i == (count($userrefinekeyword) - 1)) {
                                $sql .= " t.Work LIKE '% " . $userrefinekeyword[$i] . " %')";
                            } else {
                                $sql .= " t.Work LIKE '% " . $userrefinekeyword[$i] . " %' OR ";
                            }
                        }
                    }  
                }else{
                    for ($i = 0; $i < count($userrefinekeyword); $i++) {
                        if (count($userrefinekeyword) == 1) {
                            $sql .= " AND t.Work  LIKE '%" . $userrefinekeyword[$i] . "%'";
                        }
                        if (count($userrefinekeyword) > 1) {
                            if ($i == 0) {
                                $sql .= " AND (t.Work LIKE '%" . $userrefinekeyword[$i] . "%' OR ";
                            } else if ($i == (count($userrefinekeyword) - 1)) {
                                $sql .= " t.Work LIKE '%" . $userrefinekeyword[$i] . "%')";
                            } else {
                                $sql .= " t.Work LIKE '%" . $userrefinekeyword[$i] . "%' OR ";
                            }
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
                        $sql .= " AND t.Work NOT LIKE '%" . trim($userexcludingkeyword[$j]) . "%'";
                    }
                    if (count($userexcludingkeyword) > 1) {
                        if ($j == 0) {
                            $sql .= " AND (t.Work NOT LIKE '%" . trim($userexcludingkeyword[$j]) . "%' AND ";
                        } else if ($j == (count($userexcludingkeyword) - 1)) {
                            $sql .= " t.Work NOT LIKE '%" . trim($userexcludingkeyword[$j]) . "%')";
                        } else {
                            $sql .= " t.Work NOT LIKE '%" . trim($userexcludingkeyword[$j]) . "%' AND ";
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
                    $sql .= " AND ( t.stateid IN (" . $userproduct['input_s_state'] . ")";
                    $sql .= " or t.city IN ('Bhiwani','Faridabad','Gurgaon','Jhajjar','Mahendragarh','Panipat','Rewari','Rohtak','Sonipat', 'Mewat' , 'Palwal' , 'Jind' , 'Karnal' , 'Baghpat' , 'Bulandshahr' ,'Gautam Buddha Nagar', 'Ghaziabad' , 'Muzaffarnagar' , 'Meerut' , 'Hapur' , 'Alwar' , 'Bharatpur','Noida','Delhi','New Delhi','SHAKURBASTI','TUGLAKABAD','Sakurbasit','Adarsh Nagar','Badli','Brar Square','Bijwasan','Chanakyapuri','Shivaji Bridge','Azadpur','Dayabasti','Delhi Cantt','Delhi Sarai Rohilla','Delhi KishanGanj','Old Delhi','Indrapuri','Shahdara','Sadar Bazar','Delhi Safdarjung','Ghevra','Holambi Kalan','Khera Kalan','Lodi Colony','Lajpat Nagar','Mangolpuri','Mundka','Naya Azadpur','Nangloi','Naraina Vihar','Narela','Delhi Hazrat Nizamuddin','Okhla','Pragati Maidan','Palam','Patel Nagar','Rajlu Garhi','Sardar Patel Road','Sandal Kalan','Shahabad Mohamadpur','Sarojini Nagar','Sewa Nagar','Delhi Sabzi Mandi','Tilak Bridge','Vivek Vihar','Vivekanand Puri Halt')";
                    $sql .= " )";
                } else {
                    $sql .= " AND t.stateid IN (" . $userproduct['input_s_state'] . ")";
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
           
            if (isset($userproduct['input_portal_search']) && $userproduct['input_portal_search'] != '') {
                
                if($userproduct['input_portal_search'] == "GEM")
                {   
                    $sql .= " AND t.link2 in ('https://bidplus.gem.gov.in','https://bidplus.gem.gov.in/bunch','https://bidplus.gem.gov.in/custom','https://bidplus.gem.gov.in/sbunch','https://bidplus.gem.gov.in/service')";
                }else{
                    $sql .= " AND t.link2 not in ('https://bidplus.gem.gov.in','https://bidplus.gem.gov.in/bunch','https://bidplus.gem.gov.in/custom','https://bidplus.gem.gov.in/sbunch','https://bidplus.gem.gov.in/service')";
                }
            }
            $sqltot = $sqltotal;
            $sqltot .= $sql;
            if($type == "dashboard"){
            $sqltotaldashboard .= $sql;
            }
            $sql .= " GROUP by `t`.`ourrefno`  ";
            if (isset($userproduct['sortby']) && !empty($userproduct['sortby'])) {
                if ($userproduct['sortby'] == 'hl') {
                    $sql .= " order by t.tenderamount desc";
                } else if ($userproduct['sortby'] == 'lh') {
                    $sql .= " order by t.tenderamount asc";
                } else if ($userproduct['sortby'] == 'ad') {
                    $sql .= " order by submitdate asc";
                } else if ($userproduct['sortby'] == 'da') {
                    $sql .= " order by submitdate desc";
                }else{
                     $sql .= " order by t.ourrefno desc";
                }
            } else {
                $sql .= " order by t.ourrefno desc";
            }
        
        
        
        $total_count = 0;
        $livecount = 0;
        if (!empty($sql)) {
            
            if($type == "dashboard"){
                //echo $sqltotaldashboard;die();
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
                

                if($userproduct['data'] == "archive2020" || $userproduct['data'] == "archive2021" || $userproduct['data'] == "archive2022" || $userproduct['data'] == "archive2023"){
                    $resultdata = DB::select($sqlrec);
                }else{
                    $resultdata = DB::select($sqlrec);
                }
                
                if($page == 1){
                    //echo $sqltot;die();
                    
                    if(isset($userproduct['data'])){
                        if($userproduct['data'] == "archive" || $userproduct['data'] == "archive2023" || $userproduct['data'] == "archive2022" || $userproduct['data'] == "archive2021" || $userproduct['data'] == "archive2020"){
                             $total_count = "";
                             $livecount = "";
                        }else{
                            if($type == "searching"){
                                //statewise count 
                            }
                            if(!empty($resultdata)){
                                $records =DB::select($sqltot);
                                $total_count = $records[0]->total;
                                $a = $total_count / $per_page;
                                $livecount = ceil($a);
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
     public function tenderdetails($id){

        $model = DB::table('tenderinfo_2017')
                ->select('tenderinfo_2017.*', DB::raw("'2017' as table_type")) // Using '2017' for clarity
                ->where('ourrefno', $id)
                ->first();
       
        // $model = DB::table('tenderinfo_2017')
        //             ->select('tenderinfo_2017.*',DB::raw('"allitem" as table_type'))
        //             ->where('ourrefno',$id)
        //             ->first();

        // if(!$model){
        // $model = DB::table('tender_2017')
        //             ->select('tender_2023.*',DB::raw('2023 as table_type'))
        //             ->where('ourrefno',$id)
        //             ->first();
        // } 
        // if(!$model){
        // $model = DB::table('tender_2017')
        //             ->select('tender_2022.*',DB::raw('2022 as table_type'))
        //             ->where('ourrefno',$id)
        //             ->first();
        // }
        // if(!$model){
        // $model = DB::table('tender_2017')
        //             ->select('tender_2021.*',DB::raw('2021 as table_type'))
        //             ->where('ourrefno',$id)
        //             ->first();
        // }
        // if(!$model){
        // $model = DB::table('tender_2017')
        //             ->select('tender_2020.*',DB::raw('2020 as table_type'))
        //             ->where('ourrefno',$id)
        //             ->first();
        // }
        if(!$model){
        //$sql = "SELECT t.*,t.org_name as agencyname,'India' as country,t.state_name as name FROM `tenderinfo_2017` `t` ORDER BY t.ourrefno DESC LIMIT 1";
        $model = DB::table('tenderinfo_2017')
                    ->select('tenderinfo_2017.*',DB::raw('"allitem" as table_type'))
                    ->orderby('ourrefno','desc')
                    ->first();
        }
        return $model;
        
    }
    public function checktenderdownload($id){
        $is_download = 0;
        $msg = "";
        $tendertodate = "";
        $user = Auth::user();
        $todays = date('Y-m-d');
        
        if(Auth::check()){
            $T = $user->is_tender;
            $usertype = $user->status;
            //$W = $user->workuser;
            //$R = $user->result_user;
            if(Session::has('tendertodate')){
                $tendertodate = Session::get('tendertodate');
            }
            // if(Session::has('tenderresulttodate')){
            //   $tenderresulttodate = Session::get('tenderresulttodate');
            // }
            
            if($T == 1){
                if($usertype == "Paid"){
                   
                       if ($tendertodate >= $todays) { // || $bidding_status == "Live"
                           
                          if(Session::has('loginuser')){
                                $myuserproduct = Session::get('loginuser.tender.filter.0');
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
    
    public function checkemailtenderdownload($id,$userid){
        $is_download = 0;
        $msg = "";
        $tendertodate = "";
        //$user = Auth::user();
        $user = DB::table('users')->where('id',$userid)->first();
        $todays = date('Y-m-d');
        
        if($user){
            $T = $user->is_tender;
            $usertype = $user->status;
           
            $tendertodate = "";
            // $usersubscription = DB::table('usersubscription')->where('user_id',$userid)->first();
            // if($usersubscription){
            // $tendertodate = $usersubscription->todate;
            // }
            
            $userproductstate = "";
            $userproduct = DB::table('userproduct')->where('user_id',$userid)->first();
            if($userproduct){
            $userproductstate = $userproduct->state;
            $tendertodate = $userproduct->todate;
            }
            
            if($T == 1){
                    if($usertype == "Paid"){
                       if ($tendertodate >= $todays) { // || $bidding_status == "Live"
                          //dd($id);  
                          if($tendertodate != ""){
                                //$myuserproduct = Session::get('loginuser.tender.filter.0');
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
    public function statesearching($id,$type){
        // dd($id.$type);
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
            $getagencydata = DB::table('state')->where('name', $id)->first();
            // echo "<pre>";print_r($getagencydata);
                    //  dd($id.$type);
             if($getagencydata){
                $selectedstateid = $getagencydata->id; 
                $selectedstatename = $getagencydata->name; 
             }else{
                $getagencydata = DB::table('state')
                ->where('id',356007)
                ->first();
                $selectedstateid = $getagencydata->id; 
                $selectedstatename = $getagencydata->name; 
             }   
        }else if($type == 'agency'){
            
            if($id == 'government e marketplace gem'){
                $getagencydata = DB::table('agency')
                ->where('agencyid', 148261)
                ->first();
            }else{
                $getagencydata = DB::table('agency')->where('agencyname', $id)->first();
                //  echo "<pre>";print_r($getagencydata);die();
            }

            if($getagencydata){
                $selectedagencyid = $getagencydata->agencyid;
                $selectedagencyname = $getagencydata->agencyname; 
            }else{
                $getagencydata = DB::table('agency')
                ->where('agencyid',3002)
                ->first();
                $selectedagencyid = $getagencydata->agencyid;
                $selectedagencyname = $getagencydata->agencyname; 
            }     
        }else if($type == 'category'){
            $name = str_replace('-', ' ', $name);
            $name = str_replace('tenders', '', $name);
            $name = str_replace('online tender', '', $name);
            $name = trim($name);
            $getagencydata = DB::table('category')
                ->where(DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name, '/', ''), '(', ''),')',''),'.',''),',',''),'&','')"), $name)
                ->first();
            if($getagencydata){
                $selectedcategoryid = $getagencydata->id;
                $selectedcategoryname = $getagencydata->name;
            }else{
                $getagencydata = DB::table('category')
                ->where('id',83)
                ->first();
                $selectedcategoryid = $getagencydata->id;
                $selectedcategoryname = $getagencydata->name;
            } 
        }else if($type == 'subcategory'){
             
            $name = str_replace('-', ' ', $name);
            $name = str_replace('tenders', '', $name);
            $name = str_replace('online tender', '', $name);
            $name = trim($name);
            
            $getagencydata = DB::table('subcategory')
                ->select('subcategory.*', 'category.name as cname')
                ->leftjoin('category', 'subcategory.categoryid', '=', 'category.id')
                ->where(DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(subcategory.name, '/', ''), '(', ''),')',''),'.',''),',',''),'&','')"), $name)
                ->first();
            if($getagencydata){
                $selectedcategoryid = $getagencydata->categoryid; 
                $selectedcategoryname = $getagencydata->cname; 
                $selectedsubcategoryid = $getagencydata->id; 
                $selectedsubcategoryname = $getagencydata->name;  
            } else{

                $getagencydata = DB::table('subcategory')
                ->select('subcategory.*', 'category.name as cname')
                ->leftjoin('category', 'subcategory.categoryid', '=', 'category.id')
                ->where('subcategory.id',569)
                ->first();
                $selectedcategoryid = $getagencydata->categoryid; 
                $selectedcategoryname = $getagencydata->cname; 
                $selectedsubcategoryid = $getagencydata->id; 
                $selectedsubcategoryname = $getagencydata->name; 
            }   
            

        }else if($type == 'city'){
            $cityname = str_replace('-', ' ', $name);
            $cityname = str_replace('tenders', '', $cityname);
            $cityname = trim($cityname);
            
            $getcitydata = DB::table('city')
                ->select('city.*', 'state.name as sname')
                ->leftjoin('state', 'city.state_id', '=', 'state.id')
                ->where("city.name", $cityname)
                ->first();
            if($getcitydata){
            $selectedstateid = $getcitydata->state_id; 
            $selectedstatename = $getcitydata->sname; 
            $selectedcity = $getcitydata->name; 
            $selectedcityid = $getcitydata->id;  
            }else{
                $getcitydata = DB::table('city')
                ->select('city.*', 'state.name as sname')
                ->leftjoin('state', 'city.state_id', '=', 'state.id')
                ->where("city.name", 'ahmedabad')
                ->first();
                $selectedstateid = $getcitydata->state_id; 
                $selectedstatename = $getcitydata->sname; 
                $selectedcity = $getcitydata->name; 
                $selectedcityid = $getcitydata->id;  
            }
            
        }else{
            if(isset($id) && $id){
              $keyword = $id;  
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
              $keyword_query = "t.item LIKE '%$keyword%'"; 
              
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
                    //echo print_r($searchKeyword);die();
                    //dd($searchKeyword);
                    $l_k_array = '"' . implode('","', $searchKeyword) . '"';
                    
                    $sub_id = DB::table('keyword')
                    ->select('keyword.subcategory', DB::raw('CASE WHEN search_exclude_subcategory.subcat IS NULL THEN "No" ELSE "Yes" END AS search'))
                    ->leftJoin('search_exclude_subcategory', 'keyword.subcategory', '=', 'search_exclude_subcategory.subcat')
                    ->whereIn('keyword.name', $searchKeyword)
                    ->get();
                    
                    //dd($sub_id);
                    $if_check_cat = "";
                    if (count($sub_id) > 0) {
                        foreach ($sub_id as $k => $v) {
                            $my_sub_id[] = $v->subcategory;
                            $if_check_cat = $v->search;
                        }
                        
                        if($if_check_cat == "Yes"){ // in execlude category
                        
                        }else{
                            
                        }
                        $my_sub = implode(',', $my_sub_id);
                    }
                   
                       if(Auth::check()){
                           
                       }else{
                           
                       }
                       
                        if (!empty($my_sub) && $my_sub != '') {
                            
                            if($if_check_cat == "Yes"){ // in execlude category
                            
                            $searchtype = "'Subcategory' AS searchtype";
                            //Moneyformat(t.tenderamount)
                            $sql = "SELECT t.ourrefno,t.purfromdate,t.Work,t.submitdate,t.earnestamount,t.doccost,t.tenderamount,Moneyformat(t.tenderamount) as ti_amount,DATE_FORMAT(t.submitdate, '%a %D %b, %Y') as show_ti_submit_date,t.city,t.org_name as agencyname,t.state_name as name,$searchtype from live_tenders as t INNER JOIN livetendercategory as tc ON t.ourrefno = tc.ourrefno where date(t.submitdate) >= '" . date('Y-m-d') . "'";
                    
                            }else{
                            $searchtype = "(CASE WHEN tc.subcategory = $my_sub THEN 'Subcategory' WHEN ($keyword_query) THEN 'BOQ' ELSE '' END) AS searchtype";
                            //Moneyformat(t.tenderamount)
                            $sql = "SELECT t.ourrefno,t.purfromdate,t.item,t.Work,t.submitdate,t.earnestamount,t.doccost,t.tenderamount,Moneyformat(t.tenderamount) as ti_amount,DATE_FORMAT(t.submitdate, '%a %D %b, %Y') as show_ti_submit_date,t.city,t.org_name as agencyname,t.state_name as name from live_tenders as t
                            INNER JOIN livetendercategory as tc ON t.ourrefno = tc.ourrefno where date(t.submitdate) >= '" . date('Y-m-d') . "'"; // ,$searchtype LEFT JOIN live_tenderinfo_items as lti ON t.ourrefno=lti.ourrefno
                            }
                            $sql1 = "SELECT COUNT(DISTINCT t.ourrefno) as total from live_tenders as t INNER JOIN livetendercategory as tc ON t.ourrefno = tc.ourrefno where date(t.submitdate) >= '" . date('Y-m-d') . "'"; // LEFT JOIN live_tenderinfo_items as lti ON t.ourrefno=lti.ourrefno
                               
                        } else {
                            
                            $searchtype = "(CASE WHEN t.Work LIKE '%$keyword%' THEN 'Keyword' WHEN ($keyword_query) THEN 'BOQ' ELSE '' END) AS searchtype";
                            //Moneyformat(t.tenderamount)
                            $sql = "SELECT t.ourrefno,t.item,t.purfromdate,t.Work,t.submitdate,t.earnestamount,t.doccost,t.tenderamount,Moneyformat(t.tenderamount) as ti_amount,DATE_FORMAT(t.submitdate, '%a %D %b, %Y') as show_ti_submit_date,t.city,t.org_name as agencyname,t.state_name as name from live_tenders as t
                            where t.submitdate >= '" . date('Y-m-d') . "'"; // ,$searchtype LEFT JOIN live_tenderinfo_items as lti ON t.ourrefno=lti.ourrefno
                            
                            $sql1 = "SELECT COUNT(DISTINCT t.ourrefno) as total from live_tenders as t
                            where date(t.submitdate) >= '" . date('Y-m-d') . "'"; // LEFT JOIN live_tenderinfo_items as lti ON t.ourrefno=lti.ourrefno  
                        }
                        
                        $if_check_cat = "Yes"; //disable boq 
                        
                         if (!empty($my_sub) && $my_sub != '') {
                            //$sql .= " and (tc.subcategory in($my_sub) OR ($keyword_query))";
                            //$sql1 .= " and (tc.subcategory in($my_sub) OR ($keyword_query))";
                            if($if_check_cat == "Yes"){ 
                                $sql .= " and (tc.subcategory in($my_sub) OR (t.Work LIKE '%$keyword%'))"; //subcategory and keyword
                                $sql1 .= " and (tc.subcategory in($my_sub) OR (t.Work LIKE '%$keyword%'))";
                            }else{
                                //isboq
                                $sql .= " and (tc.subcategory in($my_sub) OR ($keyword_query))";
                                //$sql1 .= " and (tc.subcategory in($my_sub) OR ($keyword_query))";
                                $sql1 .= " and (tc.subcategory in($my_sub) OR ($keyword_query))";
                            }
                        } else {
                            $sql .= " AND (( ";
                            $sql1 .= " AND (( ";
                            foreach ($searchKeyword as $i => $j) {
                                if ($i == 0) {
                                    $sql .= " t.Work LIKE '%" . $j . "%'";
                                    $sql1 .= " t.Work LIKE '%" . $j . "%'";
                                } else {
                                    $sql .= " or t.Work LIKE '%" . $j . "%'";
                                    $sql1 .= " or t.Work LIKE '%" . $j . "%'";
                                }
                            }
                            $sql .= " ))"; // boq disable
                            $sql1 .= " ))"; // boq disable
                        }
                    
                   
        }else{
           if(Auth::check()){    
           }else{  
           }
            if($type == 'category' || $type == 'subcategory'){
                //Moneyformat(t.tenderamount)
                $sql = "SELECT t.ourrefno,t.purfromdate,t.Work,t.submitdate,t.earnestamount,t.doccost,t.tenderamount,Moneyformat(t.tenderamount) as ti_amount,DATE_FORMAT(t.submitdate, '%a %D %b, %Y') as show_ti_submit_date,t.city,t.org_name as agencyname,t.state_name as name from live_tenders as t 
                INNER JOIN livetendercategory as tc ON t.ourrefno = tc.ourrefno where date(t.submitdate) >= '" . date('Y-m-d') . "'";
                $sql1 = "SELECT COUNT(*) as total from live_tenders as t INNER JOIN livetendercategory as tc ON t.ourrefno = tc.ourrefno where date(t.submitdate) >= '" . date('Y-m-d') . "'"; 
            }else{
            //Moneyformat(t.tenderamount)
                $sql = "SELECT t.ourrefno,t.purfromdate,t.Work,t.submitdate,t.earnestamount,t.doccost,t.tenderamount,Moneyformat(t.tenderamount) as ti_amount,DATE_FORMAT(t.submitdate, '%a %D %b, %Y') as show_ti_submit_date,t.city,t.org_name as agencyname,t.state_name as name from live_tenders as t
                where date(t.submitdate) >= '" . date('Y-m-d') . "'";
                $sql1 = "SELECT COUNT(*) as total from live_tenders as t where date(t.submitdate) >= '" . date('Y-m-d') . "'"; 
            }
        }
          $sqlstring = "";
      
          $sqlstring .= " AND t.link2 != 'https://www.nationaltenders_manually.com'";
          if($type == 'state'){
              $sqlstring .= " AND t.stateid='$selectedstateid'"; 
          }else if($type == 'agency'){
              if($id == 'government e marketplace gem'){
               $sqlstring .= " AND (t.TenderNo LIKE '%GEM%')";   
              }else{
                $sqlstring .= " AND t.agencyid='$selectedagencyid'";
              }
          }else if($type == 'category'){
              $sqlstring .= " AND tc.categoryid='$selectedcategoryid'";
              //$sql1 .= " AND tc.categoryid='$selectedcategoryid'";
          }else if($type == 'subcategory'){
              $sqlstring .= " AND (tc.categoryid='$selectedcategoryid' AND tc.subcategory='$selectedsubcategoryid')";
              //$sql1 .= " AND (tc.categoryid='$selectedcategoryid' AND tc.subcategory='$selectedsubcategoryid')";
          }else if($type == 'city'){
            if($selectedstateid!= "" && $selectedcity != ""){
              $sqlstring .= " AND (t.stateid=$selectedstateid AND t.city='$selectedcity')";
            }
          }else{
              
          }
        $sql .= $sqlstring;
        $sql1 .= $sqlstring;
     
        if(trim($keyword) != ""){
            $sql .= " GROUP BY t.ourrefno ORDER BY t.ourrefno DESC LIMIT $page1,$per_page";
        }else{         
            $sql .= " GROUP BY t.ourrefno ORDER BY t.ourrefno DESC LIMIT $page1,$per_page";
        }
         
        //$name,$type
        if($type == 'state'){
        }
        
        if($type == 'agency'){
            //echo $name;
            //echo $sql." ".$sql1;die();
        }
        
        if($type == 'keyword'){
            //echo $sql." ".$sql1;die();
        }
        //echo $sql." ".$sql1;die();
        $liveTender = array();
        $liveTender = DB::select($sql);
        // echo "<pre>";print_r($liveTender);die();
        $total = 0;
        $records = array();
        if(!empty($liveTender)){
            $records = DB::select($sql1);
            // echo "<pre>";print_r($records);die();
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
        $dataT['records'] = $records;
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
}
