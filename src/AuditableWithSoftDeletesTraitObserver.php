<?php

namespace Yajra\Auditable;

use Illuminate\Database\Eloquent\Model;

class AuditableWithSoftDeletesTraitObserver extends AuditableTraitObserver
{
    /**
     * Model's deleting event hook.
     *
     * @param Model $model
     */
    public function deleting(Model $model)
    {
        // DB::beginTransaction();
        $user_id = $this->getAuthenticatedUserId();
        if ($model->usesTimestamps()) {
            $model->updated_by = $user_id;
        }
        $model->deleted_by = $user_id;

    }

    /**
     * Model's restoring event hook.
     *
     * @param Model $model
     */
    public function restoring(Model $model)
    {
        if (! $model->isDirty('updated_by')) {
            if ($model->usesTimestamps()) {
                $user_id = $this->getAuthenticatedUserId();
                $model->updated_by = $user_id;
            }
        }
        $model->deleted_by = null;
    }
}
