<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 01.10.2019
 * Time: 16:11
 */

namespace App\Http\Controllers\Ajax;


use App\Http\Controllers\Controller;

abstract class ResponseController extends Controller
{

	/**
	 * Make standard response with some data
	 *
	 * @param object|array $data Data to be send as JSON
	 * @param int $code optional HTTP response code, default to 200
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function respondWithData($data, $code = 200)
	{
		return response()->json([
			'success' => true,
			'data' => $data
		], $code);
	}


	/**
	 * Make standard successful response ['success' => true, 'message' => $message]
	 *
	 * @param string $message Success message
	 * @param int $code HTTP response code, default to 200
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function respondSuccess($message = 'Done!', $code = 200)
	{
		return response()->json([
			'success' => true,
			'message' => $message
		], $code);
	}

	/**
	 * Make standard response with error ['success' => false, 'message' => $message]
	 *
	 * @param string $message Error message
	 * @param int $code HTTP response code, default to 500
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function respondWithError($message = 'Server error', $code = 500)
	{
		return response()->json([
			'success' => false,
			'message' => $message
		], $code);
	}
}

