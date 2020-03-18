<?php

namespace App\ModelFilters\System;

use EloquentFilter\ModelFilter;

/**
 * 运营商平台
 */
class SystemPlatformFilter extends ModelFilter
{

    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [
                         'owner' => ['email'],
                        ];

    /**
     * 状态查询
     *
     * @param  string $status 状态.
     * @return $this
     */
    public function status(string $status): SystemPlatformFilter
    {
        $eloq = $this->where('status', $status);
        return $eloq;
    }

    /**
     * 生成时间
     *
     * @param  array $createdAt 生成时间.
     * @return $this
     */
    public function createdAt(array $createdAt): SystemPlatformFilter
    {
        if (!is_array($createdAt) || count($createdAt) !== 2) {
            $eloq = $this;
        } else {
            $eloq = $this->whereBetween('created_at', $createdAt);
        }
        return $eloq;
    }

    /**
     * 维护状态查询
     *
     * @param  string $maintain 状态.
     * @return $this
     */
    public function maintain(string $maintain): SystemPlatformFilter
    {
        $eloq = $this;
        if ((int) $maintain === 0) {
            $eloq = $this->where([['maintain_start', null], ['maintain_end', null]]);
        } elseif ((int) $maintain === 1) {
            $eloq = $this->where([['maintain_start', '!=', null], ['maintain_end', '!=', null]]);
        }
        return $eloq;
    }
}
