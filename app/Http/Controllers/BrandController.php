<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\MultiPic;
use Illuminate\Support\Carbon;
use Image;
use Auth;

class BrandController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }


    public function AllBrand(){
        $brands = Brand::latest()->paginate(5);
        return view('admin.brand.index', compact('brands'));
    }

    public function AddBrand(Request $request)
    {
         $validatedData = $request->validate([
         'brand_name' => 'required|unique:brands|min:4',
         'brand_image' => 'required|mimes:jpg,jped,png',

         ],

         [
         
            'brand_name.required' => 'Please input Brand Name',
            'brand_name.min' => 'Brand Longer than 4 Characters',
            'brand_image.required' => 'Please select an image'
    
        ]);

        $brand_image = $request->file('brand_image');
        // $name_gen = hexdec(uniqid());
        // $img_ext = strtolower($brand_image->getClientOriginalExtension());
        // $img_name = $name_gen.'.'.$img_ext;
        // $up_location = 'images/brand/';
        // $last_img = $up_location.$img_name;
        // $brand_image->move($up_location,$img_name);

        $name_gen = hexdec(uniqid()).'.'.$brand_image->getClientOriginalExtension();
        Image::make($brand_image)->resize(300,200)->save('images/brand/'.$name_gen);
        $last_img = 'images/brand/'.$name_gen;


        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_img,
            'created_at' => Carbon::now()

        ]);

        return Redirect()->back()->with('success','Brand added successfully');




    }

    public function brandEdit($id){
        $brands = Brand::find($id);
        return view('admin.brand.edit',compact('brands'));
    }

    public function brandUpdate(Request $request, $id){
        $validatedData = $request->validate([
            'brand_name' => 'required|min:4',
            ],
   
            [
               'brand_name.required' => 'Please input Brand Name',
               'brand_name.min' => 'Brand Longer than 4 Characters',
           ]);

           $old_image = $request->old_image;
           $brand_image = $request->file('brand_image');

           if($brand_image){
            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($brand_image->getClientOriginalExtension());
            $img_name = $name_gen.'.'.$img_ext;
            $up_location = 'images/brand/';
            $last_img = $up_location.$img_name;
            $brand_image->move($up_location,$img_name);
    
    
    
            unlink($old_image);
            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'brand_image' => $last_img,
                'created_at' => Carbon::now()
    
            ]);
    
            return Redirect()->back()->with('success','Brand updated successfully');
           }else{
                
                Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'created_at' => Carbon::now()
    
            ]);
            return Redirect()->back()->with('success','Brand updated successfully');
           }

    }

    public function BrandDelet($id){
        $image = Brand::find($id);
        $old_image = $image->brand_image;
        unlink($old_image);

        Brand::find($id)->delete();
        return redirect()->back()->with('success','Brand deleted successfully');


// Multi Pictures Methods....

    }
    public function MultiPictures(){
        $images = MultiPic::all();
        return view('admin.multipic.index', compact('images'));

    }

    public function StoreImage(Request $request){
   
           $image = $request->file('image');

           foreach($image as $multi_img){

           
   
           $name_gen = hexdec(uniqid()).'.'.$multi_img->getClientOriginalExtension();
           Image::make($multi_img)->resize(300,300)->save('images/multi/'.$name_gen);
           $last_img = 'images/multi/'.$name_gen;
   
   
           MultiPic::insert([
               'image' => $last_img,
               'created_at' => Carbon::now()
   
           ]);
   
            } // End of foreach
           return Redirect()->back()->with('success','Brand added successfully');
    }

    public function Logout(){
        Auth::logout();
        return redirect()->route('login')->with('success','User Logout');
    }


}
