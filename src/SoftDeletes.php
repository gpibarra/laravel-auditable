<?php

namespace Yajra\Auditable;

use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletesBase;

trait SoftDeletes
{
    use SoftDeletesBase;

    /**
     * Perform the actual delete query on this model instance.
     *
     * @return void
     */
    protected function runSoftDelete()
    {
        $query = $this->setKeysForSaveQuery($this->newModelQuery());
        $time = $this->freshTimestamp();
        $columns = [$this->getDeletedAtColumn() => $this->fromDateTime($time)];
        $columns[$this->getDeletedByColumn()] = $this->{$this->getDeletedByColumn()};
        $this->{$this->getDeletedAtColumn()} = $time;
        if ($this->timestamps && ! is_null($this->getUpdatedAtColumn())) {
            $this->{$this->getUpdatedAtColumn()} = $time;
            $columns[$this->getUpdatedAtColumn()] = $this->fromDateTime($time);
            $columns[$this->getUpdatedByColumn()] = $this->{$this->getUpdatedByColumn()};
        }
        $query->update($columns);
    }

}
