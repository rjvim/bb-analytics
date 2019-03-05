<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class TRUEMIX1BatchTransaction extends Model
{
    protected $fillable = [];
    protected $guarded = [];
    protected $dates = ['Batch_Date'];
    protected $table = 'TRUEMIX1_Batch_Transaction';

}
