<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AskQuestion extends Model
{
    protected $table = 'ask_questions';

    protected $guarded = [];

     public function scopeActive($query)
    {
        return $query->where('ask_questions.is_block','N');
    }

    public function answers()
    {
        return $this->hasMany(self::class,'replay_id');
    }
    public function answer()
    {
        return $this->hasOne(self::class,'replay_id');
    }
}
