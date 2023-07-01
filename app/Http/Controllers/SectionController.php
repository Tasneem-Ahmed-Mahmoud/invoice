<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Requests\SectionRequest;
class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sections=Section::get();
        return view("sections.index",compact('sections')); 
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
    public function store(SectionRequest $request)
    {
                // dd($request->all());
               
                    $section=Section::create([
                        'name'=>$request->name,
                        'description'=> $request->description,
                        'created_by'=> Auth::user()->name
                    ]);
                if($section){
                    session()->flash('success',"تم اضافة القسم بنجاح");
                }else{
                    session()->flash('error',"فشل الحفظ");
                }

                   
                    return redirect()->route('sections.index');
             
               
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SectionRequest $request)
    {
        // dd($request->all());
        $section=Section::find($request->id);
        $section->update([
                'name'=>$request->name,
                'description'=>$request->description
        ]);

        if($section){
            session()->flash('success',"تم تعديل القسم بنجاح");
        }else{
            session()->flash('error',"فشل التعديل  ");
        }
            return redirect()->route('sections.index');
    }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        // dd($request->all());
        $section=Section::find($request->id)->delete();
      
        if($section){
            session()->flash('success',"تم الحذف بنجاح");
        }else{
            session()->flash('error',"فشل الحذف ");
        }
            return redirect()->route('sections.index');
    }
}
