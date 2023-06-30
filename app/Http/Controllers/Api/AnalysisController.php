<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Order;
use Illuminate\Support\Facades\DB;


class AnalysisController extends Controller
{
    public function index(Request $request)
    {
       $subQuery = Order::betweenDate($request->startDate,$request->endDate);

       if($request->type ==='perDay')
         {
             $subQuery->where('status',true)
             ->groupBy('id')
             ->selectRaw('sum(subtotal) as totalPerPurchase,DATE_FORMAT(created_at,"%Y%m%d") as date ')
             ->groupBy('date');

             $data = DB::table($subQuery)
             ->groupBy('date')
             ->selectRaw('date, sum(totalPerPurchase) as total')
             ->get();



         }


        return response()->json([
            'date' => $data,
            'type' => $request->type
        ], Response::HTTP_OK);
    }
}
