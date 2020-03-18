<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = "_z_country";// I guess this is where we define what is the name of the table, in cases like this, when the table name and the model name are not matching...
    protected $guarded = [];
}
