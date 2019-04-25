<?php

namespace Yajra\Auditable;

use Illuminate\Database\Eloquent\Model;

class AuditableTraitObserver
{
    /**
     * Model's creating event hook.
     *
     * @param Model $model
     */
    public function creating(Model $model)
    {
        $user_id = $this->getAuthenticatedUserId();
        if (! $model->created_by) {
            $model->created_by = $user_id;
        }

        if (! $model->updated_by) {
            if ($model->usesTimestamps()) {
                $model->updated_by = $user_id;
            }
        }
    }

    /**
     * Get authenticated user id depending on model's auth guard.
     *
     * @return int
     */
    protected function getAuthenticatedUserId()
    {
        return auth()->check() ? auth()->id() : 0;
    }

    /**
     * Model's updating event hook.
     *
     * @param Model $model
     */
    public function updating(Model $model)
    {
        if (! $model->isDirty('updated_by')) {
            if ($model->usesTimestamps()) {
                $user_id = $this->getAuthenticatedUserId();
                $model->updated_by = $user_id;
            }
        }
    }
}
