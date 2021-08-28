<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.plugin-dashboard');
    }

    private function getByDateRange($jsonData = [], $dateRange = '-', $format = false)
    {
        $dataStore = [];
        $dateRange = explode('-', $dateRange);
        $from = strtotime(trim($dateRange[0]));
        $end = strtotime(trim($dateRange[1]));
        foreach ($jsonData as $dateKey => $val) {
            $time = strtotime($dateKey);

            if ($time > $from && $time <= $end) {
                $dateKey = $format ? date_format(date_create($dateKey), $format) : $dateKey;
                $dataStore[$dateKey] = floatval(trim($val));
            }
        }
        return $dataStore;
    }

    public function pluginInfo(Request $request)
    {
        $slug = $request->slug;
        $activation = Http::get("https://api.wordpress.org/stats/plugin/1.0/active-installs.php?slug={$slug}&limit=267")->json();
        $downloads = Http::get("https://api.wordpress.org/stats/plugin/1.0/downloads.php?slug={$slug}&limit=267")->json();

        $activation = $this->getByDateRange($activation, $request->dateRange, 'd-M');
        $downloads = $this->getByDateRange($downloads, $request->dateRange);
        $totalDownload = number_format(array_sum($downloads));

        $totalActivate = 0;
        $totalDeactivate = 0;
        foreach ($activation as $key => $active) {
            if ($active > 0) {
                $totalActivate += $active;
            } else {
                $totalDeactivate += abs($active);
            }
        }
        $totalActivate = number_format($totalActivate, 1);
        $totalDeactivate = number_format($totalDeactivate, 1);
        return response()->json(compact('activation', 'totalDownload', 'totalActivate', 'totalDeactivate'));
    }
}
