<?php

namespace App\ModelFilters\Platform;

use EloquentFilter\ModelFilter;

/**
 * Class GamesPlatformFilter
 * @package App\ModelFilters\Platform
 */
class GamesPlatformFilter extends ModelFilter
{

    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [
        'games' => ['name'],
        'vendor' => ['vendor_id'],
        'type' => ['type_id'],
    ];

    /**
     * 根据平台标记查询
     * @param string $platform_sign PlatformSign.
     * @return object
     */
    public function platformSign(string $platform_sign): object
    {
        $object = $this->where('platform_sign', $platform_sign);
        return $object;
    }

    /**
     * 根据设备查询
     * @param integer $device Device.
     * @return object
     */
    public function device(int $device): object
    {
        $object = $this->where('device', $device);
        return $object;
    }

    /**
     * 根据状态查询
     * @param integer $status Status.
     * @return object
     */
    public function status(int $status): object
    {
        $object = $this->where('status', $status);
        return $object;
    }
}
