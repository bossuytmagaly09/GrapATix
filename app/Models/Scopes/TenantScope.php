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
            } elseif ($path === '/livewire/update' || str_starts_with($path, '/livewire')) {
                $referer = request()->headers->get('referer');
                if ($referer) {
                    $refererPath = '/' . ltrim(parse_url($referer, PHP_URL_PATH) ?? '', '/');
                    // Gebruik str_contains in plaats van str_starts_with om WAMP subfolders (zoals /GrapATix/public/dashboard) te ondersteunen!
                    if (str_contains($refererPath, '/dashboard')) {
                        $isDashboard = true;
                    }
                }
            }
        }

        if ($isDashboard) {
            $orgId = Session::get('active_organization_id');
            
            // Fallback for implicit route model binding which runs before EnsureTenantContext sets the session
            if (!$orgId && !($model instanceof \App\Models\User)) {
                if (auth()->check()) {
                    $orgId = auth()->user()->organization_id;
                }
            }

            if ($orgId) {
                $builder->where(function ($query) use ($model, $orgId) {
                    $query->where($model->getTable() . '.organization_id', $orgId)
                          ->orWhereNull($model->getTable() . '.organization_id');
                });
            }
        }
    }
}
