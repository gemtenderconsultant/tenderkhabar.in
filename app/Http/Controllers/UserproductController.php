<?php

namespace App\Http\Controllers;

use App\Models\Userproduct;
use Illuminate\Http\Request;
use Hash;
use Auth;
use DataTables;
use DB;
use Redirect;
use File;
class UserproductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $users = User::latest()->paginate(5);
        return view('admin.users.index',compact('users'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function dynamicfiltercity(Request $request) {
        $html = '';
        if($request->ajax()){
            $search = $request->get('data');
            $my_cities = array();
            if(!empty($search)){
                $my_cities = $search;
                /*if (in_array('380017', $my_cities)) {
                    $my_cities[] = '356033';
                } else {

                }*/          
                $resultdata = DB::table('city')->select('name')->whereIn('state_id',$my_cities)->groupby('name')->get();
                foreach ($resultdata as $key => $value) {
                    $html .= "<option value='" . $value->name . "' >" . $value->name. "</option>";
                }
            }
        }
        echo $html;
        exit;
    }
    public function getdepartmentlist(Request $request) {
        $search = $request->get('searchTerm');
        if($search == ''){
            $department = DB::table('agency')->select('agencyid','agencyname')->limit(10)->get();
          }else{
             $department = DB::table('agency')->select('agencyid','agencyname')->where('agencyname', 'like', '%' .$search . '%')->limit(10)->get();
          }

          $response = array();
          foreach($department as $dept){
             $response[] = array(
                  "id"=>$dept->agencyid,
                  "text"=>$dept->agencyname
             );
          }
        return response()->json($response); 
    }
    public function treecategory(Request $request) {
         
        if($request->ajax()){

            $search = trim($request->get('data'));
            if($search != ""){
             $sqlsearch = "SELECT keyword.industry_id,keyword.category_id,keyword.subcategory,industry.name as iname,category.name as cname,subcategory.name as sname,keyword.name as k_name,'4' as type FROM keyword LEFT JOIN subcategory ON keyword.subcategory=subcategory.id LEFT JOIN category ON subcategory.categoryid=category.id LEFT JOIN industry ON industry.id=category.industry_id WHERE keyword.name LIKE '%$search%' UNION ALL SELECT industry.id as industry_id,category.id as category_id,subcategory.id as subcategory,industry.name as iname,category.name as cname,subcategory.name as sname,'' as k_name,'3' as type FROM subcategory LEFT JOIN category ON subcategory.categoryid=category.id LEFT JOIN industry ON industry.id=category.industry_id WHERE subcategory.name LIKE '%$search%' UNION ALL SELECT industry.id as industry_id,category.id as category_id,'' as subcategory,industry.name as iname,category.name as cname,'' as sname,'' as k_name,'2' as type FROM category LEFT JOIN industry ON industry.id=category.industry_id WHERE category.name LIKE '%$search%' UNION ALL SELECT industry.id as industry_id,'' as category_id,'' as subcategory,industry.name as iname,'' as cname,'' as sname,'' as k_name,'1' as type FROM industry WHERE industry.name LIKE '%$search%' ORDER BY type ASC";

               
                $getsearch = DB::select($sqlsearch);
                //$getsearch = collect($getsearch);
                $getsearch = json_decode(json_encode($getsearch), true);

            }
            
            
            //dd($getsearch);
             $product = array();
             $product_arr = array();
             $category = array();
             $category_arr = array();
             $subcategory = array();
             $subcategory_arr = array();
             $keyword = array();
             $keyword_arr = array();
             
                foreach($getsearch as $getproduct){
                    
                    if(!in_array($getproduct['industry_id'], $product)){
                     $product[] = $getproduct['industry_id'];
                     $product_arr[] = $getproduct;          
                    }
                    
                    if(!in_array($getproduct['category_id'], $category)){
                     $category[] = $getproduct['category_id'];
                     $category_arr[] = $getproduct;          
                    }
                    
                    if(!in_array($getproduct['subcategory'], $subcategory)){
                     $subcategory[] = $getproduct['subcategory'];
                     $subcategory_arr[] = $getproduct;          
                    }
                    
                    if(!in_array($getproduct['k_name'], $keyword)){
                     $keyword[] = $getproduct['k_name'];
                     $keyword_arr[] = $getproduct;          
                    }
                    
                }
            // $sub_category = Yii::$app->db->createCommand('SELECT id,name FROM subcategory where categoryid in (' . $data . ')')->queryAll();
            // foreach ($sub_category as $key => $val) {
            //     $sub_cat[$val['id']] = $val['name'];
            // }
            // foreach ($sub_cat as $k => $v) {
            //     $body .= '<option value="' . $k . '">' . $v . '</option>';
            // }
            
            if(!empty($getsearch)){
                 foreach($product_arr as $getproduct){
                ?>
                    <article class="list-group-item main_product">
                    <a href="#" data-toggle="collapse" data-target="#collapse_p_<?php echo $getproduct['industry_id']; ?>" data="<?php echo $getproduct['industry_id']; ?>" aria-expanded="true" class="">
                        <header class="filter-header">
                            <i class="icon-action fa fa-chevron-down"></i>
                        </header>
                    </a>
                    <?php 
                    //$keyword = $_GET['cate_search'];
                    $str = $getproduct['iname'];
                    //$str = preg_replace("/($keyword)/i","<span class='font-weight-bold'>$1</span>",$str);
                    echo "<input type='checkbox' class='i_select' name='in[]' value='".$getproduct['industry_id']."' data='".$getproduct['iname']."'> ".$str; 
                    ?>
                          
                            
                        <div class="filter-content collapse show" id="collapse_p_<?php echo $getproduct['industry_id']; ?>" style="">    
                            <?php foreach($category_arr as $getproduct2){
                                if($getproduct['industry_id'] == $getproduct2['industry_id'] && $getproduct2['cname'] != ""){
                            ?>
                                <article class="list-group-item main_product">
                                    <a href="#" data-toggle="collapse" data-target="#collapse_c_<?php echo $getproduct2['category_id']; ?>" data="<?php echo $getproduct2['category_id']; ?>" aria-expanded="true" class="">
                                        <header class="filter-header">
                                            <i class="icon-action fa fa-chevron-down"></i>
                                        </header>
                                    </a>
                                    <?php 
                                    //$keyword = $_GET['cate_search'];
                                    $str = $getproduct2['cname'];
                                    //$str = preg_replace("/($keyword)/i","<span class='font-weight-bold'>$1</span>",$str);
                                    echo "<input type='checkbox' class='c_select' name='ct[]' value='".$getproduct2['category_id']."'  data='".$getproduct2['cname']."'> ".$str;
                                    ?>
                                    <div class="filter-content collapse show" id="collapse_c_<?php echo $getproduct2['category_id']; ?>" style="">
                                    <?php foreach($subcategory_arr as $getproduct3){
                                            if($getproduct2['category_id'] == $getproduct3['category_id'] && $getproduct3['sname'] != ""){
                                        ?>
                                            <article class="list-group-item main_product">
                                                <a href="#" data-toggle="collapse" data-target="#collapse_sc_<?php echo $getproduct3['subcategory']; ?>" data="<?php echo $getproduct3['subcategory']; ?>" aria-expanded="true" class="">
                                                    <header class="filter-header">
                                                        <i class="icon-action fa fa-chevron-down"></i>
                                                    </header>
                                                </a>
                                                <?php 
                                                //$keyword = $_GET['cate_search'];
                                                $str = $getproduct3['sname'];
                                                //$str = preg_replace("/($keyword)/i","<span class='font-weight-bold'>$1</span>",$str);
                                                echo "<input type='checkbox' name='sc[]' class='s_select' value='".$getproduct3['subcategory']."' data='".$getproduct3['sname']."'> ".$str; 
                                                ?>
                                                <?php //echo $getproduct3['subcategory']; ?>
                                                <div class="filter-content collapse show" id="collapse_sc_<?php echo $getproduct3['subcategory']; ?>" style="">
                                                    <?php foreach($keyword_arr as $getproduct4){
                                                            if($getproduct3['subcategory'] == $getproduct4['subcategory'] && $getproduct4['k_name'] != ""){
                                                        ?>
                                                            <article class="list-group-item main_product">
                                                                <a href="#" data-toggle="collapse" data-target="#collapse_p_<?php echo $getproduct4['subcategory']; ?>" data="<?php echo $getproduct4['subcategory']; ?>" aria-expanded="true" class="">
                                                                    <header class="filter-header">
                                                                        <i class="icon-action fa fa-chevron-down"></i>
                                                                    </header>
                                                                </a>
                                                                <?php 
                                                                //$keyword = $_GET['cate_search'];
                                                                $str = $getproduct4['k_name'];
                                                                //$str = preg_replace("/($keyword)/i","<span class='font-weight-bold'>$1</span>",$str);
                                                                //echo " <input type='checkbox' name='ky[]' class='k_select' value='".$getproduct4['k_name']."' data='".$getproduct4['k_name']."'> ".$str; 
                                                                echo " ".$str; 
                                                                
                                                                ?>
                                                            </article>
                                                        <?php 
                                                            }
                                                        } ?>
                                                  </div>      
                                            </article>
                                        <?php 
                                            }
                                        } ?>
                                      </div>  
                                </article>
                            <?php 
                                }
                            } ?>
                          </div>  
                    </article>
           <?php     
                 }
            }else{
                echo 'not found!';
            }
        }
        //echo $body;
        exit;
    }
    public function excludingtreecategory(Request $request) {
          
        if($request->ajax()){
            $search = trim($request->get('data'));
            if($search != ""){
             $sqlsearch = "SELECT keyword.industry_id,keyword.category_id,keyword.subcategory,industry.name as iname,category.name as cname,subcategory.name as sname,keyword.name as k_name,'4' as type FROM keyword LEFT JOIN subcategory ON keyword.subcategory=subcategory.id LEFT JOIN category ON subcategory.categoryid=category.id LEFT JOIN industry ON industry.id=category.industry_id WHERE keyword.name LIKE '%$search%' UNION ALL SELECT industry.id as industry_id,category.id as category_id,subcategory.id as subcategory,industry.name as iname,category.name as cname,subcategory.name as sname,'' as k_name,'3' as type FROM subcategory LEFT JOIN category ON subcategory.categoryid=category.id LEFT JOIN industry ON industry.id=category.industry_id WHERE subcategory.name LIKE '%$search%' UNION ALL SELECT industry.id as industry_id,category.id as category_id,'' as subcategory,industry.name as iname,category.name as cname,'' as sname,'' as k_name,'2' as type FROM category LEFT JOIN industry ON industry.id=category.industry_id WHERE category.name LIKE '%$search%' UNION ALL SELECT industry.id as industry_id,'' as category_id,'' as subcategory,industry.name as iname,'' as cname,'' as sname,'' as k_name,'1' as type FROM industry WHERE industry.name LIKE '%$search%' ORDER BY type ASC";
                 
                $getsearch = DB::select($sqlsearch);
                //$getsearch = collect($getsearch);
                $getsearch = json_decode(json_encode($getsearch), true);
            }
            
             $product = array();
             $product_arr = array();
             $category = array();
             $category_arr = array();
             $subcategory = array();
             $subcategory_arr = array();
             $keyword = array();
             $keyword_arr = array();
             
                foreach($getsearch as $getproduct){
                    if(!in_array($getproduct['industry_id'], $product)){
                     $product[] = $getproduct['industry_id'];
                     $product_arr[] = $getproduct;          
                    }
                    
                    if(!in_array($getproduct['category_id'], $category)){
                     $category[] = $getproduct['category_id'];
                     $category_arr[] = $getproduct;          
                    }
                    
                    if(!in_array($getproduct['subcategory'], $subcategory)){
                     $subcategory[] = $getproduct['subcategory'];
                     $subcategory_arr[] = $getproduct;          
                    }
                    
                    if(!in_array($getproduct['k_name'], $keyword)){
                     $keyword[] = $getproduct['k_name'];
                     $keyword_arr[] = $getproduct;          
                    }
                }
           
            if(!empty($getsearch)){
                 foreach($product_arr as $getproduct){
                ?>
                    <article class="list-group-item main_product">
                    <a href="#" data-toggle="collapse" data-target="#collapse_p_<?php echo $getproduct['industry_id']; ?>" data="<?php echo $getproduct['industry_id']; ?>" aria-expanded="true" class="">
                        <header class="filter-header">
                            <i class="icon-action fa fa-chevron-down"></i>
                        </header>
                    </a>
                    <?php 
                    //$keyword = $_GET['cate_search'];
                    $str = $getproduct['iname'];
                    //$str = preg_replace("/($keyword)/i","<span class='font-weight-bold'>$1</span>",$str);
                
                    echo "<input type='checkbox' class='ei_select' name='in[]' value='".$getproduct['industry_id']."' data='".$getproduct['iname']."'> ".$str; 
                    ?>
                          
                            
                        <div class="filter-content collapse show" id="collapse_p_<?php echo $getproduct['industry_id']; ?>" style="">    
                            <?php foreach($category_arr as $getproduct2){
                                if($getproduct['industry_id'] == $getproduct2['industry_id'] && $getproduct2['cname'] != ""){
                            ?>
                                <article class="list-group-item main_product">
                                    <a href="#" data-toggle="collapse" data-target="#collapse_c_<?php echo $getproduct2['category_id']; ?>" data="<?php echo $getproduct2['category_id']; ?>" aria-expanded="true" class="">
                                        <header class="filter-header">
                                            <i class="icon-action fa fa-chevron-down"></i>
                                        </header>
                                    </a>
                                    <?php 
                                    //$keyword = $_GET['cate_search'];
                                    $str = $getproduct2['cname'];
                                    //$str = preg_replace("/($keyword)/i","<span class='font-weight-bold'>$1</span>",$str);
                                    echo "<input type='checkbox' class='ec_select' name='ct[]' value='".$getproduct2['category_id']."'  data='".$getproduct2['cname']."'> ".$str;
                                    ?>
                                         
                                    
                                    <div class="filter-content collapse show" id="collapse_c_<?php echo $getproduct2['category_id']; ?>" style="">
                                    <?php foreach($subcategory_arr as $getproduct3){
                                            if($getproduct2['category_id'] == $getproduct3['category_id'] && $getproduct3['sname'] != ""){
                                        ?>
                                            <article class="list-group-item main_product">
                                                <a href="#" data-toggle="collapse" data-target="#collapse_sc_<?php echo $getproduct3['subcategory']; ?>" data="<?php echo $getproduct3['subcategory']; ?>" aria-expanded="true" class="">
                                                    <header class="filter-header">
                                                        <i class="icon-action fa fa-chevron-down"></i>
                                                    </header>
                                                </a>
                                                <?php 
                                                //$keyword = $_GET['cate_search'];
                                                $str = $getproduct3['sname'];
                                                //$str = preg_replace("/($keyword)/i","<span class='font-weight-bold'>$1</span>",$str);
                                            
                                                echo "<input type='checkbox' name='sc[]' class='es_select' value='".$getproduct3['subcategory']."' data='".$getproduct3['sname']."'> ".$str; 
                                                ?>
                                                     
                                                <?php //echo $getproduct3['subcategory']; ?>
                                                <div class="filter-content collapse show" id="collapse_sc_<?php echo $getproduct3['subcategory']; ?>" style="">
                                                    <?php foreach($keyword_arr as $getproduct4){
                                                            if($getproduct3['subcategory'] == $getproduct4['subcategory'] && $getproduct4['k_name'] != ""){
                                                        ?>
                                                            <article class="list-group-item main_product">
                                                                <a href="#" data-toggle="collapse" data-target="#collapse_p_<?php echo $getproduct4['subcategory']; ?>" data="<?php echo $getproduct4['subcategory']; ?>" aria-expanded="true" class="">
                                                                    <header class="filter-header">
                                                                        <i class="icon-action fa fa-chevron-down"></i>
                                                                    </header>
                                                                </a>
                                                                <?php 
                                                                //$keyword = $_GET['cate_search'];
                                                                $str = $getproduct4['k_name'];
                                                                //$str = preg_replace("/($keyword)/i","<span class='font-weight-bold'>$1</span>",$str);
                                                                echo " ".$str; 
                                                                
                                                                ?>
                                                                
                                                            </article>
                                                            
                                                        <?php 
                                                            }
                                                        } ?>
                                                  </div>      
                                            </article>
                                            
                                        <?php 
                                            }
                                        } ?>
                                      </div>  
                                </article>
                                
                            <?php 
                                }
                            } ?>
                            
                          </div>  
                            
                    </article>
           <?php     
                 }
            }else{
                echo 'not found!';
            }
        }
        //echo $body;
        exit;
    }
    public function activation($id){
      
        if(Auth::guard('admin')->check()){
        $data = array();
        $datacity = array();
        $state_arr = array();
        $city_arr = array();
        $data = DB::table('userproduct')->where('user_id',$id)->first();
        $is_estimate = 0;
        $is_exact = 0;
        $fromdate = "";
        $min_amount = "";
        $max_amount = "";
        $todate = "";
        
        $product_arr = array();
        $dataproduct = array();
        $category_arr = array();
        $datacategory = array();
        $subcategory_arr = array();
        $datasubcategory = array();

        $eproduct_arr = array();
        $dataeproduct = array();
        $ecategory_arr = array();
        $dataecategory = array();
        $esubcategory_arr = array();
        $dataesubcategory = array();

        $agency_arr = array();
        $dataagency = array();
        $eagency_arr = array();
        $edataagency = array();



        if($data){
           if($data->state != "" && !is_null($data->state)){
            $state_arr = explode(',',$data->state);
            $datacity = DB::table('city')->whereIn('state_id',$state_arr)->get();
           }
           if($data->city != "" && !is_null($data->city)){
            $city_arr = explode(',',$data->city);
           }


           $is_estimate = $data->no_estimates;
           $is_exact = $data->is_exact_keyword;
           $min_amount = $data->Min_Amount;
           $max_amount = $data->Max_Amount;

           if($data->fromdate != "0000-00-00"){
            $fromdate = $data->fromdate;
           }
           if($data->todate != "0000-00-00"){
            $todate = $data->todate;
           }
           
           if($data->productid != "" && !is_null($data->productid)){
                $product_arr = explode(',',$data->productid);
                $dataproduct = DB::table('industry')->whereIn('id',$product_arr)->get();
           } 
           if($data->categoryid != "" && !is_null($data->categoryid)){
                $category_arr = explode(',',$data->categoryid);
                $datacategory = DB::table('category')->whereIn('id',$category_arr)->get();
           }
           if($data->subcategoryid != "" && !is_null($data->subcategoryid)){
                $subcategory_arr = explode(',',$data->subcategoryid);
                $datasubcategory = DB::table('subcategory')->whereIn('id',$subcategory_arr)->get();
           } 

           if($data->exe_productid != "" && !is_null($data->exe_productid)){
                $eproduct_arr = explode(',',$data->exe_productid);
                $dataeproduct = DB::table('industry')->whereIn('id',$eproduct_arr)->get();
           } 
           if($data->exe_categoryid != "" && !is_null($data->exe_categoryid)){
                $ecategory_arr = explode(',',$data->exe_categoryid);
                $dataecategory = DB::table('category')->whereIn('id',$ecategory_arr)->get();
           }
           if($data->exe_subcategoryid != "" && !is_null($data->exe_subcategoryid)){
                $esubcategory_arr = explode(',',$data->exe_subcategoryid);
                $dataesubcategory = DB::table('subcategory')->whereIn('id',$esubcategory_arr)->get();
           }

           if($data->Agency != "" && !is_null($data->Agency)){
                $agency_arr = explode(',',$data->Agency);
                $dataagency = DB::table('agency')->whereIn('agencyid',$agency_arr)->get();
           }

           if($data->excluding_agency != "" && !is_null($data->excluding_agency)){
                $eagency_arr = explode(',',$data->excluding_agency);
                $edataagency = DB::table('agency')->whereIn('agencyid',$eagency_arr)->get();
           }
           
           
        }else{

        }

        // dd($data);
        $datastate = DB::table('state')->where('countryid',356)->get();
        // dd($datastate);
        return view('admin.users.activation',compact('data','datastate','datacity','state_arr','city_arr','is_estimate','is_exact','fromdate','todate','dataproduct','datacategory','datasubcategory','dataeproduct','dataecategory','dataesubcategory','dataagency','edataagency','min_amount','max_amount','id'));  
        }else{
             return redirect()->back();
        }
    }
    
    public function postactivation(Request $request,$id){

        DB::beginTransaction();
        try {

        $request->validate([
            'Userproduct.fromdate' => 'required',
            'Userproduct.todate' => 'required',
        ]);

        $checkrecord = DB::table('userproduct')->where('user_id',$id)->count();
        $requestarr = $request->get('Userproduct');
  
        $productid = "";
        if(isset($requestarr['productid']) && !empty($requestarr['productid'])){
            $productid = implode(',',array_unique($requestarr['productid']));
        }
        $categoryid = "";
        if(isset($requestarr['categoryid']) && !empty($requestarr['categoryid'])){
            $categoryid = implode(',',array_unique($requestarr['categoryid']));
        }
        $subcategoryid = "";
        if(isset($requestarr['subcategoryid']) && !empty($requestarr['subcategoryid'])){
            $subcategoryid = implode(',',array_unique($requestarr['subcategoryid']));
        }
        $keyword = "";
        if(isset($requestarr['keyword']) && $requestarr['keyword'] != ""){
            $keyword = $requestarr['keyword'];
        }
        $excludingkeyword = "";
        if(isset($requestarr['excludingkeyword']) && $requestarr['excludingkeyword'] != ""){
            $excludingkeyword = $requestarr['excludingkeyword'];
        } 
        $refine_keyword = "";
        if(isset($requestarr['refine_keyword']) && $requestarr['refine_keyword'] != ""){
            $refine_keyword = $requestarr['refine_keyword'];
        }

        $eproductid = "";
        if(isset($requestarr['eproductid']) && !empty($requestarr['eproductid'])){
            $eproductid = implode(',',array_unique($requestarr['eproductid']));
        }
        $ecategoryid = "";
        if(isset($requestarr['ecategoryid']) && !empty($requestarr['ecategoryid'])){
            $ecategoryid = implode(',',array_unique($requestarr['ecategoryid']));
        }
        $esubcategoryid = "";
        if(isset($requestarr['esubcategoryid']) && !empty($requestarr['esubcategoryid'])){
            $esubcategoryid = implode(',',array_unique($requestarr['esubcategoryid']));
        }
        $agency = "";
        if(isset($requestarr['agency']) && !empty($requestarr['agency'])){
            $agency = implode(',',array_unique($requestarr['agency']));
        }
        $excludingagency = "";
        if(isset($requestarr['excludingagency']) && !empty($requestarr['excludingagency'])){
            $excludingagency = implode(',',array_unique($requestarr['excludingagency']));
        }
        $state = "";
        if(isset($requestarr['state']) && !empty($requestarr['state'])){
            $state = implode(',',array_unique($requestarr['state']));
        }
        $city = "";
        if(isset($requestarr['city']) && !empty($requestarr['city'])){
            $city = implode(',',array_unique($requestarr['city']));
        }

        $Min_Amount = "";
        if(isset($requestarr['Min_Amount']) && $requestarr['Min_Amount'] != ""){
            $Min_Amount = $requestarr['Min_Amount'];
        }
        $Max_Amount = "";
        if(isset($requestarr['Max_Amount']) && $requestarr['Max_Amount'] != ""){
            $Max_Amount = $requestarr['Max_Amount'];
        }
        $fromdate = "0000-00-00";
        if(isset($requestarr['fromdate']) && $requestarr['fromdate'] != ""){
            $fromdate = $requestarr['fromdate'];
        }
        $todate = "0000-00-00";
        if(isset($requestarr['todate']) && $requestarr['todate'] != ""){
            $todate = $requestarr['todate'];
        }

        $is_estimated = 0;
        if(isset($requestarr['chk_estimated']) && $requestarr['chk_estimated'] != ""){
            $is_estimated = $requestarr['chk_estimated'];
        }
        $is_exact = 0;
        if(isset($requestarr['chk_exact']) && $requestarr['chk_exact'] != ""){
            $is_exact = $requestarr['chk_exact'];
        }
        
        $portal = "";
        if(isset($requestarr['portal']) && $requestarr['portal'] != ""){
            $portal = $requestarr['portal'];
        }
        
        if($checkrecord == 0){
            
            DB::table('userproduct')                
            ->insertOrIgnore([
                'user_id' => $id,
                'productid' => $productid, 
                'categoryid' => $categoryid,
                'subcategoryid' => $subcategoryid,
                'exe_productid' => $eproductid,
                'exe_categoryid' => $ecategoryid,
                'exe_subcategoryid' => $esubcategoryid,
                'Agency' => $agency,
                'excluding_agency' => $excludingagency,
                'state' => $state,
                'city' => $city,
                'keyword' => $keyword,
                'excludingkeyword' => $excludingkeyword,
                'Min_Amount' => $Min_Amount,
                'Max_Amount' => $Max_Amount,
                'no_estimates' => $is_estimated,
                'is_exact_keyword' => $is_exact,
                'refine_keyword' => $refine_keyword,
                'fromdate' => $fromdate,
                'todate' => $todate,
                'portal' => $portal
                
            ]);
            $insertid = DB::getPdo()->lastInsertId();

        }else{
            
            $dataupdate = [
                'productid' => $productid, 
                'categoryid' => $categoryid,
                'subcategoryid' => $subcategoryid,
                'exe_productid' => $eproductid,
                'exe_categoryid' => $ecategoryid,
                'exe_subcategoryid' => $esubcategoryid,
                'Agency' => $agency,
                'excluding_agency' => $excludingagency,
                'state' => $state,
                'city' => $city,
                'keyword' => $keyword,
                'excludingkeyword' => $excludingkeyword,
                'Min_Amount' => $Min_Amount,
                'Max_Amount' => $Max_Amount,
                'no_estimates' => $is_estimated,
                'is_exact_keyword' => $is_exact,
                'refine_keyword' => $refine_keyword,
                'fromdate' => date('Y-m-d' , strtotime($fromdate)),
                'todate' => date('Y-m-d' , strtotime($todate)),
                'portal' => $portal
              
            ];        
            $update = DB::table('userproduct')
            ->where('user_id',$id)
            ->update($dataupdate);
            
        }

        $path = public_path('user_login/'.$id.'.json');
        if (File::exists($path)) 
        {
            File::delete($path);
        }else{
        }
         DB::commit();
         return redirect()->route('users.index')->with('success','Activation update successfully.');
 
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return redirect()->back()->with('error','Something went wrong.');
        }
        
    }

    public function resultactivation($id){
        
        if(Auth::guard('admin')->check()){
           
        $data = array();
        $datacity = array();
        $state_arr = array();
        $city_arr = array();
        $data = DB::table('user_result_product')->where('user_id',$id)->first();
        $is_estimate = 0;
        $is_exact = 0;
        $fromdate = "";
        $min_amount = "";
        $max_amount = "";
        $todate = "";

        $product_arr = array();
        $dataproduct = array();
        $category_arr = array();
        $datacategory = array();
        $subcategory_arr = array();
        $datasubcategory = array();

        $eproduct_arr = array();
        $dataeproduct = array();
        $ecategory_arr = array();
        $dataecategory = array();
        $esubcategory_arr = array();
        $dataesubcategory = array();

        $agency_arr = array();
        $dataagency = array();
        $eagency_arr = array();
        $edataagency = array();



        if($data){
            
           if($data->state != "" && !is_null($data->state)){
            $state_arr = explode(',',$data->state);
            $datacity = DB::table('city')->whereIn('state_id',$state_arr)->get();
           }
           if($data->city != "" && !is_null($data->city)){
            $city_arr = explode(',',$data->city);
           }


           $is_estimate = $data->no_estimates;
           $is_exact = $data->is_exact_keyword;
           $min_amount = $data->Min_Amount;
           $max_amount = $data->Max_Amount;

           if($data->fromdate != "0000-00-00"){
            $fromdate = $data->fromdate;
           }
           if($data->todate != "0000-00-00"){
            $todate = $data->todate;
           }
           
           if($data->productid != "" && !is_null($data->productid)){
                $product_arr = explode(',',$data->productid);
                $dataproduct = DB::table('industry')->whereIn('id',$product_arr)->get();
           } 
           if($data->categoryid != "" && !is_null($data->categoryid)){
                $category_arr = explode(',',$data->categoryid);
                $datacategory = DB::table('category')->whereIn('id',$category_arr)->get();
           }
           if($data->subcategoryid != "" && !is_null($data->subcategoryid)){
                $subcategory_arr = explode(',',$data->subcategoryid);
                $datasubcategory = DB::table('subcategory')->whereIn('id',$subcategory_arr)->get();
           } 

           if($data->exe_productid != "" && !is_null($data->exe_productid)){
                $eproduct_arr = explode(',',$data->exe_productid);
                $dataeproduct = DB::table('industry')->whereIn('id',$eproduct_arr)->get();
           } 
           if($data->exe_categoryid != "" && !is_null($data->exe_categoryid)){
                $ecategory_arr = explode(',',$data->exe_categoryid);
                $dataecategory = DB::table('category')->whereIn('id',$ecategory_arr)->get();
           }
           if($data->exe_subcategoryid != "" && !is_null($data->exe_subcategoryid)){
                $esubcategory_arr = explode(',',$data->exe_subcategoryid);
                $dataesubcategory = DB::table('subcategory')->whereIn('id',$esubcategory_arr)->get();
           }

           if($data->agency != "" && !is_null($data->agency)){
                $agency_arr = explode(',',$data->agency);
                $dataagency = DB::table('agency')->whereIn('agencyid',$agency_arr)->get();
           }

           if($data->excluding_agency != "" && !is_null($data->excluding_agency)){
                $eagency_arr = explode(',',$data->excluding_agency);
                $edataagency = DB::table('agency')->whereIn('agencyid',$eagency_arr)->get();
           }
           
            
        }else{

        }

        //dd($data);
        $datastate = DB::table('state')->where('countryid',356)->get();
        return view('admin.users.resultactivation',compact('data','datastate','datacity','state_arr','city_arr','is_estimate','is_exact','fromdate','todate','dataproduct','datacategory','datasubcategory','dataeproduct','dataecategory','dataesubcategory','dataagency','edataagency','min_amount','max_amount','id'));  
        }else{
             return redirect()->back();
        }
    }
    
    public function postresultactivation(Request $request,$id){

        DB::beginTransaction();
        try {

        $request->validate([
            'Userproduct.fromdate' => 'required',
            'Userproduct.todate' => 'required',
        ]);

        $checkrecord = DB::table('user_result_product')->where('user_id',$id)->count();
        $requestarr = $request->get('Userproduct');
        //dd($requestarr);
        $productid = "";
        if(isset($requestarr['productid']) && !empty($requestarr['productid'])){
            $productid = implode(',',array_unique($requestarr['productid']));
        }
        $categoryid = "";
        if(isset($requestarr['categoryid']) && !empty($requestarr['categoryid'])){
            $categoryid = implode(',',array_unique($requestarr['categoryid']));
        }
        $subcategoryid = "";
        if(isset($requestarr['subcategoryid']) && !empty($requestarr['subcategoryid'])){
            $subcategoryid = implode(',',array_unique($requestarr['subcategoryid']));
        }
        $keyword = "";
        if(isset($requestarr['keyword']) && $requestarr['keyword'] != ""){
            $keyword = $requestarr['keyword'];
        }
        $excludingkeyword = "";
        if(isset($requestarr['excludingkeyword']) && $requestarr['excludingkeyword'] != ""){
            $excludingkeyword = $requestarr['excludingkeyword'];
        } 
        $refine_keyword = "";
        if(isset($requestarr['refine_keyword']) && $requestarr['refine_keyword'] != ""){
            $refine_keyword = $requestarr['refine_keyword'];
        }

        $eproductid = "";
        if(isset($requestarr['eproductid']) && !empty($requestarr['eproductid'])){
            $eproductid = implode(',',array_unique($requestarr['eproductid']));
        }
        $ecategoryid = "";
        if(isset($requestarr['ecategoryid']) && !empty($requestarr['ecategoryid'])){
            $ecategoryid = implode(',',array_unique($requestarr['ecategoryid']));
        }
        $esubcategoryid = "";
        if(isset($requestarr['esubcategoryid']) && !empty($requestarr['esubcategoryid'])){
            $esubcategoryid = implode(',',array_unique($requestarr['esubcategoryid']));
        }
        $agency = "";
        if(isset($requestarr['agency']) && !empty($requestarr['agency'])){
            $agency = implode(',',array_unique($requestarr['agency']));
        }
        $excludingagency = "";
        if(isset($requestarr['excludingagency']) && !empty($requestarr['excludingagency'])){
            $excludingagency = implode(',',array_unique($requestarr['excludingagency']));
        }
        $state = "";
        if(isset($requestarr['state']) && !empty($requestarr['state'])){
            $state = implode(',',array_unique($requestarr['state']));
        }
        $city = "";
        if(isset($requestarr['city']) && !empty($requestarr['city'])){
            $city = implode(',',array_unique($requestarr['city']));
        }

        $Min_Amount = "";
        if(isset($requestarr['Min_Amount']) && $requestarr['Min_Amount'] != ""){
            $Min_Amount = $requestarr['Min_Amount'];
        }
        $Max_Amount = "";
        if(isset($requestarr['Max_Amount']) && $requestarr['Max_Amount'] != ""){
            $Max_Amount = $requestarr['Max_Amount'];
        }
        $fromdate = "0000-00-00";
        if(isset($requestarr['fromdate']) && $requestarr['fromdate'] != ""){
            $fromdate = $requestarr['fromdate'];
        }
        $todate = "0000-00-00";
        if(isset($requestarr['todate']) && $requestarr['todate'] != ""){
            $todate = $requestarr['todate'];
        }

        $is_estimated = 0;
        if(isset($requestarr['chk_estimated']) && $requestarr['chk_estimated'] != ""){
            $is_estimated = $requestarr['chk_estimated'];
        }
        $is_exact = 0;
        if(isset($requestarr['chk_exact']) && $requestarr['chk_exact'] != ""){
            $is_exact = $requestarr['chk_exact'];
        }
        
        
        if($checkrecord == 0){
            
            DB::table('user_result_product')                
            ->insertOrIgnore([
                'user_id' => $id,
                'productid' => $productid, 
                'categoryid' => $categoryid,
                'subcategoryid' => $subcategoryid,
                'exe_productid' => $eproductid,
                'exe_categoryid' => $ecategoryid,
                'exe_subcategoryid' => $esubcategoryid,
                'agency' => $agency,
                'excluding_agency' => $excludingagency,
                'state' => $state,
                'city' => $city,
                'keyword' => $keyword,
                'excludingkeyword' => $excludingkeyword,
                'Min_Amount' => $Min_Amount,
                'Max_Amount' => $Max_Amount,
                'no_estimates' => $is_estimated,
                'is_exact_keyword' => $is_exact,
                'refine_keyword' => $refine_keyword,
                'fromdate' => $fromdate,
                'todate' => $todate,
            ]);
            $insertid = DB::getPdo()->lastInsertId();

        }else{
            
            $dataupdate = [
                'productid' => $productid, 
                'categoryid' => $categoryid,
                'subcategoryid' => $subcategoryid,
                'exe_productid' => $eproductid,
                'exe_categoryid' => $ecategoryid,
                'exe_subcategoryid' => $esubcategoryid,
                'agency' => $agency,
                'excluding_agency' => $excludingagency,
                'state' => $state,
                'city' => $city,
                'keyword' => $keyword,
                'excludingkeyword' => $excludingkeyword,
                'Min_Amount' => $Min_Amount,
                'Max_Amount' => $Max_Amount,
                'no_estimates' => $is_estimated,
                'is_exact_keyword' => $is_exact,
                'refine_keyword' => $refine_keyword,

                'fromdate' => date('Y-m-d' , strtotime($fromdate)),
                'todate' => date('Y-m-d' , strtotime($todate)),

            ];        
            $update = DB::table('user_result_product')
            ->where('user_id',$id)
            ->update($dataupdate);
            
        }

        $path = public_path('user_login/'.$id.'.json');
        if (File::exists($path)) 
        {
            File::delete($path);
        }else{
            
        }
         DB::commit();
         return redirect()->route('users.index')->with('success','Activation update successfully.');
 
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return redirect()->back()->with('error','Something went wrong.');
        }
        
    }
}