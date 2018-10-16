<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\TrishulPlant1Helper;

class DataController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function get(Request $request)
    {
         return TrishulPlant1Helper::get($request->get('fromDate'),$request->get('toDate'));
    }
}
