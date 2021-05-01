<?php

namespace App\Http\Controllers\API;

use App\Setting;
use App\Transformers\SettingTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Queue\RedisQueue;


class AdminSettingsController extends Controller
{
    public function index(Request $request)
    {
        $settings = Setting::all();
        return fractal()->collection($settings)
            ->transformWith(new SettingTransformer());
    }

    public function show(Request $request , $key)
    {
        return fractal()->item(Setting::where('key', $key)->first())
            ->transformWith(new SettingTransformer());
    }

    public function update(Request $request, $key)
    {
        $setting = Setting::where('key',$key)->first();
        $setting->update($request->input());
        return fractal()->item($setting)
            ->transformWith(new SettingTransformer());
    }

}
