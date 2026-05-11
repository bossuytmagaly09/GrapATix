<?php

namespace App\Traits;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

trait BelongsToTenant
{
    /**
     * Boot the trait to add the global scope.
     */
    protected static function booted()
    {
        static::addGlobalScope(new TenantScope);

        // Automatisch de organization_id instellen bij het aanmaken van een model
        static::creating(function (Model $model) {
            if (Session::has('active_organization_id') && ! $model->organization_id) {
                $model->organization_id = Session::get('active_organization_id');
            }
        });
    }

    /**
     * Relatie naar de organisatie
     */
    public function organization()
    {
        return $this->belongsTo(\App\Models\Organization::class);
    }
}
