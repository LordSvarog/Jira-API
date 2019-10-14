<?php

namespace App\Http\Controllers;

use App\Developer;
use App\JiraApi;
use App\Position;
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
    /**
     * Show developers list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function index()
    {
        $listJira = Developer::getAll();
        $listDevs = [];
        foreach ($listJira as $key => $item) {
            if ($item->accountType !== 'atlassian')
                continue;
            $ava = $item->avatarUrls->{"32x32"};
            $name = str_replace('.', '', $item->name);
            $dev = Developer::where('code', $name)->first();
            if ($dev) {
                $pos = $dev->position['attributes'];
                $dev = $dev['attributes'];
                $dev += [
                    'title' => $pos['title'],
                    'rate' => $pos['rate'],
                    'hours' => $pos['hours'],
                    'avatar' => $ava,
                ];
                $listDevs[] = $dev;
            } else {
                $JiraDev = [
                    'code' => $name,
                    'name' => $item->displayName,
                    'avatar' => $ava,
                ];
                $listDevs[] = $JiraDev;
            }
        }

        $posList = Position::all();

        return view('developers/developers',[
            'developers' => $listDevs,
            'posList' => $posList,
        ]);
    }

    public static function issue($user)
    {
        dd(Developer::getIssue($user));
    }
}
