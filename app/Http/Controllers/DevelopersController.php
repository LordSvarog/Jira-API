<?php

namespace App\Http\Controllers;

use App\Developers;
use App\JiraApi;
use App\User;
use Illuminate\Http\Request;

class DevelopersController extends Controller
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


    public static function index()
    {
        return view('developers/developers',[
            'developers' => Developers::getAll(),
        ]);
    }

    public static function issue($user) {
        dd(Developers::getIssue($user));
    }
}
