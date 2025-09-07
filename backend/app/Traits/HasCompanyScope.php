<?php

namespace App\Traits;

trait HasCompanyScope
{
    protected static function bootHasCompanyScope()
    {
        static::addGlobalScope('company', function ($builder) {
            if (auth()->check()) {
                $builder->where('company_id', auth()->user()->company_id);
            }
        });
    }

    protected function getCompanyId(): int
    {
        return auth()->user()->company_id;
    }

    protected function getUserId(): int
    {
        return auth()->user()->id;
    }

    protected function addCompanyContext(array $data): array
    {
        return array_merge($data, [
            'company_id' => $this->getCompanyId(),
            'user_id' => $this->getUserId(),
        ]);
    }
}
