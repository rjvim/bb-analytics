<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class TrishulPlant1BatchTransaction extends Model
{
    protected $fillable = [];
    protected $guarded = [];
    protected $dates = ['Batch_Date','Batch_Time'];
    protected $table = 'Trishul_Plant_1_Batch_Transaction';

}
