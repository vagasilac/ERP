<?php namespace App\Observers;

use Illuminate\Support\Str;

class GanttTaskObserver {

    /**
     * Generate machine name
     *
     * @param $model
     */
    public function creating($model)
    {
        if (is_null($model->getAttribute('start_date'))) {
            $model->setAttribute('start_date', date('Y-m-d 00:00:00'));
        }
        if (is_null($model->getAttribute('end_date'))) {
            $model->setAttribute('end_date', date('Y-m-d 00:00:00'));
        }
        if (is_null($model->getAttribute('duration'))) {
            $model->setAttribute('duration', 1);
        }
    }

}