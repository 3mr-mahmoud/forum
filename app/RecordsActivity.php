<?php
/**
 * Created by PhpStorm.
 * User: M-A
 * Date: 08/03/2018
 * Time: 01:32 ص
 */

namespace App;


trait RecordsActivity
{

    protected static $eventsToRecord = ['created'];
    protected static function bootRecordsActivity() {
        if(auth()->guest()) return '';
        foreach (static::$eventsToRecord as $event) {
            static::created(function ($model) use ($event) {
                $model->RecordActivity($event);
            });
        }
        static::deleting(function ($model) {
            $model->activity()->delete();
        });
    }
    protected static function getRecordsActivity() {
        return ['created'];
    }
    public function RecordActivity($event) {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event)
        ]);
    }
    protected function activity() {
        return $this->morphMany('App\Activity','subject');
    }
    protected function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
    }
}