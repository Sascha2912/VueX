<?php

namespace App\Http\Controllers\Api;


use App\Constants\Api;
use App\Constants\App;
use App\Constants\Database;
use App\Constants\Modes;
use App\Constants\Pflegestufen;
use App\Http\Controllers\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App as LaravelApp;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Auth;

class ConstantController extends Controller
{
    public function getConstants(): JsonResponse
    {
        $user = Auth::user();
        $locale = LaravelApp::getLocale();
//        $locale = $user ? $user->preferred_language : LaravelApp::getLocale();

        $lang = Lang::get('app', [], $locale);

        $api = Api::cases();
        $app = App::cases();
        $database = Database::cases();
        $modes = Modes::cases();
        $pflegestufen = Pflegestufen::cases();

        return response()->json([
            'api' => $api,
            'app' => $app,
            'database' => $database,
            'modes' => $modes,
            'pflegestufen' => $pflegestufen,

            'locale' => $locale,
            'lang' => $lang,

        ]);
    }
}
