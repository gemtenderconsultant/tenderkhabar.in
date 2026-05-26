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
    //admin/login
    public function showAdminLoginForm(Request $request){
         if(Auth::guard('admin')->check()){
             return redirect()->intended('/admin/dashboard');
         }
         return view('admin.login-view');
    }
    public function adminLogout(Request $request){
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect('/admin/login');
    }
    public function adminLogin(Request $request){   
        if(Auth::guard('admin')->check()){
            return redirect()->intended('/admin/dashboard');
        }else{
        $request->validate([
            'email'   => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (Auth::guard('admin')->attempt($request->only(['email','password']), $request->get('remember'))){
        //   dd('Login Success');
        return redirect()->intended('/admin/dashboard');
        }
        return back()->withInput($request->only('email', 'remember'))
            ->with('error','Invalid Email or Password');
        }
    }
    public function admindashboard(){
        if(Auth::guard('admin')->check()){
            $today = date('Y-m-d');
            $count_total = \DB::table('users')
                             ->count();
            
            $activecount = \DB::table('users')
                    ->leftJoin('admins', 'users.created_by', '=', 'admins.id')
                    ->select('users.*','admins.name as aname',
                        \DB::raw("(SELECT COUNT(*) FROM userproduct  WHERE userproduct.user_id = users.id AND userproduct.todate >= '$today' ) as active_count"))
                    ->count();
            $pendingcount = \DB::table('users')
                    ->leftJoin('userproduct', 'userproduct.user_id', '=', 'users.id')
                    ->whereNull('userproduct.user_id')
                    ->count();
            $count_inquriy = \DB::table('userserviceinquiry')
                             ->count();        
            return view('admin.dashboard',compact('count_total','activecount','count_inquriy','pendingcount'));
        }else{
            return redirect()->intended('/admin/login');
        }
    }
    public function adminlist(Request $request){
        if(Auth::guard('admin')->check()){

        if($request->ajax()){
            $search  = $request->input('search.value');
            $columns = $request->get('columns');
            $order   = isset($_GET[ 'order' ]) ? $_GET[ 'order' ] : [];

            $count_total = \DB::table('admins')
                            ->count();

            $count_filter = \DB::table('admins')
                                ->orWhere('admins.id', 'LIKE', '%' . $search . '%')
                                ->orWhere('admins.name', 'LIKE', '%' . $search . '%')
                                ->orWhere('admins.email', 'LIKE', '%' . $search . '%')
                                ->count();

            $items = \DB::table('admins')
                        ->select('admins.*' );
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
                            <div class="d-flex flex-wrap gap-2">
                                <a class="btn btn-primary btn-action edit-admin-btn" data-id="'.$data->id.'" data-bs-toggle="modal" data-bs-target="#editAdminModal">Edit</a>
                                <a class="btn btn-info text-white btn-action show-admin-btn" data-id="'.$data->id.'" data-bs-toggle="modal" data-bs-target="#showAdminModal">Show</a>
                                <button type="submit" class="btn btn-danger btn-action">Delete</button>
                            </div>
                            </form>';
                })
                ->make(TRUE);

            }
            return view('admin.admins.index');  
        }else{
            return redirect()->back();
        }
    }
    public function inquriylist(Request $request){
        if (Auth::guard('admin')->check()) {

            if ($request->ajax()) {

                $query = DB::table('userserviceinquiry')
                            ->orderBy('sid', 'DESC')
                            ->take(5)
                            ->select('userserviceinquiry.*');
                
                return Datatables::of($query)

                    ->addColumn('company', function ($row) {
                        return '
                            <div class="fw-bold text-dark">' . $row->name . '</div>
                            <div class="small text-muted">' . ($row->company_name ?? '-') . '</div>
                        ';
                    })

                    ->addColumn('contact', function ($row) {
                        return '
                            <div>' . $row->email . '</div>
                            <div class="small text-muted">' . $row->user_primary_phone . '</div>
                        ';
                    })

                    ->addColumn('date', function ($row) {
                        return '<span class="badge bg-light text-secondary border">'
                            . date('d M Y H:i', strtotime($row->insert_date_time))
                            . '</span>';
                    })

                    ->addColumn('flag', function ($row) {
                        return '<span class="badge badge-soft-primary px-2 py-1 rounded-pill">
                                    contract-to-admin
                                </span>';
                    })

                    ->rawColumns(['company', 'contact', 'date', 'flag'])

                    ->make(true);
            }

            return view('admin.dashboard');

        } else {
            return redirect()->back();
        }
    }
    public function updatepassword(Request $request){
        if(Auth::guard('admin')->check()){
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
    public function store(Request $request){
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
    public function getAdmin($id){
            $user = \DB::table('admins')
                    ->where('id', $id)
                    ->first();

            if ($user) {
                return response()->json([
                    'status' => 'success',
                    'data' => $user
                ]);
            }
            return response()->json([
                'status' => 'error'
            ]);
    }
    public function changePassword(Request $request){
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:6|confirmed',
            ]);

            $admin = Auth::guard('admin')->user(); // or Auth::user()

            // check current password
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }

            // update password
            $admin->password = Hash::make($request->password);
            $admin->save();

            return back()->with('success', 'Password updated successfully');
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
    public function destroy(Admin $admin){
        $admin->delete();
        return redirect()->route('adminlist')->with('success','Admin deleted successfully');
    }
}