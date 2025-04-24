<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Sale
 *
 * @property int $id
 * @property int $seller_id
 * @property float $amount
 * @property string $sale_date
 * @property string|null $deleted_at
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @package App\Models
 */
class Sale extends Model
{
    use HasFactory; // @phpstan-ignore-line
    use SoftDeletes;

    public const ID         = 'id';
    public const SELLER_ID  = 'seller_id';
    public const AMOUNT     = 'amount';
    public const COMMISSION = 'commission';
    public const SALE_DATE  = 'sale_date';
    public const DELETED_AT = 'deleted_at';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        self::SELLER_ID,
        self::AMOUNT,
        self::COMMISSION,
        self::SALE_DATE,
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        self::AMOUNT     => 'float',
        self::COMMISSION => 'float',
        self::SALE_DATE  => 'date',
        self::DELETED_AT => 'datetime',
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
    ];

    /**
     * Get the seller that owns the sale.
     *
     * @return BelongsTo<Seller, $this>
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class, Sale::SELLER_ID, Seller::ID);
    }
}
