<?php

namespace Yajra\Auditable;


trait AuditableWithSoftDeletesTrait
{
    use SoftDeletes;
    use AuditableTrait;
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
     * Get column name for deleted by.
     *
     * @return string
     */
    protected function getDeletedByColumn()
    {
        return 'deleted_by';
    }

}
