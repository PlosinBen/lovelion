<?php

namespace App\Package;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator as ValidatorResult;

class RequestValidator
{
    protected Collection $original;
    protected Collection $rule;
    protected Collection $default;
    protected Collection $result;
    protected ValidatorResult $validateResult;

    public Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->rule = $this->default = collect();
    }

    public function __get($key)
    {
        return $this->request->get($key);
    }

    /**
     * @param array $rule
     * @return $this
     */
    public function rule(array $rule): self
    {
        $this->rule = collect($rule);

        return $this;
    }

    /**
     * @param array $default
     * @return $this
     */
    public function default(array $default): self
    {
        $this->default = collect($default);

        return $this;
    }

    public function validate(): self
    {
        $this->validateResult = validator($this->request->all(), $this->rule->toArray());

        $this->result = collect($this->request->all())
            ->only($this->rule->keys());

        collect($this->errors())->each(function ($message, $index) {
            $this->result->put($index, $this->default->get($index, ''));
        });

        return $this;
    }

    public function fillUnset(): self
    {
        $this->result = collect($this->rule)->map(function ($v, $key) {
            $value = $this->result->get($key, '');
            if (is_string($value) && strlen($value) === 0) {
                $value = $this->default->get($key, '');
            }

            return $value;
        });

        return $this;
    }

    public function get(): Collection
    {
        return $this->result;
    }

    /**
     * @return MessageBag
     */
    public function errors(): MessageBag
    {
        return $this->validateResult->errors();
    }

    /**
     * @return bool
     */
    public function passes(): bool
    {
        return $this->validateResult->passes();
    }
}
