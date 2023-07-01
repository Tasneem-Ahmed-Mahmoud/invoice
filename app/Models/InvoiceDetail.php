<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $fillable=['invoice_number' , 'invoice_id','status','status_value',
    'product_id','section_id',
'payment_date','note','user'];
}


