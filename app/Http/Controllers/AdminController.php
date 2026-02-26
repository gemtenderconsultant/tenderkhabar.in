<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Blog;
use App\Models\Blogmeta;
use Hash;
use Auth;
use Session;
use DB;
use Illuminate\Support\Arr;
use Response;
use DataTables;
use App\Models\User;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Redirect;
class AdminController extends Controller
{   
    
    public function index()
    {   
        if(Auth::guard('admin')->check()){
            $users = Admin::latest()->paginate(5);
            return view('admin.admins.index',compact('admins'))->with('i', (request()->input('page', 1) - 1) * 5);
        }else{
             return redirect()->back();
        }
    }
    
   public function adminlist(Request $request){

        if(Auth::guard('admin')->check()){

        if($request->ajax()){

                        $search  = $request->input('search.value');
                        $columns = $request->get('columns');
                        $order   = isset($_GET[ 'order' ]) ? $_GET[ 'order' ] : [];

                        $count_total = \DB::table('admins')
                                          //->join('tbl_user_tender_product', 'users.id', '=', 'tbl_user_tender_product.user_id')
                                          ->count();

                        $count_filter = \DB::table('admins')
                                           //->join('tbl_user_tender_product', 'users.id', '=', 'tbl_user_tender_product.user_id')
                                            
                                           //->where('brands.description', 'LIKE', '%' . $search . '%')
                                           ->orWhere('admins.id', 'LIKE', '%' . $search . '%')
                                           ->orWhere('admins.name', 'LIKE', '%' . $search . '%')
                                            ->orWhere('admins.email', 'LIKE', '%' . $search . '%')
                                           
                                           ->count();

                        $items = \DB::table('admins')
                                    
                                    ->select(
                                        //'users.*','userproduct.fromdate','userproduct.todate'
                                        'admins.*'    
                                    );
                        foreach ($order as $o) {
                            if(isset($columns[ $o[ 'column' ] ])) {
                                $items = $items->orderBy($columns[ $o[ 'column' ] ][ 'name' ], $o[ 'dir' ]);
                            }
                        }
                        $items = $items->take(10);

                        return Datatables::of($items)
                         ->with([
                             "recordsTotal"    => $count_total,
                             "recordsFiltered" => $count_filter,
                         ])
                         ->addColumn('action', function ($data) {
                                return '<form action="'.route('admins.destroy',$data->id).'" method="POST">
                                  '. csrf_field().' 
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="'.route('admins.edit', $data->id).'" class="btn btn-xs btn-primary">Edit</a>
                                <a href="'.route('admins.show', $data->id).'" class="btn btn-xs btn-info">Show</a>
                                <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                                
                                
                                </form>';
                            })
                         //->rawColumns(['items_id', 'brands_description'])
                         ->make(TRUE);

                     }

                    return view('admin.admins.index');  
                 }else{
                    return redirect()->back();
                 }
   }   

    public function create()
    {
        return view('admin.admins.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            //'email' => 'required',
            'email' => "unique:admins,email",
            //'email' => "unique:admins,email,$this->id,id"
            'password' => 'required',
        ]);
         
         $data = $request->all(); 
         $data['password'] = Hash::make($request->get('password'));
         
