<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DB;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/tender-listing';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'company_name' => ['required', 'string', 'max:255'],
            'mobile' => 'required|numeric|min:10',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {   
        $rid = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'company_name' => $data['company_name'],
            'mobile' => $data['mobile'],
            'status' => 'Free',
            'password' => Hash::make($data['password']),
            'is_tender' => 1
        ]);

        $name = $data['name'];
        $email = $data['email'];
        $company_name = $data['company_name'];
        $mobile = $data['mobile'];

        $id = DB::getPdo()->lastInsertId();

        $keyword = $data['keyword'];
        $fromdate = date('Y-m-d');
        $todate = date('Y-m-d', strtotime('+7 day', strtotime($fromdate)));
         $datainsert = [
                'user_id' => $id,
                'keyword' => $keyword,
                'fromdate' => $fromdate,
                'todate' => $todate
             ];
        $productid = DB::table('userproduct')->insertOrIgnore($datainsert);
        try {
              // ✅ First API call
              $apiResponse1 = Http::asForm()->post('https://bidders365.in/crmnew/api/tenderkhabar_api/', [ 
                  'client_name'    => $name,
                  'client_email'   => $email,
                  'client_phone'   => $mobile,
                  'client_company' => $company_name,
                  'message'        => $keyword,
              ]);
              // ✅ Second API call (example: sending same or different data)
              $apiResponse2 = Http::asForm()->post('https://www.gemtenderconsultant.in/api/tenderkhabar_api/', [
                  'client_name'    => $name,
                  'client_email'   => $email,
                  'client_phone'   => $mobile,
                  'client_company' => $company_name,
                  'message'        => $keyword,
              ]);

          } 
          catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'msg'     => 'Exception: ' . $e->getMessage()
                ], 500);
            }
       
        return $rid;
    }
}
