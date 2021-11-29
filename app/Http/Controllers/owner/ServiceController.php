<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Service;
use App\Category;
use App\Salon;
use App\AdminSetting;

class ServiceController extends Controller
{
    public function index()
    {
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();

        $services = Service::where([['salon_id', $salon->salon_id],['isdelete',0]])
        ->with(['category'])
        ->orderBy('service_id', 'DESC')
        ->paginate(5);

        $categories = Category::where([['status',1],['name','!=','Default Category']])->get();
        $symbol = AdminSetting::find(1)->currency_symbol;
        return view('owner.pages.service', compact('services','categories','symbol'));
    }

    public function create()
    {
        $categories = Category::where('status',1)->get();
        return view('owner.service.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cat_id' => 'bail|required',
            'image' => 'bail|required',
            'name' => 'bail|required',
            'time' => 'bail|required|numeric',
            'gender' => 'bail|required',
            'price' => 'bail|required|numeric',
        ]);

        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $service = new Service();
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $name = 'Service_'.time().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images/services');
            $image->move($destinationPath, $name);
            $service->image = $name;
        }
        
        $service->name = $request->name;
        $service->gender = $request->gender;
        $service->price = $request->price;
        $service->time = $request->time;
        $service->cat_id = $request->cat_id;
        $service->salon_id = $salon->salon_id;
        $service->save();
        return response()->json(['success' => true,'data' => $service, 'msg' => 'Service create'], 200);

    }

    public function show($id)
    {
        $data['service'] = Service::with('category')->find($id);
        $data['symbol'] = AdminSetting::find(1)->currency_symbol;
        return response()->json(['success' => true,'data' => $data, 'msg' => 'Service show'], 200);
    }

    public function edit($id)
    {
        $data['service'] = Service::find($id);
        $data['categories'] = Category::where([['status',1],['name','!=','Default Category']])->get();
        return response()->json(['success' => true,'data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        
        $request->validate([
            'cat_id' => 'bail|required',
            'name' => 'bail|required',
            'time' => 'bail|required|numeric',
            'gender' => 'bail|required',
            'price' => 'bail|required|numeric',
        ]);
        $service = Service::find($id);
        if($request->hasFile('image'))
        {
            if($service->image != "noimage.png")
            {
                if(\File::exists(public_path('/storage/images/services/'. $service->image))){
                    \File::delete(public_path('/storage/images/services/'. $service->image));
                }
            }
        
            $image = $request->file('image');
            $name = 'Service_'.time().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images/services');
            $image->move($destinationPath, $name);
            $service->image = $name;
        }
        $service->name = $request->name;
        $service->price = $request->price;
        $service->time = $request->time;
        $service->gender = $request->gender;
        $service->cat_id = $request->cat_id;
       
        $service->save();
        return response()->json(['success' => true,'data' => $service, 'msg' => 'Service edit'], 200);
    }
    
    public function destroy($id)
    {
        $service = Service::find($id);
        $service->isdelete = 1;
        $service->status = 0;
        $service->save();
        return redirect('/owner/services');

    }
    public function hideService(Request $request)
    {
        $service = Service::find($request->serviceId);
        if ($service->status == 0) 
        {   
            $service->status = 1;
            $service->save();
        }
        else if($service->status == 1)
        {
            $service->status = 0;
            $service->save();
        }
    }
}
