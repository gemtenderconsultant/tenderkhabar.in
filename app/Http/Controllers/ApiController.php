<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use DB;
use App\Models\UserProduct;

class ApiController extends Controller
{
    //
    public function search(Request $request)
    {
        $query = $request->input('q', '');
        $type = $request->input('type', 'keyword');

        $list_user = new UserProduct;
        $models = $list_user->statesearching($query, $type); // use $query instead of $id
        $allEvents = $models['dataTender'];
        $total = $models['datatendercount'];
        $statename = $models['selectedstatename'];

        $results = [
            'allEvents' => $allEvents,
            'total' => $total,
            'type' => $type,
            'statename' => $statename,
        ];

        return response()->json([
            'status' => 'success',
            'data' => $results
        ]);
    }
}
