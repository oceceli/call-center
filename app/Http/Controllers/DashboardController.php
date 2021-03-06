<?php

namespace App\Http\Controllers;

use App\Models\Call;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->notPermittedTo('view dashboard')) abort(403);


        $dateTo = $request->dateTo ? Carbon::parse($request->dateTo) : Carbon::tomorrow();
        $dateFrom = $request->dateFrom ? Carbon::parse($request->dateFrom) : $dateTo->copy()->subDays(30);

        
        $mainQuery = Call::query();


        $mainQuery
            ->betweenDates($dateFrom, $dateTo)
            ->with('customer');


        $filters = [
            'dateFrom' => $dateFrom->format('Y-m-d'),
            'dateTo' => $dateTo->format('Y-m-d'),
            'callType' => $request->callType,
            // 'perPage' => $request->perPage,
        ];

        

        if($request->callType == 'successfulCalls') {
            $mainQuery->successfulCalls();
        } else if($request->callType == 'unsuccessfulCalls') {
            $mainQuery->unsuccessfulCalls();
        } else {
            $mainQuery->totalCalls();
        }

        $mainQuery->orderBy('updated_at', 'desc');
        $data = $mainQuery->get();

        $counts = [
            'total_calls' => Call::query()
                ->betweenDates($dateFrom, $dateTo)
                ->totalCalls()
                ->count()
                ,
            'successful_calls' => Call::query()
                ->betweenDates($dateFrom, $dateTo)
                ->successfulCalls()
                ->count()
                ,
            'unsuccessful_calls' => Call::query()
                ->betweenDates($dateFrom, $dateTo)
                ->unsuccessfulCalls()
                ->count()
                ,
        ];
        return Inertia::render('Dashboard', ['data' => $data, 'counts' => $counts, 'filters' => $filters]);
    }



    // private function userDashboard()
    // {
    //     $nonAdminData = Call::queuedCalls()->count();
    //     return Inertia::render('UserDashboard', ['data' => [$nonAdminData]]);
    // }

}
