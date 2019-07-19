<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Serrt\Mall\Models\User;

class Order extends Model
{
    const REFUND_PENDING = 0;
    const REFUND_APPLY = 1;
    const REFUND_PROCESSING = 2;
    const REFUND_SUCCESS = 3;
    const REFUND_FAIL = 4;

    const SHIP_PENDING = 0;
    const SHIP_PROCESSING = 1;
    const SHIP_FINISH = 2;

    protected $table = 'orders';

    protected $fillable = [
        'id', 'out_trade_no', 'merchant_id', 'user_id',
        'address',
        'money', 'score',
        'pay_time', 'pay_way', 'pay_trade_no',
        'refund_status', 'refund_no', 'refund_time', 'refund_text',
        'ship_status', 'ship_time', 'ship_data',
        'is_closed',
        'is_reviewed',
        'remarks',
        'extra',
        'created_at',
        'updated_at'
    ];

    public static $refundMap = [
        self::REFUND_PENDING => '未退款',
        self::REFUND_APPLY => '已申请',
        self::REFUND_PROCESSING => '处理中',
        self::REFUND_SUCCESS => '已退款',
        self::REFUND_FAIL => '退款失败',
    ];

    public static $shipMap = [
        self::SHIP_PENDING => '未发货',
        self::SHIP_PROCESSING => '已发货',
        self::SHIP_FINISH => '已收货',
    ];

    protected $casts = [
        'address' => 'array',
        'ship_data' => 'array',
    ];

    protected $dates = [
        'pay_time', 'ship_time', 'refund_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
