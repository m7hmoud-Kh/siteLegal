<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SettingController extends Controller
{
    //
    public function index()
    {
        $local = App::getLocale();
        $allSetting = Setting::with('media')->where('language',$local)->get();
        return response()->json([
            'allSetting' => SettingResource::collection($allSetting),
        ]);
    }
}
