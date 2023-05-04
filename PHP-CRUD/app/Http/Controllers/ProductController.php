<?php

namespace App\Http\Controllers;
use App\Helpers;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products= Product::get();
        return view('products.index',['products'=>$products]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'image'=>'required|mimes:jpeg,jpg,png,gif|max:10000'
        ]);
        ///upload image
        $imagename=time().'.'.$request->image->extension();
        $request->image->move(public_path('products'),$imagename);

        $product = new Product;
        $product->image =$imagename;
        $product->name = $request->name;
        $product->description = $request->description;

        $product->save();

        return back()->withSuccess('Product created !!!!!!!!');

    }

    public function edit($id)
    {
        $product =Product::where('id',$id)->first();
        return view('products.edit',['product'=>$product]);
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'image'=>'nullable|mimes:jpeg,jpg,png,gif|max:10000'
        ]);

        $product =Product::where('id',$id)->first();
        ///upload image
        if(isset($product->image))
        {
            $imagename=time().'.'.$request->image->extension();
            $request->image->move(public_path('products'),$imagename);
            $product->image =$imagename;
        }
        
        $product->name = $request->name;
        $product->description = $request->description;

        $product->save();

        return back()->withSuccess('Product Updated !!!!!!!!');
    }
}