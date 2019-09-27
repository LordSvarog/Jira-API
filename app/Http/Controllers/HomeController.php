<?php

namespace App\Http\Controllers;
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


		try {
			$proj = new ProjectService(new ArrayConfiguration(
				array(
					'jiraHost' => 'https://webberry.atlassian.net',
					// for basic authorization:
					'jiraUser' => 'dl@webberry.ru',
					'jiraPassword' => 'LT3Rn5voDqd6C10SPvmXA7B9',

				)
			));
			print_r($proj->get('AX'));
			$pt = $proj->getAllProjects();


			foreach ($pt as $p){

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

					$users = $us->findAssignableUsers($paramArray);
					foreach ($users as $user){
						print_r("</br>".$p->name."-".$user->displayName."</br>");
					}

				} catch (JiraException $e) {
					print("Error Occured! " . $e->getMessage());
				}

			}
		} catch (JiraException $e) {
			print("Error Occured! " . $e->getMessage());
		}













//		try {
//			$us = new UserService();
//
//			$paramArray = [
//				//'username' => null,
//				'project' => 'AX',
//				//'issueKey' => 'TEST-1',
//				'startAt' => 0,
//				'maxResults' => 50, //max 1000
//				//'actionDescriptorId' => 1,
//			];
//
//			$users = $us->findAssignableUsers($paramArray);
//			foreach ($users as $user){
//				print_r($user->displayName);
//			}
//
//		} catch (JiraException $e) {
//			print("Error Occured! " . $e->getMessage());
//		}








//		try {
//			$us = new UserService();
//
//			$paramArray = [
//				'username' => '', // get all users.
//				'startAt' => 0,
//				'maxResults' => 1000,
//				'includeInactive' => true,
////
//			];
//
//			// get the user info.
//			$users = $us->findUsers($paramArray);
//			print_r($users);
//		} catch (JiraException $e) {
//			print("Error Occured! " . $e->getMessage());
//		}
//
//
//
//		foreach ($users as $user){
//
//			try {
//				$us = new UserService();
//
//				$user = $us->get(['username' => $user->name]);
//
//				var_dump($user);
//			} catch (JiraException $e) {
//				print("Error Occured! " . $e->getMessage());
//			}
//
//		}


//		foreach ($pt as $p) {
//			try {
//				$queryParam = [
//					'groupname' => 'WEB',
//					'includeInactiveUsers' => true, // default false
//					'startAt' => 0,
//					'maxResults' => 50,
//				];
//
//
//				$proj = new GroupService(new ArrayConfiguration(
//					array(
//						'jiraHost' => 'https://webberry.atlassian.net',
//						// for basic authorization:
//						'jiraUser' => 'dl@webberry.ru',
//						'jiraPassword' => 'LT3Rn5voDqd6C10SPvmXA7B9',
//
//					)
//				));
//				$ret = $proj->getMembers($queryParam);
//
//				print_r($ret);
//			} catch (JiraException $e) {
//				print("Error Occured! " . $e->getMessage());
//			}
//		}
//		$iss = new IssueService(new ArrayConfiguration(
//			array(
//				'jiraHost' => 'https://webberry.atlassian.net',
//				// for basic authorization:
//				'jiraUser' => 'dl@webberry.ru',
//				'jiraPassword' => 'LT3Rn5voDqd6C10SPvmXA7B9',
//				// to enable session cookie authorization (with basic authorization only)
//				'cookieAuthEnabled' => true,
//				'cookieFile' => storage_path('jira-cookie.txt'),
//				// if you are behind a proxy, add proxy settings
//				"proxyServer" => 'your-proxy-server',
//				"proxyPort" => 'proxy-port',
//				"proxyUser" => 'proxy-username',
//				"proxyPassword" => 'proxy-password',
//			)
//		));
//
//		$log = new Auth\AuthService();
//		//$log ->login('ik@webberry.ru','LT3Rn5voDqd6C10SPvmXA7B9');
//
//		 $arr = array();
//		array_push($arr,'dl@webberry.ru');
//
//
//
//		try {
//			$proj = new ProjectService();
//
//			$prjs = $proj->getAllProjects();
//
//			foreach ($prjs as $p) {
//				echo sprintf("Project Key:%s, Id:%s, Name:%s, projectCategory: %s\n",
//					$p->key, $p->id, $p->name, $p->projectCategory['name']
//				);
//			}
//		} catch (JiraException $e) {
//			print("Error Occured! " . $e->getMessage());
//		}
//
//
//
//		echo "<pre>";
//			var_dump($log);
//		echo "</pre>";
//
        return view('home');
    }

}
