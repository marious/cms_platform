<?php

namespace EG\Ecommerce\Models;

use EG\Base\Enums\BaseStatusEnum;
use EG\Base\Models\BaseModel;
use EG\Base\Traits\EnumCastable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use phpDocumentor\Reflection\Types\Mixed_;

class Review extends BaseModel
{
    use EnumCastable;

    protected $table = 'ec_reviews';

    protected $fillable = [
        'product_id',
        'customer_id',
        'star',
        'comment',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id')->withDefault();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id')->withDefault();
    }

    public function getProductNameAttribute()
    {
        return $this->product->name;
    }

    public function getUserNameAttribute()
    {
        return $this->user->name;
    }
}
