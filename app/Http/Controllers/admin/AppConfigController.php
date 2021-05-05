<?php

namespace App\Http\Controllers\admin;

use App\Helpers\AppConfigHelper;
use App\Helpers\ExtensionHelper;
use App\Models\AppConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
            if (in_array($key, array_keys(AppConfig::$DEFAULT_CONFIGS))) {
                AppConfigHelper::SetConfig($key, $value);
            }
        }

        foreach ($request->files as $key => $file) {
            if (in_array($key, array_keys(AppConfig::$DEFAULT_CONFIGS))) {
                $extension = $file->getClientOriginalExtension();
                if (!in_array($extension, ExtensionHelper::$bannedUploadExtensions)) {
                    // Delete old file
                    File::delete(
                        storage_path(
                            str_replace('/storage', '/app/public', AppConfigHelper::GetConfig($key))
                        )
                    );

                    // Store and get path
                    $filename = $key . "-" . time() . '.' . $extension;
                    $file->move(storage_path('app/public/config_files'), $filename);
                    $path = '/storage/config_files/' . $filename;

                    // Store data in db
                    AppConfigHelper::SetConfig($key, $path);
                }
            }
        }
        return back();
    }

}
