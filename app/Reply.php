<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use RecordsActivity, Favoritable;
    protected $guarded = [];
    protected $with = ['owner','favorites'];
    protected $appends = ['favoritesCount', 'isFavorited'];
    protected static function boot() {
        parent::boot();
        static::deleting(function($model){
            $model->favorites->each->delete();
        });
    }
    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
    public function path() {
        return $this->thread->path().'#reply-'.$this->id;
    }
}
