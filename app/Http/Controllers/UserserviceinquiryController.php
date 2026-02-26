<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\UserServiceInquiry;
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
class UserserviceinquiryController extends Controller
{   
    
    public function index()
    {   
        if(Auth::guard('admin')->check()){
        	return view('admin.userserviceinquiry.index');
        }else{
             return redirect()->back();
        }
    }
 
   public function userserviceinquirylist(Request $request){

        if(Auth::guard('admin')->check()){

        if($request->ajax()){

            $search  = $request->input('search.value');
            $columns = $request->get('columns');
            $order   = isset($_GET[ 'order' ]) ? $_GET[ 'order' ] : [];

            $count_total = DB::table('userserviceinquiry')
                            ->count();

            $count_filter = DB::table('userserviceinquiry')
                           	->orWhere('userserviceinquiry.sid', 'LIKE', '%' . $search . '%')
                           	->orWhere('userserviceinquiry.name', 'LIKE', '%' . $search . '%')
                           	->orWhere('userserviceinquiry.email', 'LIKE', '%' . $search . '%')
                            ->count();

            $items = DB::table('userserviceinquiry')
                     ->select('userserviceinquiry.*');
            
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

	 	return view('admin.userserviceinquirylist.index');  
    }else{
        return redirect()->back();
     }
   }   
}