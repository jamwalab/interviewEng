<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Universities;
use App\Models\Domains;
use App\Models\WebPage;

class HomeController extends Controller
{
    public function index() {
        $universityData = $this->paginate($this->getDbData());

        if (count($universityData) === 0) {
            $this->addApiData($this->getApiData());
            $universityData = $this->paginate($this->getDbData());
        }

        return view('university.index', compact('universityData'));
    }

    public function getApiData() {
        $jsonCA = json_decode(file_get_contents("http://universities.hipolabs.com/search?country=canada"));
        $jsonUS = json_decode(file_get_contents("http://universities.hipolabs.com/search?country=united%20states"));
        $json = [...$jsonCA, ...$jsonUS];
        return $json; 
    }

    public function getDbData() {
        $uvivDbData = response(
            array_values(Universities::with('Domains')->with('WebPage')->get()->toArray())
        )->getContent();
        return json_decode($uvivDbData);
    }

    public function addApiData(array $data) {
        foreach ($data as $line) {
            $univ = Universities::create([
                'name' => $line->name,
                'country' => $line->country,
                'state-province' => $line->{'state-province'},
                'alpha_two_code' => $line->alpha_two_code
            ]);

            foreach ($line->domains as $domain) {
                Domains::create([
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
