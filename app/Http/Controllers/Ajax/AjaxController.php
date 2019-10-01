<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Project;
use App\Http\Controllers\Ajax\ResponseController;


class AjaxController extends ResponseController
{
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	public function setRate(Request $request)

	{
		$param = $request->all()['PARAMS'];
		$oProject = new Project($param);


		if ($oProject ->save()){
			$arResult["status"] = true;
		}else{
			$arResult["status"] = false;
		}


		return $this->respondWithData($arResult, 200);


	}


}