        Admin::create($data);
        return redirect()->route('adminlist')->with('success','Admin created successfully.');
    }
    public function show(Admin $admin)
    {
        return view('admin.admins.show',compact('admin'));
    }
    public function edit(Admin $admin)
    {
        return view('admin.admins.edit',compact('admin'));
    }
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required',
            //'email' => 'required',
            'email' => "unique:admins,email,$admin->id,id"
            //'password' => 'required',
        ]);
        $data = $request->all(); 
        $admin->update($data);
        return redirect()->route('adminlist')->with('success','Admin updated successfully');
    }
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('adminlist')->with('success','Admin deleted successfully');
    }
    public function __construct()
    {
        //$this->middleware('auth');
        //$this->middleware('userstatus');
        //$this->middleware('guest:admin')->except('logout');
        //$this->middleware('guest:admin');
    }
    public function showAdminLoginForm(Request $request){
         if(Auth::guard('admin')->check()){
             return redirect()->intended('/admin/dashboard');
         }
         return view('admin.login-view');
    }
    public function admindashboard(){
       
         if(Auth::guard('admin')->check()){
             return view('admin.admindashboard');
         }else{
             return redirect()->intended('/admin/login');
         }
         
    }
    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect('/admin/login');
    }
    
    public function adminLogin(Request $request)
    {   
        if(Auth::guard('admin')->check()){
            return redirect()->intended('/admin/dashboard');
        }else{
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (Auth::guard('admin')->attempt($request->only(['email','password']), $request->get('remember'))){
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withInput($request->only('email', 'remember'));
        }
    }

    public function userlist(Request $request){
        if(Auth::guard('admin')->check()){
            if($request->ajax()){
                $draw = $request->get('draw');
                $start = $request->get("start");
                $rowperpage = $request->get("length"); // Rows display per page

                $columnIndex_arr = $request->get('order');
                $columnName_arr = $request->get('columns');
                $order_arr = $request->get('order');
                $search_arr = $request->get('search');

                $columnIndex = $columnIndex_arr[0]['column']; // Column index
                $columnName = $columnName_arr[$columnIndex]['data']; // Column name
                $columnSortOrder = $order_arr[0]['dir']; // asc or desc
                $searchValue = $search_arr['value']; // Search value

                // Total records
                $totalRecords = User::select('count(user.*) as allcount')
                                ->leftjoin('company','user.user_id','company.user_id')
                                ->count();
                $totalRecordswithFilter = User::select('count(user.*) as allcount')
                                        ->leftjoin('company','user.user_id','company.user_id')
                                        ->where('company.company_name', 'like', '%' .$searchValue . '%')
                                        ->Orwhere('user.email', 'like', '%' .$searchValue . '%')
                                        ->count();

                // Fetch records
                $records = User::orderBy($columnName,$columnSortOrder)
                    ->leftjoin('company','user.user_id','company.user_id')
                    ->where('company.company_name', 'like', '%' .$searchValue . '%')
                     ->Orwhere('user.email', 'like', '%' .$searchValue . '%')
                    ->select('user.user_id','user.user_code','company.company_name','user.username','user.email','user.user_primary_phone','user.user_first_name','user.user_last_name')
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();

                $data_arr = array();
                $sno = $start+1;
                foreach($records as $record){
                    $data_arr[] = array(
                        "user_id" => $record->user_id,
                        "user_code" => $record->user_code,
                        "company_name" =>$record->company_name, 
                        "username" => $record->username,
                        "email" => $record->email,
                        "phone" => $record->user_primary_phone,
                        "name" => $record->user_first_name.' '.$record->user_last_name,
                        "action" =>'<a href="javascript:void(0)" class="btn btn-primary btn-sm refresh-json" data='.$record->user_id.'>Refresh</a>'
                    );
                }

                $response = array(
                    "draw" => intval($draw),
                    "iTotalRecords" => $totalRecords,
                    "iTotalDisplayRecords" => $totalRecordswithFilter,
                    "aaData" => $data_arr
                ); 

                echo json_encode($response);
                exit;
            }
            return view('admin.userlist');
        }else{
            return view('admin.login-view');
        }    

    }

    public function refreshuserjson(Request $request){

        $path = public_path('user_login/'.$request->id.'.json');
        if (File::exists($path)) 
        {
            File::delete($path);
            return response::json(['status'=>'success','msg'=>'JSON Refresh Successfully.']);
        }else{
            return response::json(['status'=>'error','msg'=>'JSON Not Exist.']);
        }
    }

    public function bloglist(Request $request){
        if(Auth::guard('admin')->check()){
            if($request->ajax()){
                $draw = $request->get('draw');
                $start = $request->get("start");
                $rowperpage = $request->get("length"); // Rows display per page

                $columnIndex_arr = $request->get('order');
                $columnName_arr = $request->get('columns');
                $order_arr = $request->get('order');
                $search_arr = $request->get('search');

                $columnIndex = $columnIndex_arr[0]['column']; // Column index
                $columnName = $columnName_arr[$columnIndex]['data']; // Column name
                $columnSortOrder = $order_arr[0]['dir']; // asc or desc
                $searchValue = $search_arr['value']; // Search value

                // Total records
                $totalRecords = DB::table('blog')->select('count(blog.*) as allcount')
                                ->count();
                $totalRecordswithFilter = DB::table('blog')->select('count(blog.*) as allcount')
                    ->where('blog.name', 'like', '%' .$searchValue . '%')
                    ->count();

                // Fetch records
                $records = DB::table('blog')->orderBy($columnName,$columnSortOrder)
                    ->where('blog.name', 'like', '%' .$searchValue . '%')
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();

                $data_arr = array();
                $sno = $start+1;

                foreach($records as $record){
                    $data_arr[] = array(
                        "id" => $record->id,
                        "name" => $record->name,
                        "description" => $record->description,
                        "category" => ($record->category == 1) ? "Tender" : "GeM",
                        "uploadby" => $record->uploadby,
                        "action" =>'<a href="'.route('blog-edit',$record->id).'" class="btn btn-primary btn-sm w-100 mb-1" data='.$record->id.'>Edit</a><a href="'.route('blogmeta-create',$record->id).'" class="btn w-100 btn-primary btn-sm">Blogmeta</a>');
                }
                $response = array(
                    "draw" => intval($draw),
                    "iTotalRecords" => $totalRecords,
                    "iTotalDisplayRecords" => $totalRecordswithFilter,
                    "aaData" => $data_arr
                ); 

                echo json_encode($response);
                exit;
            }
            return view('admin.blog.list');
        }else{
            return view('admin.login-view');
        }
    }

    public function blogcreate(request $request){

        return view('admin.blog.create');
    }

    public function blogstore(Request $request){
          
        if(Auth::guard('admin')->check()){
         $validate_data = [
                'name'   => 'required',
                'description'   => 'required',
                'category'   => 'required',
                'uploadby'   => 'required',
                'type'   => 'required',
                'tags'   => 'required'];

        if($request->has('type')  && $request->get('type') == 0){
            $validate_data['image'] = ['required'];
        }

        if($request->has('type') && $request->get('type') == 1){
            $validate_data['youtube_url'] = 'required';
        }   
        
        $validated =  $this->validate($request,$validate_data);

            if ($request->hasFile('image')){
                $imageName = time().'.'.$request->image->extension();
                $file_path = public_path('frontend/upload/blog_image',$imageName);  

                // put image in the public storage
                $request->image->move(public_path('frontend/upload/blog_image'), $imageName);
            }
            if($request->has('type') && $request->type == 0){
                $validated['image'] = "upload/blog_image/".$imageName;
            }

            if($request->has('type') && $request->type == 1){
                $validated['image'] = $request->youtube_url;
            }    
            $validated['slug'] = Str::slug($request->name);

        // insert only requests that already validated in the StoreRequest
            
        $create = Blog::create($validated);
        if($create) {
            $request->session()->flash('successMsg','Blog Saved succesfully!');
            return view('admin.blog.list');
        }
        return abort(500);
        }
    }

    public function blogupdate(Request $request,$id){
        if(Auth::guard('admin')->check()){

         $validate_data = [
                'name'   => 'required',
                'description'   => 'required',
                'category'   => 'required',
                'uploadby'   => 'required',
                'type'   => 'required',
                'tags'   => 'required'];

        if ($request->hasFile('image')){        
            if($request->has('type')  && $request->get('type') == 0){
                $validate_data['file'] = ['image', 'mimes:jpeg,png,jpg,gif,svg'];
            }
        }

        if($request->has('type')  && $request->get('type') == 1){
            $validate_data['youtube_url'] = 'required';
        }

         
         $validated =  $this->validate($request,$validate_data);


            if ($request->hasFile('image')){

                if(file_exists(public_path($request->get('pimage')))){
                     unlink(public_path($request->get('pimage')));
                }
                $imageName = time().'.'.$request->image->extension();
                $file_path = public_path('frontend/upload/blog_image',$imageName);  
                // put image in the public storage
                $request->image->move(public_path('frontend/upload/blog_image'), $imageName);
                if($request->has('type') && $request->type == 0){
                    $validated['image'] = "upload/blog_image/".$imageName;
                }


            }else{
                if($request->has('type') && $request->type == 0)
                {
                    $validated['image'] = $request->get('pimage');   
                }
            }
            if($request->has('type') && $request->type == 1){

                $validated['image'] = $request->youtube_url;
                if(file_exists(public_path($request->get('pimage')))){
                    unlink(public_path($request->get('pimage')));
                }
            }    
            $validated['slug'] = Str::slug($request->name);
            $filtered = Arr::except($validated, ['youtube_url']);
            
            // update only requests that already validated in the StoreRequest
            $update = Blog::where('id',$id)->update($filtered);
            if($update) {
                $request->session()->flash('successMsg','Blog Update succesfully!');
                return view('admin.blog.list');
            }
            return view('admin.blog.list');
        }
    }
    public function blogedit($id){
        $data = DB::table('blog')->where('id',$id)->first();
        return view('admin.blog.edit',compact('data'));
    }

    public function blogmetacreate($blogid){
        $blog = DB::table('blog')->where('id',$blogid)->first();
        $blogmeta = DB::table('blogmeta')->where('blogid',$blogid)->first();
        
        return view('admin.blogmeta.create',compact('blog','blogmeta'));   
    }

    public function blogmetastore(Request $request){
        if(Auth::guard('admin')->check()){
            $validate_data = [
                'blogid' => 'required',
                'title'   => 'required',
                'keywords'   => 'required',
                'category'   => 'required',
                'description'   => 'required'];

            $validated =  $this->validate($request,$validate_data);
            Blogmeta::where('blogid',$request->get('blogid'))->delete();
            $create = Blogmeta::create($validated);
            if($create) {
                $request->session()->flash('successMsg','BlogMate Created succesfully!');
                return view('admin.blog.list');
            }
        }
    }

    public function updatepassword(Request $request){
        if(Auth::guard('admin')->check()){
            $password = rand(11111111,99999999);
            $password = "123456";
            $hashed = Hash::make($password);
            DB::table('users')
            ->where('id',$request->id)
            ->update(array('password' => $hashed));
            
            $user = DB::table('users')
                    ->where('id',$request->id)
                    ->first();
            
            $to = $user->email;
            $subject = "User-ID and Password-www.tenderkhabar.in("
            .$user->id.")";

            $message = "";
            $message = view('emails.update-password', compact('user','password'))->render();

            //$headers = "Password Update";
            $headers = "";
            $headers .= 'From: tenderkhabar <noreply@tenderkhabar.com>' . "\r\n";
            $headers .= 'Cc: tenderkhabar2@gmail.com' . "\r\n";

            $headers .= "MIME-Version: 1.0" . "\r\n"; 
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 

            
            mail($to,$subject,$message,$headers);
            return response::json(['status'=>'success','msg'=>'Password Has Been Updated successfully']);
        }else{
           return response::json(['status'=>'error','msg'=>'Please contact To Admin']);
        }
    }

    public function adminemails(){
        if(Auth::guard('admin')->check()){
            $data = array();
            $data = DB::table('userinfo')->select(DB::raw('SUM(no_tender_available) as total'))->where('emailtype',1)->first();
            $totaldata =DB::table('tbl_emails')->select(DB::raw('SUM(totalemails) as total'))->where('portal_name','tenderkhabar')->first();
            return view('admin.adminemails',compact('data','totaldata'));
        }else{
            return redirect()->intended('/admin/login');
        }
    }

    public function emailcredit(){
        if(Auth::guard('admin')->check()){
            $data =DB::table('tbl_emails')->where('portal_name','tenderkhabar')->get();     
             return view('admin.emailcredit',compact('data'));
         }else{
             return redirect()->intended('/admin/login');
         }
    }
    public function smsreport()
    {   
        if(Auth::guard('admin')->check()){
            return view('admin.smsreport');
        }else{
             return redirect()->back();
        }
    }

    public function ajaxsmsreport(Request $request){

        if(Auth::guard('admin')->check()){

        if($request->ajax()){

            $search  = $request->input('search.value');
            $columns = $request->get('columns');
            $order   = isset($_GET[ 'order' ]) ? $_GET[ 'order' ] : [];
            
            //SELECT tender_date,SUM(no_tender_available) as total FROM `userinfo` WHERE emailtype=1 GROUP BY tender_date;
            $count_total = DB::table('userinfo')
                            ->select(DB::raw('count(DISTINCT tender_date) as total'))    
                            ->orwhere('emailtype',1)
                            //->groupBy('tender_date')
                            ->first();
            $count_total = $count_total->total;

            $count_filter = DB::table('userinfo')
                            ->where('emailtype',1)
                            ->select(DB::raw('count(DISTINCT tender_date) as total'))    
                            ->orwhere('userinfo.tender_date', 'LIKE', '%' . $search . '%')
                            ->groupby('tender_date')
                            ->first();
            $count_filter = $count_filter->total;
            
            $items = DB::table('userinfo')
                     ->select('userinfo.tender_date',DB::raw('SUM(userinfo.no_tender_available) as total'),DB::raw('sum(case when status=0 then no_tender_available ELSE 0 end) as free'),DB::raw('sum(case when status=1 then no_tender_available ELSE 0 end) as paid'))
                     ->where('emailtype',1)
                     ->groupby('userinfo.tender_date');
            
            foreach ($order as $o) {
                if(isset($columns[ $o[ 'column' ] ])) {
                    $items = $items->orderBy($columns[ $o[ 'column' ] ][ 'name' ], $o[ 'dir' ]);
                }
            }
            
            $items = $items->take(10);
            return Datatables::of($items)
             ->with([
                 "recordsTotal"    => $count_total,
                 "recordsFiltered" => $count_filter,
             ])
            ->make(TRUE);
        }

        return view('admin.smsreport');  
    }else{
        return redirect()->back();
     }
   }

   public function myprofile(){
        if(Auth::check()){
            $user = Auth::user();
            return view('backend/my-profile',compact('user'));    
        }else{
            return redirect::route('login');
        }
    }

    public function changepwd(Request $request){
        if(Auth::guard('admin')->check()){
            if($request->has('user')){
                $request->validate([
                    'password' => 'required|string|min:8|confirmed',
                ]);
                User::where('id', $request->user)
                ->update(['password'=>Hash::make($request->password)]);
                return back()->with('success', 'Password changed successfully.');
            }else{
                $client = User::all();
                return view('admin/change-password',compact('client'));        
            }
        }else{
            return redirect()->route('admin.login-view');
        }
    }


    public function ajaxuserselect(Request $request){
        $query = $request->get('q');
        return User::where('email', 'like', "%$query%")
        ->select('id', DB::raw('email as name'))
        ->take(10)
        ->get();
    }
}