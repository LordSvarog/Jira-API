<?php
namespace App\Http\Controllers;
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 27.09.2019
 * Time: 9:50
 */
use JiraRestApi\Configuration\ArrayConfiguration;


class Api{
	private $jiraHost = 'https://webberry.atlassian.net';
	private $jiraUser = 'dl@webberry.ru';
	private $jiraPassword = 'LT3Rn5voDqd6C10SPvmXA7B9';

	private static function Instance(){
		return new self();
	}

	public static function Configs(){
		$oApi = self::Instance();
		return new ArrayConfiguration(
			 array(
				'jiraHost' => $oApi->jiraHost,
				'jiraUser' => $oApi->jiraUser,
				'jiraPassword' => $oApi->jiraPassword,

			)
		);
	}
}
