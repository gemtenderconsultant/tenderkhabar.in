<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use Auth;
use DataTables;
use DB;
use Redirect;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if(Auth::guard('admin')->check()){
            $users = User::latest()->paginate(5);
            return view('admin.users.index',compact('users'))->with('i', (request()->input('page', 1) - 1) * 5);
        }else{
             return redirect()->back();
        }
    }
 
   public function userlist(Request $request){
    if(Auth::guard('admin')->check()){
        if($request->ajax()){
            $search  = $request->input('search.value');
            $columns = $request->get('columns');
            $order   = isset($_GET[ 'order' ]) ? $_GET[ 'order' ] : [];

            $count_total = \DB::table('users')
                              //->join('tbl_user_tender_product', 'users.id', '=', 'tbl_user_tender_product.user_id')
                              ->count();

            $count_filter = \DB::table('users')
                               //->join('tbl_user_tender_product', 'users.id', '=', 'tbl_user_tender_product.user_id')
                                ->leftjoin('admins', 'users.created_by', '=', 'admins.id')
                               //->where('brands.description', 'LIKE', '%' . $search . '%')
                               ->orWhere('users.id', 'LIKE', '%' . $search . '%')
                               ->orWhere('users.name', 'LIKE', '%' . $search . '%')
                                ->orWhere('users.email', 'LIKE', '%' . $search . '%')
                                 ->orWhere('users.mobile', 'LIKE', '%' . $search . '%')
                                 ->orWhere('users.status', 'LIKE', '%' . $search . '%')
                                 ->orWhere('admins.name', 'LIKE', '%' . $search . '%')
                                 //->orWhere('tbl_user_tender_product.to_date', 'LIKE', '%' . $search . '%')
                                  ->orWhere('users.company_name', 'LIKE', '%' . $search . '%')
                               ->count();

            $items = \DB::table('users')
                        ->leftjoin('admins', 'users.created_by', '=', 'admins.id')
                        ->select(
                            //'users.*','userproduct.fromdate','userproduct.todate'
                            'users.*','admins.name as aname',
                            DB::raw("(SELECT case when count(*) > 0 then 'Yes' else 'No' end FROM userproduct WHERE user_id=users.id) as checkuser")
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
                    return '<form action="'.route('users.destroy',$data->id).'" method="POST">
                      '. csrf_field().' 
                    <input type="hidden" name="_method" value="DELETE">
                    <a href="'.route('users.edit', $data->id).'" class="btn btn-xs btn-primary mb-1 w-100">Edit</a>
                    <a href="'.route('users.show', $data->id).'" class="btn btn-xs btn-info mb-1 w-100">Show</a>
                    <button type="submit" class="btn btn-xs btn-danger mb-1 w-100">Delete</button>
                    <a href="'.route('activation', $data->id).'" class="btn btn-xs btn-primary mb-1 w-100">Activation</a>
                    <a href="'.route('resultactivation', $data->id).'" class="btn btn-xs btn-primary mb-1 w-100">Result Activation</a>
                    <a href="javascript:void(0)" class="btn btn-primary btn-xs refresh-json mb-1 w-100" data='.$data->id.'>Refresh</a>
                    <a href="javascript:void(0)" class="btn btn-primary btn-xs change-password mb-1 w-100" data-user_id='.$data->id.'>Update Password</a>
                    </form>';
                })
             //->rawColumns(['items_id', 'brands_description'])
             ->make(TRUE);

         }

        return view('admin.users.index');  
     }else{
        return redirect()->back();
     }
   } 

    public function userlist2(Request $request){
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
                $totalRecords = User::select('count(users.*) as allcount')
                                ->count();
                $totalRecordswithFilter = User::select('count(users.*) as allcount')
                        
                                        ->where('users.company_name', 'like', '%' .$searchValue . '%')
                                        ->Orwhere('users.email', 'like', '%' .$searchValue . '%')
                                        ->count();

                // Fetch records
                $records = User::orderBy($columnName,$columnSortOrder)
                    ->where('users.company_name', 'like', '%' .$searchValue . '%')
                     ->Orwhere('users.email', 'like', '%' .$searchValue . '%')
                    ->select('users.id','users.email','users.company_name','users.name','users.mobile','users.alt_email','users.status','users.is_tender','users.is_result')
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();

                $data_arr = array();
                $sno = $start+1;
                foreach($records as $record){
                    $data_arr[] = array(
                        "id" => $record->id,
                        "email" => $record->email,
                        "name" =>$record->name, 
                        "company_name" => $record->company_name,
                        "mobile" => $record->mobile,
                        "alt_email" => $record->alt_email,
                        "status" => $record->status,
                        "is_tender" => $record->is_tender,
                        "is_result" => $record->is_result,
                        
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
            return view('admin.users.index');
        }else{
            return view('admin.login-view');
        }    

    }
     
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            //'email' => 'required',
            'email' => 'required|email|unique:users',
            'company_name' => 'required',
            'mobile' => 'required',
            'status' => 'required',
        ]);
         
         $data = $request->all(); 
         $data['password'] = Hash::make($request->get('mobile'));
         $data['created_by'] = Auth::guard('admin')->user()->id;
          
        User::create($data);
        return redirect()->route('users.index')->with('success','User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'company_name' => 'required',
            'mobile' => 'required',
            'status' => 'required',
        ]);
        $data = $request->all();
        if($request->has('is_tender')){
            $data['is_tender'] = 1;
        }else{
            $data['is_tender'] = 0;
        }
        if($request->has('is_result')){
            $data['is_result'] = 1;
        }else{
            $data['is_result'] = 0;
        }
        
        $user->update($data);
        return redirect()->route('users.index')->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
  
        return redirect()->route('users.index')->with('success','User deleted successfully');
    }
    
    
}