<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchQuery extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at'];
    public $timestamps = false;
}
