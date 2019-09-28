<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use JiraRestApi\Group\GroupService;
use JiraRestApi\Project\ProjectService;
use JiraRestApi\JiraException;
use JiraRestApi\Configuration\ArrayConfiguration;
use JiraRestApi\Field\Field;
use JiraRestApi\Field\FieldService;
use JiraRestApi\User\UserService;
use App\Http\Controllers;
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

		$arrProjects =[];
		$allUsers =[];
		try {
			$proj = new ProjectService(Api::Configs());

			$pt = $proj->getAllProjects();


			foreach ($pt as $p){
				$projectInfo = $proj->get($p->key);
				//print_r($projectInfo->lead["displayName"]);
				try {
					$us = new UserService();

					$paramArray = [
						//'username' => null,
						'project' => $p->key,
						//'issueKey' => 'TEST-1',
						'startAt' => 0,
						'maxResults' => 50, //max 1000
						//'actionDescriptorId' => 1,
					];
					$arrProjects[$p->key]['project'] = [
						'pName'=> $projectInfo->name,
						'lead'=> $projectInfo->lead["displayName"],
						'avatarUrls'=> $projectInfo->avatarUrls["48x48"]
					];
					$users = $us->findAssignableUsers($paramArray);
					foreach ($users as $user){
						$allUsers['allUsers'][$user->key] =[
							'userName'=>$user->displayName
						];
						$arrProjects[$p->key]['users'][$user->key] = [
							'userName'=>$user->displayName,
							'avatarUrls'=> (array)$user->avatarUrls
						] ;


					}

				} catch (JiraException $e) {
					print("Error Occured! " . $e->getMessage());
				}

			}
		} catch (JiraException $e) {
			print("Error Occured! " . $e->getMessage());
		}

        return view('home',[
			'arrProjects' => $arrProjects,
			'allUsers' => $allUsers,
		]);









    }


    public static function showProject()
	{

		return view('project');

	}
}
