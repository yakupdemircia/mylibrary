<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model
{
    protected $guarded = [];

    use SoftDeletes;

    public function book()
    {
        return $this->belongsTo(Book::class)->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->first();
    }

    public function delayed()
    {
        return \DB::table('issues')->where('returned',0)->where('end_date','<', date('Y-m-d 00:00:00') )->count();
    }

}
