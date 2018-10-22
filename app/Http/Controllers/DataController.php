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

        if($request->get('batchingPlantId') == 'TRISHUL1')
        {
            return TrishulPlant1Helper::get($request->get('fromDate'),$request->get('toDate'),$request->get('all',false));
        }

        return [];
        
    }

    public function last5(Request $request)
    {

        if($request->get('batchingPlantId') == 'TRISHUL1')
        {
            return TrishulPlant1Helper::last5();
        }

        return [];
        
    }
}
