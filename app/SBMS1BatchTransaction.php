<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class SBMS1BatchTransaction extends Model
{
    protected $fillable = [];
    protected $guarded = [];
    protected $dates = ['Batch_Date'];
    protected $table = 'SBMS1_Batch_Transaction';

}
