<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Session;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Alleen filteren als we een actieve organisatie in de sessie hebben
        // Dit wordt later gezet door de middleware
        if (Session::has('active_organization_id')) {
            $builder->where(function ($query) use ($model) {
                $query->where($model->getTable() . '.organization_id', Session::get('active_organization_id'))
                      ->orWhereNull($model->getTable() . '.organization_id');
            });
        }
    }
}
