<?php

namespace App\Models\Game;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class GameVendorPlatform
 * @package App\Models\Game
 */
class GameVendorPlatform extends BaseModel
{

    /**
     * @var array
     */
    protected $guarded = ['id'];


    public const DEVICE_H5  = 2;
    public const DEVICE_APP = 3;
    public const DEVICE_PC  = 1;

    /**
     * @return BelongsTo
     */
    public function gameVendor(): BelongsTo
    {
        $object = $this->belongsTo(GamesVendor::class, 'vendor_id', 'id');
        return $object;
    }
}