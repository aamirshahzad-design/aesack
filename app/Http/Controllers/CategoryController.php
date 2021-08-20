<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class CategoryController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }


    public function AllCat(){

        /* $categories = DB::table('categories')
                ->join('users', 'categories.user_id', 'users.id')
                ->select('categories.*', 'users.name')
                ->latest()->paginate(5);
         */
        $categories = Category::latest()->paginate(5);
        $trashCat = Category::onlyTrashed()->latest()->paginate(3);


        /* $categories = DB::table('categories')->latest()->paginate(5); */
        return view('admin.category.index', compact('categories','trashCat'));
    }


    public function AddCat(Request $request)
    {
         $validatedData = $request->validate([
         'category_name' => 'required|unique:categories|max:255',
          

         ],

         [
         
            'category_name.required' => 'Please input Category Name',
    
        ]);

        Category::insert([

            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now()

        ]);

        // $category = new Category;
        // $category->category_name = $request->category_name;
        // $category->user_id = Auth::user()->id;
        // $category->save();

        // $date = array();
        // $date['category_name']= $request->category_name;
        // $date['user_id'] = Auth::user()->id;
        // $date['created_at'] = Carbon::now();
        // DB::table('categories')->insert($date);

       
     
     return Redirect()->back()->with('success', 'Category added successfully.');




    }


    public function Edit($id){
        // $categories = Category::find($id);
        $categories = DB::table('categories')->where('id',$id)->first();
        return view('admin.category.editCat', compact('categories'));
    }

    public function Update(Request $request ,$id){
        // $update = Category::find($id)->update([
        //     'category_name' => $request->category_name,
        //     'user_id' => Auth::user()->id

        // ]);
        
        $date = array();
        $data['category_name'] = $request->category_name;
        $data['user_id'] = Auth::user()->id;
        DB::table('categories')->where('id',$id)->update($data);
        return Redirect()->route('all.category')->with('success','Category updated successfully.');
    }
    public function SoftDelet($id){
        $delete = Category::find($id)->delete($id);
        return Redirect()->back()->with('success','Category Soft Deleted Successfully');
    }

    public function Restore($id){
        $delete = Category::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success','Category Soft Restored Successfully');
    }

    public function PDelet($id){
        $delete = Category::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('success','Category Permanentaly Deleted');
    }



}
