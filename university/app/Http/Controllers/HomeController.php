<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
//
class HomeController extends Controller
{
    public function index() {
        //$json = json_decode(file_get_contents("http://universities.hipolabs.com/search?country=canada"));
        //dd($json);
        //return response()->json($json); 
        $universityApiData = $this->getApiData();

        $universityData = $this->paginate($universityApiData);

        return view('university.index', compact('universityData'));
        /*return view('university.index', [
            'universityData' => $universityData
        ]);*/
    }

    public function getApiData() {
        $jsonCA = json_decode(file_get_contents("http://universities.hipolabs.com/search?country=canada"));
        $jsonUS = json_decode(file_get_contents("http://universities.hipolabs.com/search?country=united%20states"));
        $json = [...$jsonCA, ...$jsonUS];
        //dd($json);
        return $json; 
    }

    public function paginate($items, $perPage = 30, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
