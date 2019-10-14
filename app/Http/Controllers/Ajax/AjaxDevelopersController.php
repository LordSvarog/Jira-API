<?php

namespace App\Http\Controllers\Ajax;

use App\Developer;
use Illuminate\Http\Request;
use App\Position;

/**
 * Class AjaxDevelopersController
 * @package App\Http\Controllers\Ajax
 */
class AjaxDevelopersController extends ResponseController
{
    /**
     * Select position
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRate(Request $request)
    {
        $id = $request->get('id');
        $data = Position::find($id);

        return $this->respondWithData($data, 200);
    }

    /**
     * Save new developer or change existing
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveParams(Request $request)
    {
        if ($id = $request->get('dev-id')) {
            $developer = Developer::find($id);
            $this->getParams($developer, $request);
            $developer->save();

            return $this->respondSuccess('Change', 200);
        }

        $developer = new Developer;
        $this->getParams($developer, $request);
        $developer->save();
        $dev_id = $developer->id;

        return $this->respondWithData($dev_id, 200);
    }

    /**
     * @param Developer $developer
     * @param Request $request
     *
     * @return Developer
     */
    protected function getParams (Developer $developer, Request $request)
    {
        $developer->name = $request->get('name');
        $developer->code = $request->get('dev-code');
        $developer->position_id = $request->get('title');

        return $developer;
    }
}
