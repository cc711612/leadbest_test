<?php
/**
 * @Author: Roy
 * @DateTime: 2023/2/1 下午 07:46
 */

namespace App\Http\Macro\Contracts;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

abstract class MacroAbstract
{
    protected $request = [];

    protected $result = [];

    public function getRequest(): array
    {
        return $this->request;
    }

    public function getRequestByKey(string $key)
    {
        return Arr::get($this->request, $key);
    }

    public function setRequest(array $request): self
    {
        $this->request = $request;
        return $this;
    }

    public function error_log($class_name, $message): void
    {
        if (config('app.env') != 'local') {
            Log::channel('slack')->critical(sprintf("%s error: %s", $class_name, $message));
        }
    }

    protected function initResult(): void
    {
        if (is_array($this->result)) {
            $this->result = [
                'status'  => false,
                'message' => null,
            ];
        }
    }

    protected function getResult(): array
    {
        return $this->result;
    }

    protected function setMessage(string $message): void
    {
        $this->initResult();
        Arr::set($this->result, 'message', $message);
    }

    protected function setStatus(bool $status): void
    {
        $this->initResult();
        Arr::set($this->result, 'status', $status);
    }
}
