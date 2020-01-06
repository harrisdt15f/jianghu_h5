<?php

namespace App\Models\Finance;

use App\Models\Admin\MerchantAdminUser;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class SystemFinanceOfflineInfo
 * @package App\Models\Finance
 */
class SystemFinanceOfflineInfo extends BaseModel
{

    /**
     * @var array
     */
    protected $guarded = ['id'];

    public const STATUS_YES = 1;
    public const STATUS_NO  = 0;

    /**
     * @return BelongsTo
     */
    public function lastEditor(): BelongsTo
    {
        $object = $this->belongsTo(MerchantAdminUser::class, 'last_editor_id', 'id');
        return $object;
    }

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        $object = $this->belongsTo(MerchantAdminUser::class, 'author_id', 'id');
        return $object;
    }

    /**
     * @return BelongsTo
     */
    public function bank(): BelongsTo
    {
        $object = $this->belongsTo(SystemBank::class, 'bank_id', 'id');
        return $object;
    }
}
