<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use Illuminate\Support\Facades\Http;

class ExtractDataHtmlController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $client = new Client();
        $crawler = $client->request('GET', 'https://es.snow-forecast.com/resorts/PortDelComte/6day/mid');
        $crawlerDies = $crawler->filter('.forecast-table-days');
        $crawlerDies->each(function ($node) {
            if($node->text() != 'C°'){
                echo $node->text();
            }
        });
        $crawlerDies = $crawler->filter('.forecast-table-time');
        $crawlerDies->each(function ($node) {
            if($node->text() != 'C°'){
                echo $node->text();
            }
        });
        $crawlerDies = $crawler->filter('.forecast-table-weather');
        $crawlerDies->each(function ($node) {
            if($node->text() != 'C°'){
                echo $node->text();
            }
        });
    }
}
