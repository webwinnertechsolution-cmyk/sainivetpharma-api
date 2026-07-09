<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRefundPolicy extends Model
{
    use HasFactory;
    protected $table = 'return_refund_policies';
    protected $fillable = [
        'heading',
        'description',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
