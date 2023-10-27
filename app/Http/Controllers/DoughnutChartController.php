<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DoughnutChartController extends Controller
{
    public function index()
    {
        $data = DB::table('covids')->select(
            DB::raw('SUM(confirmed) as total_confirmed'),
            DB::raw('SUM(deaths) as total_deaths'),
            DB::raw('SUM(recovered) as total_recovered'),
            DB::raw('SUM(active) as total_active')
        )->first();

        // Calcula as porcentagens
        $total = $data->total_confirmed + $data->total_deaths + $data->total_recovered + $data->total_active;

        $percentages = [
            'confirmed' => ($data->total_confirmed / $total) * 100,
            'deaths' => ($data->total_deaths / $total) * 100,
            'recovered' => ($data->total_recovered / $total) * 100,
            'active' => ($data->total_active / $total) * 100,
        ];

        return view('charts.doughnutchart', ['percentages' => $percentages]);
    }
}
