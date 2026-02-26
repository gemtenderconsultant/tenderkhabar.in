<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {   
        $data = DB::table('daily_tender_count')->first();
        return view('home',compact('data'));
    }
}