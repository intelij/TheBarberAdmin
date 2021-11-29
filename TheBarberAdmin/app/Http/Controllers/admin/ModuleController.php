<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Module;
use App\AdminSetting;
use App\User;
use App;
use Zip;
use Str;
use Artisan;
use DB;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::orderBy('id', 'DESC')->paginate(10);
        return view('admin.pages.module', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'zip' => 'bail|required',
            'module' => 'bail|required|unique:module',
        ]);
        $is_valid = Zip::check($request->zip);
        if($is_valid)
        {
            $zip = $request->file('zip');
            $name = 'Zip_'.$request->module.'.'. $zip->getClientOriginalExtension();
            $destinationPath = public_path('/modules');
            $zip->move($destinationPath, $name);
            
            $zip = Zip::open($destinationPath .'/'. $name);
            $fileList = $zip->listFiles();
            if ($request->module == "loyalty_module") {

                // Move Config
                $zip->extract(base_path('config/'), 'point.php');

                // Move Migration
                $zip->extract(base_path('database/migrations/'), '2021_03_31_111733_add_point_to_coupon.php');
                $zip->extract(base_path('database/migrations/'), '2021_03_30_160304_add_is_point_to_adminsetting.php');
                $zip->extract(base_path('database/migrations/'), '2021_03_30_172745_add_referral_code_to_users.php');
                $zip->extract(base_path('database/migrations/'), '2021_04_10_161850_add_points_to_booking_table.php');

                Artisan::call('migrate');

                // Move view
                $zip->extract(base_path('resources/views/admin/module/'), 'loyaltyModuleSetting.blade.php');

                $users = User::where('role',3)->get();
                foreach($users as $user){
                    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $code = substr(str_shuffle($permitted_chars), 0, 6);
                    $user->referral_code = $code;
                    $user->save();
                }
            }

            $module = new Module();
            $module->module = $request->module;
            $module->save();
            return response()->json(['success' => true, 'msg' => 'Module create'], 200);
        }
    }

    public function loyaltyModuleEdit($id)
    {
        $data['module'] = Module::find($id);
        $data['settings'] = AdminSetting::first(['is_point','min_amount','point','referral_point']);
        return response()->json(['success' => true,'data' => $data], 200);
    }

    public function loyaltyModuleUpdate(Request $request,$id){
        $request->validate([
            'min_amount' => 'required_if:is_point,1|gt:0',
            'point' => 'required_if:is_point,1|gt:0',
            'referral_point' => 'required_if:is_point,1|gt:0',
        ]);

        $setting = AdminSetting::find(1);

        if(isset($request->is_point)){ $setting->is_point = 1; }
        else{ $setting->is_point = 0; }
        
        if($request->is_point == 1){
            $setting->min_amount = $request->min_amount;
            $setting->point = $request->point;
            $setting->referral_point = $request->referral_point;
        }
        $setting->save();
        return response()->json(['success' => true,'data' => $setting, 'msg' => 'loyality module edit'], 200);
    }

    public function fileExits($fileName, $regx)
    {
        $contains = Str::startsWith($fileName, $regx);
        $after = Str::after($fileName, $regx);
        if ($contains && $after) {
            return $fileName;
        }
        return false;
    }
}
