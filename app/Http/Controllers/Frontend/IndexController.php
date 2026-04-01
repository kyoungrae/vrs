<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Нүүр хуудас
     * @param Request $request - дамжуулна
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('System.index');
    }
}
