<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Universities;
use App\Models\Domain;
use App\Models\WebPage;

class HomeController extends Controller
{
    public function index() {
        //$json = json_decode(file_get_contents("http://universities.hipolabs.com/search?country=canada"));
        //dd($json);
        //return response()->json($json); 
        //$universityApiData = $this->getApiData();

        //$universityData = $this->paginate($this->getApiData());

        //$this->addApiData($this->getApiData());

        $universityData = $this->paginate($this->getDbData());



        return view('university.index', compact('universityData'));
        /*return view('university.index', [
            'universityData' => $universityData
        ]);*/
    }

    public function getApiData() {
        $jsonCA = json_decode(file_get_contents("http://universities.hipolabs.com/search?country=canada"));
        $jsonUS = json_decode(file_get_contents("http://universities.hipolabs.com/search?country=united%20states"));
        $json = [...$jsonCA, ...$jsonUS];
        return $json; 
    }

    public function getDbData() {
        /*$uvivDbData = Universities::join('domains', 'universities.id', '=', 'domains.universities_id')
                        ->join('web_pages', 'universities.id', '=', 'web_pages.universities_id')
                        ->select('universities.name', 'universities.country', 'universities.state-province', 'universities.alpha_two_code', 'domains.domain_name', 'web_pages.url')
                        ->get()->toArray();*/
        //$uvivDbData = Universities::with('Domain')->with('WebPage')->get()->toArray();
        //$uvivDbData = $this->getApiData();

        $uvivDbData = response(
            array_values(Universities::with('Domain')->with('WebPage')->get()->toArray())
        )->getContent();
        //dd(json_decode($uvivDbData)[0]);
        //dd($uvivDbData);
        return json_decode($uvivDbData);
    }

    public function addApiData(array $data) {
        //$universities = $this->getApiData();

        foreach ($data as $line) {
            $univ = Universities::create([
                'name' => $line->name,
                'country' => $line->country,
                'state-province' => $line->{'state-province'},
                'alpha_two_code' => $line->alpha_two_code
            ]);

            foreach ($line->domains as $domain) {
                //dd($domain);
                Domain::create([
                    'universities_id' => $univ -> id,
                    'domain_name' => $domain
                ]);
            };

            foreach ($line->web_pages as $web_page) {
                WebPage::create([
                    'universities_id' => $univ -> id,
                    'url' => $web_page
                ]);
            };
        }
    }

    public function paginate($items, $perPage = 30, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
