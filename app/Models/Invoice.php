<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use App\Models\Product;
use App\Models\Attachment;
use App\Models\invoiceDetail;
class Invoice extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable=[
        'number',
        'invoice_date',
        'due_date',
        'product_id',
        'section_id',
        'amount_collection',
        'amount_commission',
        'discount',
        'value_VAT',
        'rate_VAT',
        'total',
        'status',
        'value_status' ,
        'note',
        'user',
        'payment_date'
    ];



    function section(){
        return $this->belongsTo(Section::class);
    }
    function product(){
        return $this->belongsTo(Product::class);
    }

    function attachments(){
        return $this->hasMany(Attachment::class);
    }
    function invoiceDetails(){
        return $this->hasMany( InvoiceDetail::class);
    }

}
