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
        // Alleen filteren in de dashboard context (backend) of tijdens model tests (console)
        $isDashboard = false;
        
        if (app()->runningInConsole() && !request()->route()) {
            $isDashboard = true;
        } else {
            $path = '/' . ltrim(request()->getPathInfo(), '/');
            if ($path === '/dashboard' || str_starts_with($path, '/dashboard/') || $path === '/api/dashboard' || str_starts_with($path, '/api/dashboard/')) {
                $isDashboard = true;
            } elseif ($path === '/livewire/update') {
                $referer = request()->headers->get('referer');
                if ($referer) {
                    $refererPath = '/' . ltrim(parse_url($referer, PHP_URL_PATH) ?? '', '/');
                    if ($refererPath === '/dashboard' || str_starts_with($refererPath, '/dashboard/') || $refererPath === '/api/dashboard' || str_starts_with($refererPath, '/api/dashboard/')) {
                        $isDashboard = true;
                    }
                }
            }
        }

        if ($isDashboard && Session::has('active_organization_id')) {
            $builder->where(function ($query) use ($model) {
                $query->where($model->getTable() . '.organization_id', Session::get('active_organization_id'))
                      ->orWhereNull($model->getTable() . '.organization_id');
            });
        }
    }
}
