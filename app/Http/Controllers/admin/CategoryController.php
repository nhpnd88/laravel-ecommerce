<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class CategoryController extends Controller
{
    public Function index(Request $request){

        $categories = Category::latest(); 

            if (!empty($request->get('keyword'))) {
                
                $categories = $categories->where('name', 'like', '%' . $request->get('keyword') . '%');
            }
            $categories = $categories->paginate(10);

        return view('admin.category.list',compact('categories'));
    }

    public Function create(){
       return view('admin.category.create');
    }

    public Function store(Request $request){

        $validator= Validator::make($request->all(),[
            'name'=> 'required',
            'slug' => 'required|unique:categories',
        ]);
        if($validator->passes()) {

            $category= new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->save();

            $request->session()->flash('success','Category added Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Category added Successfully.'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public Function edit(){
        
    }

    public Function update(){
        
    }

    public Function delete(){
        
    }
}
