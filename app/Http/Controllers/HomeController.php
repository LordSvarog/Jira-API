<?php

namespace App\Http\Controllers;
require ("C:/xampp7/htdocs/jiraapi/vendor/autoload.php");
use Illuminate\Http\Request;
use JiraRestApi\Group\GroupService;
use JiraRestApi\Project\ProjectService;
use JiraRestApi\JiraException;
use JiraRestApi\Configuration\ArrayConfiguration;
use JiraRestApi\Issue\IssueService;
use JiraRestApi\Auth;
use JiraRestApi\Field\Field;
use JiraRestApi\Field\FieldService;
use JiraRestApi\User\UserService;

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
    	/*
    	 new ArrayConfiguration(
			array(
				'jiraHost' => 'https://webberry.atlassian.net',
				// for basic authorization:
				'jiraUser' => 'dl@webberry.ru',
				'jiraPassword' => 'LT3Rn5voDqd6C10SPvmXA7B9',
				// to enable session cookie authorization (with basic authorization only)
				'cookieAuthEnabled' => true,
				'cookieFile' => storage_path('jira-cookie.txt'),
				// if you are behind a proxy, add proxy settings
			)
		)
    	 */
//		try {
//			$proj = new ProjectService(new ArrayConfiguration(
//				array(
//					'jiraHost' => 'https://webberry.atlassian.net',
//					// for basic authorization:
//					'jiraUser' => 'dl@webberry.ru',
//					'jiraPassword' => 'LT3Rn5voDqd6C10SPvmXA7B9',
//
//				)
//			));
//
//			$pt = $proj->getAllProjects();
//			print_r($pt);
//		} catch (JiraException $e) {
//			print("Error Occured! " . $e->getMessage());
//		}

		$arrProjects =[];
		try {
			$proj = new ProjectService(new ArrayConfiguration(
				array(
					'jiraHost' => 'https://webberry.atlassian.net',
					// for basic authorization:
					'jiraUser' => 'dl@webberry.ru',
					'jiraPassword' => 'LT3Rn5voDqd6C10SPvmXA7B9',

				)
			));

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

//		var_dump($arrProjects);

		$arrProjects['count']=1;
        return view('home',[
			'arrProjects' => $arrProjects,
		]);









    }

}
