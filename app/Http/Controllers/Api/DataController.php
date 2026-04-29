<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{ 
    public function category()
    {
        $data = DB::table('keyword')->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
    public function authorities()
    {
        $data = DB::table('agency')->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
    public function state()
    {
        $data = DB::table('state')->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
// tender
    // public function live_tenders()
    // {
    //     $data = DB::table('live_tenders')
    //     ->orderBy('ourrefno', 'desc') // latest records first
    //     ->limit(5)           // only 1000 records
    //     ->get();
    //     return response()->json([
    //         'status' => true,
    //         'data' => $data
    //     ]);
    // }
// public function live_tenders()
// {
//     $zip = DB::table('live_tenders')
//         ->select('*', DB::raw("'zip' as filetype"))
//         ->where('documentpath', 'like', '%.zip')
//         ->orderBy('ourrefno', 'desc')
//         ->limit(5);

//     $pdf = DB::table('live_tenders')
//         ->select('*', DB::raw("'pdf' as filetype"))
//         ->where('documentpath', 'like', '%.pdf')
//         ->orderBy('ourrefno', 'desc')
//         ->limit(5);

//     $html = DB::table('live_tenders')
//         ->select('*', DB::raw("'html' as filetype"))
//         ->where('documentpath', 'like', '%.html')
//         ->orderBy('ourrefno', 'desc')
//         ->limit(5);

//     $data = $zip
//         ->unionAll($pdf)
//         ->unionAll($html)
//         ->get();

//     return response()->json([
//         'status' => true,
//         'data' => $data
//     ]);
// }
public function live_tenders()
{
    $zip = DB::table('live_tenders')
        ->where('documentpath', 'REGEXP', '\\.zip($|\\?)')
        ->orderBy('ourrefno', 'desc')
        ->limit(5);

    $pdf = DB::table('live_tenders')
        ->where('documentpath', 'REGEXP', '\\.pdf($|\\?)')
        ->orderBy('ourrefno', 'desc')
        ->limit(5);

    $html = DB::table('live_tenders')
        ->where('documentpath', 'REGEXP', '\\.html($|\\?)')
        ->orderBy('ourrefno', 'desc')
        ->limit(5);

    $data = $zip
        ->unionAll($pdf)
        ->unionAll($html)
        ->get();

    return response()->json([
        'status' => true,
        'data' => $data
    ]);
}
    public function livetendercategory()
    {
        $data = DB::table('livetendercategory')
        ->orderBy('ID', 'desc') // latest records first
        ->limit(5)           // only 1000 records
        ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function tenderinfo_2017()
    {
        $data = DB::table('tenderinfo_2017')
        ->orderBy('ourrefno', 'desc') // latest records first
        ->limit(5)           // only 1000 records
        ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function tenderinfo_items()
    {
        $data = DB::table('tenderinfo_items')
        ->orderBy('id', 'desc') // latest records first
        ->limit(5)           // only 1000 records
        ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
// tender result
    public function tender_result_info()
    {
        $data = DB::table('tender_result_info')
        ->orderBy('id', 'desc') // latest records first
        ->limit(5)           // only 1000 records
        ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
    // Customer Plan API
    public function tender_result_category()
    {
        $data = DB::table('tender_result_category')
        ->orderBy('ID', 'desc') // latest records first
        ->limit(5)           // only 1000 records
        ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    // Payments API
    public function tender_doc()
    {
        $data = DB::table('tender_doc')->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
}