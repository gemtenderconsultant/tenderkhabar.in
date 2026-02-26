<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Auth;
class AllTablesController extends Controller
{
    public function fulldataccess(Request $request)
        {
            // API KEY CHECK
            // if ($request->api_key !== '123456') {
            //     return response()->json([
            //         'status' => false,
            //         'message' => 'Unauthorized'
            //     ], 401);
            // }

            $apiKey = $request->header('X-API-KEY');

            if ($apiKey !== '123456') {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }

            // tables: state,city,keyword,agency
            $tablesParam = $request->tables;

            if (!$tablesParam) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tables parameter required'
                ], 400);
            }

            // Convert to array
            $tables = explode(',', $tablesParam);

            // ❗ tables you NEVER want to expose
            $blockedTables = [
                'migrations',
                'failed_jobs',
                'password_resets',
                'personal_access_tokens'
            ];

            $limit  = $request->limit ?? 100;
            $page   = $request->page ?? 1;
            $offset = ($page - 1) * $limit;

            $finalData = [];

            foreach ($tables as $table) {

                $table = trim($table);

                // Skip blocked tables
                if (in_array($table, $blockedTables)) {
                    continue;
                }

                // Safety: check table exists
                if (!Schema::hasTable($table)) {
                    continue;
                }

                $query = DB::table($table);

                /* ---------- OPTIONAL FILTERS ---------- */

                if ($request->countryid && Schema::hasColumn($table, 'countryid')) {
                    $query->where('countryid', $request->countryid);
                }

                if ($request->agencyid && Schema::hasColumn($table, 'agencyid')) {
                    $query->where('agencyid', '!=', $request->agencyid);
                }

                if ($request->state_id_in && Schema::hasColumn($table, 'state_id')) {
                    $query->whereIn('state_id', explode(',', $request->state_id_in));
                }

                /* ---------- FETCH ---------- */

                $finalData[$table] = $query
                    ->limit($limit)
                    ->offset($offset)
                    ->get();
            }

            return response()->json([
                'status' => true,
                'page'   => $page,
                'limit' => $limit,
                'data'  => $finalData
            ]);
        }
    public function stateTenderSummary(Request $request)
        {
            /* ===== API KEY CHECK ===== */
            if ($request->header('X-API-KEY') !== '123456') {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }
            /* ========================= */

            $date = $request->date ?? date('Y-m-d');

            $data = DB::table('live_tenders')
                ->select(
                    'state_name',
                    DB::raw('COUNT(*) as total_tenders'),
                    DB::raw('SUM(tenderamount) as total_value')
                )
                ->whereDate('submitdate', '>=', $date)
                ->groupBy('state_name')
                ->get();

            return response()->json([
                'status' => true,
                'data' => [
                    'state_summary' => $data
                ]
            ]);
        }
     public function actionGettendersdata(Request $request){
       /* ===============================
           🔐 API SECURITY
        ================================ */
        if ($request->header('X-API-KEY') !== '123456') {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        /* ===============================
           BASIC VARS (same as your code)
        ================================ */
        $name = $request->name;
        $type = $request->type;

        $per_page = 10;
        $page = $request->page ?? 1;
        $offset = ($page - 1) * $per_page;

        $keyword = '';
        $selectedstateid = '';
        $selectedstatename = '';
        $selectedcity = '';
        $selectedcityid = '';
        $selectedagencyid = '';
        $selectedagencyname = '';
        $selectedcategoryid = '';
        $selectedcategoryname = '';
        $selectedsubcategoryid = '';
        $selectedsubcategoryname = '';

        /* ===============================
           CLEAN NAME (same logic)
        ================================ */
        if ($name) {
            $name = str_replace(['-', 'tenders', 'online tender'], ' ', $name);
            $name = trim($name);
        }

        /* ===============================
           TYPE HANDLING
        ================================ */

        // 🔹 STATE
        if ($type === 'state') {
            $state = DB::table('state')
                ->where(DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name,'/',''),'(',''),')',''),'.',''),',',''),'&','')"), $name)
                ->first();
            if ($state) {
                $selectedstateid = $state->id;
                $selectedstatename = $state->name;
            }
        }

        // 🔹 AGENCY
        elseif ($type === 'agency') {
            $agency = DB::table('agency')
                ->where(DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(agencyname,'/',''),'(',''),')',''),'.',''),',',''),'&','')"), $name)
                ->first();

            if ($agency) {
                $selectedagencyid = $agency->agencyid;
                $selectedagencyname = $agency->agencyname;
            }
        }

        // 🔹 CATEGORY
        elseif ($type === 'category') {
            $cat = DB::table('category')
                ->where(DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name,'/',''),'(',''),')',''),'.',''),',',''),'&','')"), $name)
                ->first();

            if ($cat) {
                $selectedcategoryid = $cat->id;
                $selectedcategoryname = $cat->name;
            }
        }

        // 🔹 SUBCATEGORY
        elseif ($type === 'subcategory') {
            $sub = DB::table('subcategory')
                ->leftJoin('category', 'subcategory.categoryid', '=', 'category.id')
                ->select('subcategory.*', 'category.name as cname')
                ->where(DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(subcategory.name,'/',''),'(',''),')',''),'.',''),',',''),'&','')"), $name)
                ->first();

            if ($sub) {
                $selectedsubcategoryid = $sub->id;
                $selectedsubcategoryname = $sub->name;
                $selectedcategoryid = $sub->categoryid;
                $selectedcategoryname = $sub->cname;
            }
        }

        // 🔹 CITY
        elseif ($type === 'city') {
            $city = DB::table('city')
                ->leftJoin('state', 'city.state_id', '=', 'state.id')
                ->select('city.*', 'state.name as sname')
                ->where('city.name', $name)
                ->first();

            if ($city) {
                $selectedstateid = $city->state_id;
                $selectedstatename = $city->sname;
                $selectedcity = $city->name;
                $selectedcityid = $city->id;
            }
        }

        // 🔹 KEYWORD
        else {
            $keyword = $name;
        }

        /* ===============================
           BASE QUERY (live_tenders)
        ================================ */
        $query = DB::table('live_tenders as t')
            ->select(
                't.ourrefno',
                't.purfromdate',
                't.Work',
                't.submitdate',
                't.earnestamount',
                't.doccost',
                't.tenderamount',
                DB::raw("DATE_FORMAT(t.submitdate,'%a %D %b, %Y') as show_ti_submit_date"),
                't.city',
                't.org_name as agencyname',
                't.state_name as name'
            )
            ->whereDate('t.submitdate', '>=', date('Y-m-d'))
            ->where('t.link2', '!=', 'https://www.nationaltenders_manually.com');

        /* ===============================
           APPLY FILTERS
        ================================ */

        if ($selectedstateid) {
            $query->where('t.stateid', $selectedstateid);
        }

        if ($selectedcity) {
            $query->where('t.city', $selectedcity);
        }

        if ($selectedagencyid) {
            $query->where('t.agencyid', $selectedagencyid);
        }

        if ($selectedcategoryid || $selectedsubcategoryid) {
            $query->join('livetendercategory as tc', 't.ourrefno', '=', 'tc.ourrefno');

            if ($selectedcategoryid) {
                $query->where('tc.categoryid', $selectedcategoryid);
            }

            if ($selectedsubcategoryid) {
                $query->where('tc.subcategory', $selectedsubcategoryid);
            }
        }

        if ($keyword) {
            $query->where('t.Work', 'LIKE', "%$keyword%");
        }

        /* ===============================
           COUNT & DATA
        ================================ */
        $total = (clone $query)->distinct('t.ourrefno')->count();

        $data = $query
            ->groupBy('t.ourrefno')
            ->orderBy('t.ourrefno', 'desc')
            ->offset($offset)
            ->limit($per_page)
            ->get();

        /* ===============================
           FINAL RESPONSE (same as Yii)
        ================================ */
        return response()->json([
            'dataTender' => $data,
            'datatendercount' => $total,
            'keyword' => $keyword,
            'selectedstateid' => $selectedstateid,
            'selectedstatename' => $selectedstatename,
            'selectedcity' => $selectedcity,
            'selectedcityid' => $selectedcityid,
            'selectedagencyid' => $selectedagencyid,
            'selectedagencyname' => $selectedagencyname,
            'selectedcategoryid' => $selectedcategoryid,
            'selectedcategoryname' => $selectedcategoryname,
            'selectedsubcategoryid' => $selectedsubcategoryid,
            'selectedsubcategoryname' => $selectedsubcategoryname
        ]);
    }
    public function tendersearch(Request $request){
        $userproduct = $request->all();
    $type = $request->type;
            $flag = 0;
            $page = '';
            $per_page = 10;
            if (isset($_POST['lpage'])) {
                $page = $_POST['lpage'];
                $page1 = ($page * $per_page) - $per_page;
            } else {
                $page1 = 0;
            }

            $cdate = date('Y-m-d');
            $max_dt = date('Y-m-d', strtotime('-1 day', strtotime($cdate)));

            if(isset($userproduct['data'])) {
                if($userproduct['data'] == 'fresh') {
                    $table_name = 'live_tenders';
                    $cate_table_name = 'livetendercategory';
                    $table_items = "live_tenderinfo_items";
                    $condition = 't.dt >="'. $max_dt .'"';
                } elseif($userproduct['data'] == 'favourite') {
                    $table_name = 'tenderinfo_2017';
                    $cate_table_name = 'tendercategory_2017';
                    $table_items = "tenderinfo_items";
                    $condition = 'date(t.submitdate) >="'. date('Y-m-d') .'"';
                } elseif($userproduct['data'] == 'archive') {
                    $table_name = 'tenderinfo_2017';
                    $cate_table_name = 'tendercategory_2017';
                    $table_items = "tenderinfo_items";
                    $condition = 'date(t.submitdate) < "'. date('Y-m-d') .'"';
                } elseif($userproduct['data'] == 'archive2023') {
                    $table_name = 'tender_2023';
                    $cate_table_name = 'tendercategory_2023';
                    $table_items = "tenderinfo_items";
                    $condition = '1=1';
                } elseif($userproduct['data'] == 'archive2022') {
                    $table_name = 'tender_2022';
                    $cate_table_name = 'tendercategory_2022';
                    $table_items = "tenderinfo_items";
                    $condition = '1=1';
                } elseif($userproduct['data'] == 'archive2021') {
                    $table_name = 'tender_2021';
                    $cate_table_name = 'tendercategory_2021';
                    $table_items = "tenderinfo_items";
                    $condition = '1=1';
                } elseif($userproduct['data'] == 'archive2020') {
                    $table_name = 'tender_2020';
                    $cate_table_name = 'tendercategory_2020';
                    $table_items = "tenderinfo_items";
                    $condition = '1=1';
                } else {
                    $table_name = 'live_tenders';
                    $cate_table_name = 'livetendercategory';
                    $table_items = "live_tenderinfo_items";
                    $condition = 'date(t.submitdate) >= "'. date('Y-m-d') .'"';
                }
                } else {
                    $table_name = 'live_tenders';
                    $cate_table_name = 'livetendercategory';
                    $table_items = "live_tenderinfo_items";
                    $condition = 'date(t.submitdate) >= "'. date('Y-m-d') .'"';
                }
              
            $sql = "";
            if ($type == "searching" && $userproduct['data'] != 'archive') {
                //  echo "<pre>";print_r($userproduct['input_s_keyword']);
                if (!empty($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != "") {
                    $searc_session = $userproduct['input_s_keyword'];
                    
                    $str2 = str_replace(', ', ',', $searc_session);
                    $str_3 = rtrim($str2, ',');
                    $searchKeyword = explode(',', $str_3);
                    $searchKeyword = array_unique(array_filter($searchKeyword));
                    $filterkeyarray = array();
                    
                    foreach ($searchKeyword as $ski => $sk) {
                        $filterkeyarray[$ski] = trim(preg_replace('/[^a-z A-Z 0-9]/', ' ', $sk));
                    }
                    $l_k_array = '"' . implode('","', $filterkeyarray) . '"'; 

                    $checksubcategorysql = "SELECT keyword.name,keyword.subcategory,CASE WHEN search_exclude_subcategory.subcat IS NULL THEN 'No' ELSE 'Yes' END AS search FROM keyword LEFT JOIN search_exclude_subcategory ON keyword.subcategory=search_exclude_subcategory.subcat WHERE keyword.name IN($l_k_array)";
                
                    $matchsubcategory = [];
                    $result = $this->db->query($checksubcategorysql);
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $matchsubcategory[] = $row;
                        }
                    }
                    $if_check_cat = "";
                    $match_subid = array();
                    $inputsubcategory = array();
                    $checkforboq = array();
                    if (!empty($matchsubcategory)) {
                        
                        foreach ($matchsubcategory as $ksub => $vsub) {
                            $match_subid[$ksub]['id'] = $vsub['subcategory'];
                            $match_subid[$ksub]['match'] = $vsub['search'];
                            $match_subid[$ksub]['name'] = $vsub['name'];
                        }
                        $boqkey = 0;
                        foreach ($match_subid as $kmsub => $vmsub) {
                            $inputsubcategory[$kmsub] = $vmsub['id'];
                            if (in_array($vmsub['name'], $filterkeyarray)) {
                                $checkforboq[$boqkey]['name'] = $vmsub['name'];
                                $checkforboq[$boqkey]['match'] = $vmsub['match'];
                                $boqkey++;
                            }
                        }
                        foreach ($filterkeyarray as $fk => $fv) {
                            $keycheck = array_keys(array_combine(array_keys($match_subid), array_column($match_subid, 'name')), $fv);
                            if (empty($keycheck)) {
                                array_push($checkforboq, array('name' => $fv, 'match' => 'No'));
                            }
                        }
                        $inputsubcategory = array_unique(array_filter($inputsubcategory));
                        
                        if (!empty($inputsubcategory)) {
                            $selectsubcategory = '';
                            if ($userproduct['input_s_subcategory'] != "") {
                                $selectsubcategory = $userproduct['input_s_subcategory'] . ',' . implode(',', $inputsubcategory);
                            } else {
                                $selectsubcategory = implode(',', $inputsubcategory);
                            }
                            $userproduct['input_s_subcategory'] = $selectsubcategory;
                        }

                        if (isset($userproduct['input_isexactkeyword_values']) && $userproduct['input_isexactkeyword_values'] == 1) {
                            $userproduct['input_s_subcategory'] = "";
                        }  
                    }
                }
            }
            
            if ((!empty($userproduct['input_s_keyword']) && empty($userproduct['input_s_product']) && empty($userproduct['input_s_category']) && empty($userproduct['input_s_subcategory']) && empty($userproduct['input_s_eproduct']) && empty($userproduct['input_s_ecategory']) && empty($userproduct['input_s_esubcategory']))) {
                $sqlrecord = "SELECT t.TenderNo,t.ourrefno,t.purfromdate,t.Work,t.submitdate,t.earnestamount,t.doccost,t.tenderamount,Moneyformat(t.tenderamount) as ti_amount,DATE_FORMAT(t.submitdate, '%a %D %b, %Y') as show_ti_submit_date,t.city,t.org_name as agencyname,t.stateid,t.documentpath,t.state_name as name from $table_name as t where " . $condition;
                $sqltotal = "SELECT COUNT(DISTINCT t.ourrefno) as total from $table_name as t where " . $condition;
                $sqltotaldashboard = "SELECT COUNT(DISTINCT CASE WHEN t.submitdate >= '$cdate' THEN t.ourrefno ELSE NULL END) as totallive, Count(DISTINCT CASE WHEN t.dt >= '$max_dt' THEN t.ourrefno ELSE NULL END) AS totalfresh from $table_name as t where 1=1";
            } else if ((empty($userproduct['input_s_product']) && empty($userproduct['input_s_category']) && empty($userproduct['input_s_subcategory']) && empty($userproduct['input_s_eproduct']) && empty($userproduct['input_s_ecategory']) && empty($userproduct['input_s_esubcategory']) && empty($userproduct['input_s_keyword']))) {
                $sqlrecord = "SELECT t.TenderNo,t.ourrefno,t.purfromdate,t.Work,t.submitdate,t.earnestamount,t.doccost,t.tenderamount,Moneyformat(t.tenderamount) as ti_amount,DATE_FORMAT(t.submitdate, '%a %D %b, %Y') as show_ti_submit_date,t.city,t.org_name as agencyname,t.stateid,t.documentpath,t.state_name as name from $table_name as t where " . $condition;
                $sqltotal = "SELECT COUNT(DISTINCT t.ourrefno) as total from $table_name as t where " . $condition;
                $sqltotaldashboard = "SELECT COUNT(DISTINCT CASE WHEN t.submitdate >= '$cdate' THEN t.ourrefno ELSE NULL END) as totallive, Count(DISTINCT CASE WHEN t.dt >= '$max_dt' THEN t.ourrefno ELSE NULL END) AS totalfresh from $table_name as t where 1=1";
            }else {
                
                $sqlrecord = "SELECT t.TenderNo,t.ourrefno,t.purfromdate,t.Work,t.submitdate,t.earnestamount,t.doccost,t.tenderamount,Moneyformat(t.tenderamount) as ti_amount,DATE_FORMAT(t.submitdate, '%a %D %b, %Y') as show_ti_submit_date,t.city,t.org_name as agencyname,t.stateid,t.documentpath,t.state_name as name from $table_name as t";
                $sqlrecord .= " LEFT JOIN $cate_table_name as tc ON t.ourrefno = tc.ourrefno";
                $sqlrecord .= " LEFT JOIN category as ct ON ct.id=tc.categoryid";
                $sqlrecord .= " LEFT JOIN industry as ti ON ti.id=ct.industry_id";
                $sqlrecord .= " where " . $condition;

                $sqltotal = "SELECT COUNT(DISTINCT t.ourrefno) as total from $table_name as t";
                $sqltotal .= " LEFT JOIN $cate_table_name as tc ON t.ourrefno = tc.ourrefno";
                $sqltotal .= " LEFT JOIN category as ct ON ct.id=tc.categoryid";
                $sqltotal .= " LEFT JOIN industry as ti ON ti.id=ct.industry_id";
                $sqltotal .= " where " . $condition;

                $sqltotaldashboard = "SELECT COUNT(DISTINCT CASE WHEN t.submitdate >= '$cdate' THEN t.ourrefno ELSE NULL END) as totallive, Count(DISTINCT CASE WHEN t.dt >= '$max_dt' THEN t.ourrefno ELSE NULL END) AS totalfresh from $table_name as t";
                $sqltotaldashboard .= " LEFT JOIN $cate_table_name as tc ON t.ourrefno = tc.ourrefno";
                $sqltotaldashboard .= " LEFT JOIN category as ct ON ct.id=tc.categoryid";
                $sqltotaldashboard .= " LEFT JOIN industry as ti ON ti.id=ct.industry_id";
                $sqltotaldashboard .= " where 1=1";
            }

            // Continue building SQL with filters...
            $sql = "";
            if (isset($userproduct['input_ntid_search']) && $userproduct['input_ntid_search'] != "") {
                $ntids = $userproduct['input_ntid_search']; // Changed from $_POST to $userproduct
                $sql .= " AND t.ourrefno IN($ntids)";
            }

            if (isset($userproduct['input_publish_date']) && $userproduct['input_publish_date'] != "") {
                $fdt = $userproduct['input_publish_date']; // Changed from $_POST to $userproduct
                $sql .= " AND t.dt='$fdt'";
            }

            $sql .= " AND t.link2 != 'https://www.nationaltenders_manually.com'";

            $sql_items = "";
            if (!empty($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != "") {
            
                $userkeyword = explode(",", $userproduct['input_s_keyword']);
                $userkeyword = array_values(array_filter($userkeyword));
                
                for ($i = 0; $i < count($userkeyword); $i++) {
                    $keyword = $this->db->real_escape_string(trim($userkeyword[$i])); // Basic sanitization
                    $sql_items .= " t.item LIKE '%" . $keyword . "%' OR ";
                }
                $sql_items = trim($sql_items);
                $sql_items = rtrim($sql_items, 'OR');
                $sql_items = trim($sql_items);
                $sql_items = " OR ($sql_items)";
            }
            if (!empty($userproduct['input_s_product']) || !empty($userproduct['input_s_category']) || !empty($userproduct['input_s_subcategory']) || !empty($userproduct['input_s_eproduct']) || !empty($userproduct['input_s_ecategory']) || !empty($userproduct['input_s_esubcategory'])) {

                // Assign values
                $product_ids    = $userproduct['input_s_product'] ?? '';
                $cat_ids        = $userproduct['input_s_category'] ?? '';
                $subcat_ids     = $userproduct['input_s_subcategory'] ?? '';
                $eproduct_ids   = $userproduct['input_s_eproduct'] ?? '';
                $ecat_ids       = $userproduct['input_s_ecategory'] ?? '';
                $esubcat_ids    = $userproduct['input_s_esubcategory'] ?? '';

                // Build first query part
                $str_query = "";
                if ($product_ids != "" || $cat_ids != "" || $subcat_ids != "") {
                    if ($product_ids != "") {
                        $str_query .= " ti.id IN ($product_ids) OR ";
                    }
                    if ($cat_ids != "") {
                        $str_query .= " tc.categoryid IN ($cat_ids) OR ";
                    }
                    if ($subcat_ids != "") {
                        $str_query .= " tc.subcategory IN ($subcat_ids) OR ";
                    }
                    $str_query = rtrim(trim($str_query), "OR");
                }

                // Build second query part (exclude)
                $str_query2 = "";
                if ($eproduct_ids != "" || $ecat_ids != "" || $esubcat_ids != "") {
                    $str_query2 .= "SELECT ilc.ourrefno FROM $cate_table_name AS ilc 
                                    LEFT JOIN category AS iec ON ilc.categoryid=iec.id WHERE ";

                    if ($eproduct_ids != "") {
                        $str_query2 .= " iec.industry_id IN ($eproduct_ids) OR ";
                    }
                    if ($ecat_ids != "") {
                        $str_query2 .= " ilc.categoryid IN ($ecat_ids) OR ";
                    }
                    if ($esubcat_ids != "") {
                        $str_query2 .= " ilc.subcategory IN ($esubcat_ids) OR ";
                    }
                    $str_query2 = rtrim(trim($str_query2), "OR");
                }
                // Combine into main SQL
                $sql .= " AND (";
                if ($str_query != "" && $str_query2 != "") {
                    $sql .= "($str_query)";
                    // Exclude if needed: $sql .= " AND t.ourrefno NOT IN ($str_query2)";
                } elseif ($str_query != "") {
                    $sql .= "($str_query)";
                } elseif ($str_query2 != "") {
                }
                // Keywords handling
                if (!empty($userproduct['input_s_keyword'])) {
                    $userkeyword = array_filter(explode(",", $userproduct['input_s_keyword']));
                    if (!empty($userkeyword)) {
                        if (!empty($userproduct['input_isexactkeyword_values']) && $userproduct['input_isexactkeyword_values'] == 1) {
                            $sql .= " OR (";
                            $sstr_ekeyword = "";
                            foreach ($userkeyword as $kw) {
                                $sstr_ekeyword .= " t.Work LIKE '% $kw %' OR ";
                            }
                            $sql .= rtrim(trim($sstr_ekeyword), "OR") . ")";
                        } else {
                            $sql .= " OR (";
                            $sstr_keyword = "";
                            foreach ($userkeyword as $kw) {
                                $sstr_keyword .= " t.Work LIKE '%$kw%' OR ";
                            }
                            $sql .= rtrim(trim($sstr_keyword), "OR") . ")";
                        }
                    }
                }
                $sql .= " $sql_items )"; // Append your other SQL conditions
                // Exclude secondary query
                if ($str_query2 != "") {
                    $sql .= " AND t.ourrefno NOT IN ($str_query2)";
                }
            }else{
                if (isset($userproduct['input_isexactkeyword_values']) && $userproduct['input_isexactkeyword_values'] == 1) {

                    if (!empty($userproduct['input_s_keyword'])) {
                        // Explode keywords by comma and remove empty values
                        $userkeywords = explode(",", $userproduct['input_s_keyword']);
                        $userkeywords = array_filter($userkeywords); // removes empty values
                        $keywordCount = count($userkeywords);

                        if ($keywordCount > 0) {
                            if ($keywordCount == 1) {
                                $keyword = trim($userkeywords[0]);
                                $sql .= " AND (t.Work LIKE '% " . $keyword . " %' $sql_items)";
                            } else {
                                // Multiple keywords
                                $sql .= " AND (";
                                for ($i = 0; $i < $keywordCount; $i++) {
                                    $keyword = trim($userkeywords[$i]);
                                    if ($i == 0) {
                                        $sql .= "t.Work LIKE '% " . $keyword . " %'";
                                    } else {
                                        $sql .= " OR t.Work LIKE '% " . $keyword . " %'";
                                    }
                                }
                                $sql .= " $sql_items)";
                            }
                        }
                    }
                }else{
                    if (!empty($userproduct['input_s_keyword']) && $userproduct['input_s_keyword'] != "") {
                        $userkeyword = explode(",", $userproduct['input_s_keyword']);
                        $userkeyword = array_values(array_filter($userkeyword));

                        for ($i = 0; $i < count($userkeyword); $i++) {
                            $keyword = trim($userkeyword[$i]); // clean whitespace
                            if (count($userkeyword) == 1) {
                                $sql .= " AND (t.Work LIKE '%" . $keyword . "%' $sql_items)";
                            }
                            if (count($userkeyword) > 1) {
                                if ($i == 0) {
                                    $sql .= " AND ((t.Work LIKE '%" . $keyword . "%' OR ";
                                } elseif ($i == (count($userkeyword) - 1)) {
                                    $sql .= " t.Work LIKE '%" . $keyword . "%') $sql_items)";
                                } else {
                                    $sql .= " t.Work LIKE '%" . $keyword . "%' OR ";
                                }
                            }
                        }
                    }
                }
            }
            // ✅ Filter by organization include
            if (isset($userproduct['input_s_org']) && $userproduct['input_s_org'] != 0 && $userproduct['input_s_org'] != "") {
                $sql .= " AND t.agencyid IN (" . $userproduct['input_s_org'] . ")";
            }

            // ✅ Filter by organization exclude
            if (isset($userproduct['input_s_eorg']) && $userproduct['input_s_eorg'] != 0 && $userproduct['input_s_eorg'] != "") {
                $sql .= " AND t.agencyid NOT IN (" . $userproduct['input_s_eorg'] . ")";
            }

            // ✅ Estimate value filters
            if (isset($userproduct['input_estimate_values']) && $userproduct['input_estimate_values'] == 1) {    
                if (!empty($userproduct['input_min_amount']) && !empty($userproduct['input_max_amount'])) {
                    $sql .= " AND ((t.tenderamount >= '" . $userproduct['input_min_amount'] . "' 
                            AND t.tenderamount <= '" . $userproduct['input_max_amount'] . "') 
                            OR t.tenderamount = 0)";
                } elseif (!empty($userproduct['input_min_amount'])) {
                    $sql .= " AND (t.tenderamount >= '" . $userproduct['input_min_amount'] . "' 
                            OR t.tenderamount = 0)";
                } elseif (!empty($userproduct['input_max_amount'])) {
                    $sql .= " AND (t.tenderamount <= '" . $userproduct['input_max_amount'] . "' 
                            OR t.tenderamount = 0)";
                }
            } else {
                if (!empty($userproduct['input_min_amount']) && !empty($userproduct['input_max_amount'])) {
                    $sql .= " AND (t.tenderamount >= '" . $userproduct['input_min_amount'] . "' 
                            AND t.tenderamount <= '" . $userproduct['input_max_amount'] . "')";
                } elseif (!empty($userproduct['input_min_amount'])) {
                    $sql .= " AND (t.tenderamount >= '" . $userproduct['input_min_amount'] . "')";
                } elseif (!empty($userproduct['input_max_amount'])) {
                    $sql .= " AND (t.tenderamount <= '" . $userproduct['input_max_amount'] . "')";
                }
            }

            // ✅ Within search keywords
            if (!empty($userproduct['input_within_search'])) {
                $userrefinekeyword = array_filter(explode(",", $userproduct['input_within_search']));
                if (!empty($userrefinekeyword)) {
                    $isExact = isset($userproduct['input_isexactkeyword_values']) && $userproduct['input_isexactkeyword_values'] == 1;
                    $sql .= " AND (";
                    $conditions = [];
                    foreach ($userrefinekeyword as $keyword) {
                        $keyword = trim($keyword);
                        if ($isExact) {
                            $conditions[] = "t.Work LIKE '% " . $keyword . " %'";
                        } else {
                            $conditions[] = "t.Work LIKE '%" . $keyword . "%'";
                        }
                    }
                    $sql .= implode(" OR ", $conditions) . ")";
                }
            }
                    // --- Excluding keywords ---
            if (isset($userproduct['input_s_ekeyword']) && $userproduct['input_s_ekeyword'] != '') {
                $userexcludingkeyword = explode(",", $userproduct['input_s_ekeyword']);
                $userexcludingkeyword = array_filter(array_map('trim', $userexcludingkeyword));

                if (count($userexcludingkeyword) == 1) {
                    $sql .= " AND t.Work NOT LIKE '%" . $userexcludingkeyword[0] . "%'";
                } else {
                    $sql .= " AND (";
                    foreach ($userexcludingkeyword as $j => $word) {
                        $sql .= "t.Work NOT LIKE '%" . $word . "%'";
                        if ($j < count($userexcludingkeyword) - 1) {
                            $sql .= " AND ";
                        }
                    }
                    $sql .= ")";
                }
            }
            // --- State Filter ---
            $state_ncr = array();
            $state_ncr1 = array();

            if (isset($userproduct['input_s_state']) && $userproduct['input_s_state'] != 0 && $userproduct['input_s_state'] != "") {
                $state_ncr = explode(',', $userproduct['input_s_state']);
                if (isset($userproduct['input_s_city']) && $userproduct['input_s_city'] == '' && !empty($state_ncr) && in_array('380017', $state_ncr)) {
                    $sql .= " AND ( t.stateid IN (" . $userproduct['input_s_state'] . ")";
                    $sql .= " OR t.city IN ('Bhiwani','Faridabad','Gurgaon','Jhajjar','Mahendragarh','Panipat','Rewari','Rohtak','Sonipat', 
                    'Mewat','Palwal','Jind','Karnal','Baghpat','Bulandshahr','Gautam Buddha Nagar','Ghaziabad','Muzaffarnagar',
                    'Meerut','Hapur','Alwar','Bharatpur','Noida','Delhi','New Delhi','SHAKURBASTI','TUGLAKABAD','Sakurbasit',
                    'Adarsh Nagar','Badli','Brar Square','Bijwasan','Chanakyapuri','Shivaji Bridge','Azadpur','Dayabasti',
                    'Delhi Cantt','Delhi Sarai Rohilla','Delhi KishanGanj','Old Delhi','Indrapuri','Shahdara','Sadar Bazar',
                    'Delhi Safdarjung','Ghevra','Holambi Kalan','Khera Kalan','Lodi Colony','Lajpat Nagar','Mangolpuri',
                    'Mundka','Naya Azadpur','Nangloi','Naraina Vihar','Narela','Delhi Hazrat Nizamuddin','Okhla',
                    'Pragati Maidan','Palam','Patel Nagar','Rajlu Garhi','Sardar Patel Road','Sandal Kalan',
                    'Shahabad Mohamadpur','Sarojini Nagar','Sewa Nagar','Delhi Sabzi Mandi','Tilak Bridge',
                    'Vivek Vihar','Vivekanand Puri Halt')";
                    $sql .= ")";
                } else {
                    $sql .= " AND t.stateid IN (" . $userproduct['input_s_state'] . ")";
                }
            }
            // --- City Filter ---
            if (isset($userproduct['input_s_city']) && $userproduct['input_s_city'] != '') {
                $city_explode = explode(',', $userproduct['input_s_city']);
                $city_explode = array_map('trim', $city_explode);
                $city1 = "'" . implode("','", $city_explode) . "'";
                $sql .= " AND t.city IN (" . $city1 . ")";
            }
            // --- Portal Search Filter ---
            if (isset($userproduct['input_portal_search']) && $userproduct['input_portal_search'] != '') {
                if ($userproduct['input_portal_search'] == "GEM") {
                    $sql .= " AND t.link2 IN ('https://bidplus.gem.gov.in','https://bidplus.gem.gov.in/bunch','https://bidplus.gem.gov.in/custom','https://bidplus.gem.gov.in/sbunch','https://bidplus.gem.gov.in/service')";
                } else {
                    $sql .= " AND t.link2 NOT IN ('https://bidplus.gem.gov.in','https://bidplus.gem.gov.in/bunch','https://bidplus.gem.gov.in/custom','https://bidplus.gem.gov.in/sbunch','https://bidplus.gem.gov.in/service')";
                }
            }
            $sqltot = $sqltotal;
            $sqltot .= $sql;
            $sql .= " GROUP by t.ourrefno ";
                
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
            if (!empty($sqlrecord) && !empty($sqltotal)) {
                $sqlrec = $sqlrecord;
                $sqlrec .= $sql;
                $sqlrec .= " limit $page1,$per_page";
                $resultdata = [];
                $result = $this->db->query($sqlrec);
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $resultdata[] = $row;
                    }
                }
                if ($page == 1 || $page == '') { // Include case where $page is not set, resulting in $page1=0
                    if (isset($userproduct['data']) && ($userproduct['data'] == "archive" || strpos($userproduct['data'], "archive20") === 0)) {
                        $total_count = "";
                        $livecount = "";
                    } else {
                        if ($type == "searching") {
                        }
                        $sqltot_final = $sqltotal . $sql; 
                        if (!empty($resultdata)) {
                            $result_total = $this->db->query($sqltot_final);
                            if ($result_total && $result_total->num_rows > 0) {
                                $row = $result_total->fetch_assoc();
                                $total_count = $row['total'];
                                $a = $total_count / $per_page;
                                $livecount = ceil($a);
                            }
                        } else {
                            // If no result data but the search filters were applied, still try to get the total.
                            $result_total = $this->db->query($sqltot_final);
                            if ($result_total && $result_total->num_rows > 0) {
                                $row = $result_total->fetch_assoc();
                                $total_count = $row['total'];
                                $a = $total_count / $per_page;
                                $livecount = ceil($a);
                            } else {
                                $total_count = 0;
                                $livecount = 0;
                            }
                        }
                    }
                } else {
                    $total_count = 0;
                    $livecount = 0;
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
            $arrdata['userkeyword'] = $userproduct['input_s_keyword'] ?? '';
            // return $arrdata;
            return response()->json($arrdata);
        }
}
