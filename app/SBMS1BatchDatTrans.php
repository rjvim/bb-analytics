<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class SBMS1BatchDatTrans extends Model
{
    protected $fillable = [];
    protected $guarded = [];
    protected $dates = ['Batch_Date'];
    protected $table = 'SBMS1_Batch_Dat_Trans';

    public function transactions()
    {
        return $this
                ->hasMany(SBMS1BatchTransaction::class, 'Batch_No', 'Batch_No');
    }
}
