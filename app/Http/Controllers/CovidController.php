<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\Covid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CovidController extends Controller
{
    public function getBarChartData(Request $request)
    {
        $countryData = Covid::where('country_id', $request->country)
            // use When for filtering by date
            ->when($request->from, function ($query) use ($request) {
                // When the Request has from then this method will be called
                return $query->whereDate('date', '>=', $request->from);
            })
            ->when($request->to, function ($query) use ($request) {
                // When the Request has to then this method will be called
                return $query->whereDate('date', '<=', $request->to);
            })
            ->selectRaw('SUM(Confirmed) as Confirmed, SUM(Recovered) as Recovered, SUM(Deaths) as Deaths')
            ->first();

        // to get the country Name From Country Table
        $country = Countries::where('id', $request->country)->first()->name;

        // return the as a JSON

        return response()->json(['country' => $country, 'countryData' => $countryData]);
    }


    public function getBubbleChartData(Request $request)
    {
        $data = Covid::where('country_id', $request->country)
            // use When for filtering by date
            ->when($request->from, function ($query) use ($request) {
                return $query->whereDate('date', '>=', $request->from);
            })
            ->when($request->to, function ($query) use ($request) {
                return $query->whereDate('date', '<=', $request->to);
            })
            ->orderBy('date')
            ->limit(50)
            ->get();

        // start Getting the Bubble Size
        $totalCases = $data->pluck('Active');
        $totalCasesArray = $totalCases->toArray();
        $maxTotalCases = max($totalCasesArray);
        $bubleSizes = $totalCases->map(function ($cases) use ($maxTotalCases) {
            return ($cases / $maxTotalCases) * 25;
        });

        // return the data as json
        return response()->json([
            'cases' => $data->pluck('Confirmed'),
            'deaths' => $data->pluck('Deaths'),
            'recoveries' => $data->pluck('Recovered'),
            'bubbleSizes' => $bubleSizes->values(),
        ]);
    }
}