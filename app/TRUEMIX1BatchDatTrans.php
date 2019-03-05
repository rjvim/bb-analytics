<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class TRUEMIX1BatchDatTrans extends Model
{
    protected $fillable = [];
    protected $guarded = [];
    protected $dates = ['Batch_Date'];
    protected $table = 'TRUEMIX1_Batch_Dat_Trans';

    public function transactions()
    {
        return $this
                ->hasMany(TRUEMIX1BatchTransaction::class, 'Batch_No', 'Batch_No');
    }
}
