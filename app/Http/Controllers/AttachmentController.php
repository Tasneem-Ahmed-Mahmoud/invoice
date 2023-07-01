<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use File;
use App\Http\Requests\AttachmentRequest;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(AttachmentRequest $request)
    {
        
        if($request->hasFile('file')){
             // move pic
             $fileName = $request->pic->getClientOriginalName();
             $request->pic->move(public_path('uploads/attachments/' . $request->invoice_number), $fileName);
            
                  }
        $attachment=Attachment::create([
            'invoice_number' =>$request->invoice_number, 
            'invoice_id'=>$request->invoice_id, 
            'file'=>$fileName,
            'created_by'=>Auth::user()->name
        ]);

        if($attachment){
            
session()->flash('success', 'تم اضافة المرفق بنجاح'); 

        }else{
            session()->flash('error', "حدث خطا"); 

        }
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Attachment $attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attachment $attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attachment $attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // dd($request->id_file);
    $attachment=Attachment::findOrFail($request->id_file)->delete();
    // dd($attachment);
    if($attachment){
        session()->flash('success', 'تم حذف المرفق بنجاح');
        $path=public_path('uploads/attachments/'.$request->invoice_number.'/'.$request->file_name);
        if( file_exists($path) ) {
            unlink($path);
                    }
    }else{
        session()->flash('error',"فشل الحذف");
    }
       
        back();
    }

function showFile($file,$invoice_number){
    $path=public_path('uploads/attachments/'.$invoice_number.'/'.$file);
    if( file_exists($path) ) {
        return response()->file($path);
                }else{
                    back();
                }

}



function downloadFile($file,$invoice_number){
    $path=public_path('uploads/attachments/'.$invoice_number.'/'.$file);
    if( file_exists($path) ) {
        return response()->download($path);
                }else{
                    back();
                }
   }
  
   




   
}
