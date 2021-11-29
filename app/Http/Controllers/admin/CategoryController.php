<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('cat_id','DESC')->get();
        return view('admin.pages.category', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'bail|required',
            'name' => 'bail|required|unique:category'
        ]);

        $category = new Category();
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $name = 'category_'.time().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images/categories');
            $image->move($destinationPath, $name);
            $category->image = $name;
        }
        if($request->hasFile('banner'))
        {
            $image = $request->file('banner');
            $name = 'categoryBanner_'.time().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images/categories');
            $image->move($destinationPath, $name);
            $category->banner = $name;
        }
        $category->name = $request->name;
        $category->save();
        return response()->json(['success' => true,'data' => $category, 'msg' => 'category create'], 200);
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return response()->json(['success' => true,'data' => $category], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'bail|required|unique:category,name,' . $id . ',cat_id',
        ]);

        $category = Category::find($id);
        if($request->hasFile('image'))
        {
            if($category->image != "noimage.jpg")
            {
                if(\File::exists(public_path('/storage/images/categories/'. $category->image))){
                    \File::delete(public_path('/storage/images/categories/'. $category->image));
                }
            }

            $image = $request->file('image');
            $name = 'category_'.time().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images/categories');
            $image->move($destinationPath, $name);
            $category->image = $name;
        }
        
        if($request->hasFile('banner'))
        {
            if(\File::exists(public_path('/storage/images/categories/'. $category->banner))){
                \File::delete(public_path('/storage/images/categories/'. $category->banner));
            }

            $image = $request->file('banner');
            $name = 'categoryBanner_'.time().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images/categories');
            $image->move($destinationPath, $name);
            $category->banner = $name;
        }
        $category->name = $request->name;
        $category->save();
        return response()->json(['success' => true,'data' => $category, 'msg' => 'category edit'], 200);
    }

    public function hideCategory(Request $request)
    {
        $category = Category::find($request->categoryId);
        if ($category->status == 0) 
        {   
            $category->status = 1;
            $category->save();
        }
        else if($category->status == 1)
        {
            $category->status = 0;
            $category->save();
        }
    }
    
}
