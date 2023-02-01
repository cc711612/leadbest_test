<?php

namespace App\Models\Services\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class ServiceAbstract
 *
 * @package App\Models\Services\Contracts
 * @Author: Roy
 * @DateTime: 2023/1/31 下午 05:50
 */
abstract class ServiceAbstract
{
    abstract protected function getEntity(): Model;

    /**
     * @var array
     * @Author  : Roy
     * @DateTime: 2022/5/25 上午11:01
     */
    private $request = [];

    /**
     * @return array
     * @Author  : Roy
     * @DateTime: 2022/5/25 上午11:01
     */
    public function getRequest(): array
    {
        return $this->request;
    }

    /**
     * @param  string  $key
     *
     * @return array|\ArrayAccess|mixed
     * @Author  : Roy
     * @DateTime: 2022/5/25 上午11:01
     */
    public function getRequestByKey(string $key)
    {
        return Arr::get($this->getRequest(), $key, null);
    }
    /**
     * @param  array  $request
     *
     * @return $this
     * @Author  : Roy
     * @DateTime: 2022/5/25 上午11:01
     */
    public function setRequest(array $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return bool
     * @Author  : Roy
     * @DateTime: 2022/5/25 上午11:01
     */
    public function isEmptyRequest()
    {
        return empty($this->getRequest());
    }
}
