<?php

namespace App\Models\Access\Project\Traits\Scope;

/**
 * Class UserScope.
 */
trait ProjectScope
{
    /**
     * @param $query
     * @param bool $confirmed
     *
     * @return mixed
     */
    public function scopeConfirmed($query, $confirmed = true)
    {
        return $query->where('confirmed', $confirmed);
    }

    /**
     * @param $query
     * @param bool $status
     *
     * @return mixed
     */
    public function scopeActive($query, $status = true)
    {
        return $query->where(config('access.project_table').'.status', $status);
    }
}
