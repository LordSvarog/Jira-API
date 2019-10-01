<?php

namespace App\Http\Controllers;
use App\Project;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index()
    {
    	//var_dump(Project::getAllInfo());die();
        return view('home',[
			'data' => Project::instance()->getAllInfo(),
		]);
    }


    public static function showProject()
	{
		$oProject = new Project();

		return view('project');

	}
}
