<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Obté les categories
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCategories()
    {
        $projectes = Categoria::get();

        return $projectes;
    }
}
