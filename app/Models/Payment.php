<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'user_id',
        'method',
        'amount',
        'phone_number',
        'transaction_id',
        'status',
    ];

    public const METHOD_ORANGE_MONEY = 'ORANGE_MONEY';
    public const METHOD_MTN_MOMO = 'MTN_MOMO';

    public const STATUS_PENDING = 'PENDING';
    public const STATUS_FAILED = 'FAILED';
    public const STATUS_SUCCEED = 'SUCCEED';

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
