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
    }

    /**
     * Model's deleted event hook.
     *
     * @param Model $model
     */
    public function deleted(Model $model)
    {
        $query = $model->setKeysForSaveQuery($model->newModelQuery());

        $columns = [$this->getUpdatedByColumn() => $this->getAuthenticatedUserId()];
        $this->{$this->getUpdatedByColumn()} = $this->getAuthenticatedUserId();
        $columns[$this->getDeletedByColumn()] = $this->getAuthenticatedUserId();
        $this->{$this->getDeletedByColumn()} = $this->getAuthenticatedUserId();

        $query->update($columns);

        // DB::commit();
    }

    /**
     * Model's restoring event hook.
     *
     * @param Model $model
     */
    public function restoring(Model $model)
    {
        if (! $model->isDirty('updated_by')) {
            $model->updated_by = $this->getAuthenticatedUserId();
        }
        $model->deleted_by = null;
    }
}
