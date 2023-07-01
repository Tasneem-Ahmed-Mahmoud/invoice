<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products=Product::with('section:sections.name,id')->get(['name','id','description','section_id']);
        $sections=Section::get();
        return  view("products.index",compact("products","sections"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        //  dd($request->all());
               
         $product=product::create([
            'name'=>$request->name,
            'description'=> $request->description,
            'section_id'=> $request->section_id
        ]);
    if($product){
        session()->flash('success',"تم اضافة المنتج  ينجاح");
    }else{
        session()->flash('error',"فشل الحفظ");
    }

       
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $prodact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $prodact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
            //    dd($request->all());
        $product=product::find($request->id)->Update([
            'name'=>$request->name,
            'description'=> $request->description,
            'section_id'=> $request->section_id
        ]);


        if($product){
            session()->flash('success',"تم تعديل المنتج بنجاح");
        }else{
            session()->flash('error',"فشل التعديل  ");
        }
            return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $product=Product::find($request->id)->delete();
      
        if($product){
            session()->flash('success',"تم الحذف بنجاح");
        }else{
            session()->flash('error',"فشل الحذف ");
        }
            return redirect()->route('products.index');
    }
}
