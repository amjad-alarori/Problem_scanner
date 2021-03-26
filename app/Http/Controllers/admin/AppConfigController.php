<?php

namespace App\Http\Controllers\admin;

use App\Helpers\AppConfigHelper;
use App\Models\AppConfig;
use Illuminate\Http\Request;

class AppConfigController
{

    public function index()
    {
        $appconfigs = AppConfig::$DEFAULT_CONFIGS;
        return view('admin.appconfig', compact("appconfigs"));
    }

    public function store(Request $request)
    {
        $data = $request->post('config');
        foreach ($data as $key => $value) {
            if(in_array($key, array_keys(AppConfig::$DEFAULT_CONFIGS))) {
                AppConfigHelper::SetConfig($key, $value);
            }
        }
        return back();
    }

}
