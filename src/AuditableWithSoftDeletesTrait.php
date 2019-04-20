<?php

namespace Yajra\Auditable;


trait AuditableWithSoftDeletesTrait extends Auditable
{
    /**
     * Boot the audit trait for a model.
     *
     * @return void
     */
    public static function bootAuditableWithSoftDeletesTrait()
    {
        static::observe(new AuditableWithSoftDeletesTraitObserver);
    }

    /**
     * Get user model who deleted the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deleter()
    {
        return $this->belongsTo($this->getUserInstance(), $this->getDeletedByColumn());
    }

    /**
     * Get column name for updated by.
     *
     * @return string
     */
    protected function getUpdatedByColumn()
    {
        return 'updated_by';
    }

}
