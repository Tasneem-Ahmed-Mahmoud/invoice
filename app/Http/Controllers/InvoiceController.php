<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use App\Models\Attachment;
use App\Models\InvoiceDetail;
use App\Models\Section;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
 use App\Traits\FileTrait;
 use Illuminate\Support\Facades\Notification;
 use  App\Notifications\InvoiceAdd;
class InvoiceController extends Controller
{
    use FileTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices=Invoice::get();
        return view("invoices.index",compact('invoices')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $sections =Section::get(['name','id']);
        // dd($sections);
        return view("invoices.create",compact('sections')); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
      if($request->hasFile('pic')){

$image = $request->hasFile('pic')?$request->file('pic'):null;
$file_name = $image->getClientOriginalName();
 // move pic
 $imageName = $request->pic->getClientOriginalName();
 $request->pic->move(public_path('uploads/attachments/' . $request->number), $imageName);

      }
            
       
        
        $invoice=Invoice::create([
           'number'=>$request->number,
            'invoice_date'=>$request->invoice_date,
            'due_date'=>$request->due_date,
            'product_id'=>$request->product_id,
            'section_id'=>$request->section_id,
            'amount_collection'=>$request->amount_collection,
            'amount_commission'=>$request->amount_commission,
            'discount'=>$request->discount,
            'value_VAT'=>$request->value_VAT,
            'rate_VAT'=>$request->rate_VAT,
            'total'=>$request->total,
            'status'=> 'غير مدفوعه',
            'value_status'=> 2 ,
            'note'=>$request->note,
            'user'=>Auth::user()->name,
            'payment_date'=>$request->payment_date
        ]);

        $invoice=Invoice::latest()->first();
        // dd($invoice->id);
        $invoice_id=$invoice->id;
        $invoice_number=$invoice->number;
        $product_id=$invoice->product_id;
$section_id=$invoice->section_id;
$note=$invoice->note;
$payment_date=$invoice->payment_date;
        $invoice_details= InvoiceDetail::create([
        'invoice_number' =>$invoice_number, 
        'invoice_id'=>$invoice_id,
        'status'=> 'غير مدفوعه',
        'value_status'=> 2 ,
        'product_id'=>$product_id,
        'section_id'=>$section_id,
        'payment_date'=>$payment_date,
        'note'=>$note,
        'user'=>Auth::user()->name
    ]);

 if ($image) {
           
            $attachment=Attachment::create([
                'invoice_number' =>$invoice_number, 
                'invoice_id'=>$invoice_id, 
                'file'=>$file_name,
                'created_by'=>Auth::user()->name
            ]);
        
           
    }

// $user=Auth::user();

//     Notification::send($user, new InvoiceAdd($invoice_id));
session()->flash('success', 'تم اضافة الفاتورة بنجاح'); 
    return back();

}

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
        $invoice->load(['attachments','invoiceDetails','section','product']);
        //  dd($invoice);
        return view("invoices.show",compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $invoice->load(['section','attachments','product']);
        // dd($invoice);
        $sections=Section::get(['id','name']);
        return view('invoices.edit',compact('invoice','sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        
      $invoice=  $invoice->update([
            'number'=>$request->number,
             'invoice_date'=>$request->invoice_date,
             'due_date'=>$request->due_date,
             'product_id'=>$request->product_id,
             'section_id'=>$request->section_id,
             'amount_collection'=>$request->amount_collection,
             'amount_commission'=>$request->amount_commission,
             'discount'=>$request->discount,
             'value_VAT'=>$request->value_VAT,
             'rate_VAT'=>$request->rate_VAT,
             'total'=>$request->total,
             'note'=>$request->note,
             'user'=>Auth::user()->name,
             'payment_date'=>$request->payment_date
         ]);
         if($invoice){
            session()->flash('success',"تم تعديل الفتوره بنجاح");
        }else{
            session()->flash('error',"فشل التعديل  ");
        }
            return back(); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $invoice= Invoice::find($request->id);
        // dd($request->all());
        // dd($invoice);
      
            $invoice_number=$invoice->number;
            $this->deleteFolder($invoice_number);
             $invoice->forceDelete();
             if($invoice){
                session()->flash('delete_invoice');
             }
            
             return   redirect()->route('invoices.index');  
    }
function archive(Request $request){
    $invoice= Invoice::find($request->id)->delete();
   if($invoice){
    session()->flash('archive_invoice');
   }
    
    return redirect()->route('invoices.archive');

}
function unarchive(Request $request){
    // dd($request->all());
    $invoice= Invoice::withTrashed()->where('id', $request->id) ->restore();
   if($invoice){
    session()->flash('restore_invoice');
   }
    
    return redirect()->route('invoices.index');

}
function archive_destroy(Request $request){
    $invoice= Invoice::withTrashed()->find($request->id);
    // dd($invoice);
    $invoice_number=$invoice->number;
            $this->deleteFolder($invoice_number);
             $invoice->forceDelete();
             if($invoice){
                session()->flash('delete_invoice');
             }
            
             return   redirect()->route('invoices.archive');

}
function  invoices_archive(){
    $invoices=Invoice::with(['section','product'])->onlyTrashed()->get();
  
    // dd($invoices);
    return view('invoices.archive',compact('invoices'));
}


    function getProduct($id){
$products =Product::where('section_id',$id)->pluck('name','id');
// dd($products);
return json_encode($products);
    }


 function changePayment(Invoice $invoice){


    return view('invoices.changePayment',compact('invoice'));
    }


    function updatePayment(Request $request,Invoice $invoice){
// dd($request->all());

if ($request->status === 'مدفوعة') {
    $value_statas=1;
}else{
    $value_statas=3;  
}
    $invoice->update([
        'value_status' =>$value_statas,
        'status' => $request->status,
        'payment_date' => $request->payment_date,
    ]);
    
InvoiceDetail::create([
    'value_status' =>$value_statas,
    'status' => $request->status,
    'payment_date' => $request->payment_date,
    'invoice_number' =>$invoice->number, 
        'invoice_id'=>$invoice->id,
        'product_id'=>$invoice->product_id,
        'section_id'=>$invoice->section_id,
        'note'=>$invoice->note,
        'user'=>Auth::user()->name
]);

    session()->flash('Status_Update');
    return redirect()->route('invoices.index');

    }


function invoice_paid(){
    $invoices=Invoice::with(['section:id,name','product:id,name'])->where('value_status',1)->get();
    return view('invoices.invoice_paid',compact('invoices'));
}

function invoice_unpaid(){
$invoices=Invoice::with(['section:id,name','product:id,name'])->where('value_status',2)->get();
    return view('invoices.invoice_unpaid',compact('invoices'));
}
function invoice_partial(){
    $invoices=Invoice::with(['section:id,name','product:id,name'])->where('value_status',3)->get();
    return view('invoices.invoice_partial',compact('invoices'));
}



public function invoice_print(Invoice $invoice)
{
    //
    $invoice->load(['attachments','invoiceDetails','section','product']);
    //  dd($invoice);
    return view("invoices.invoice_print",compact('invoice'));
}
}
