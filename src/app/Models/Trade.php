<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_id',
        'trade_status_id',
        'buyer_rating_points',
        'seller_rating_points',
    ];

    //TradeとPurchaseのリレーション
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    //TradeとTradeStatusのリレーション
    public function tradeStatus()
    {
        return $this->belongsTo(TradeStatus::class);
    }
}
