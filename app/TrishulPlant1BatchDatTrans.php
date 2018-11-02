<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class TrishulPlant1BatchDatTrans extends Model
{
    protected $fillable = [];
    protected $guarded = [];
    protected $dates = ['Batch_Date','Batch_Time'];
    protected $table = 'Trishul_Plant_1_Batch_Dat_Trans';

    public function transactions()
    {
        return $this
                ->hasMany(TrishulPlant1BatchTransaction::class, 'Batch_No', 'Batch_No')
                ->where('Batch_Date',$this->Batch_Date);
    }

    public function customer()
    {
        return $this->belongsTo(TrishulPlant1CustomerMaster::class, 'Customer_Code', 'Customer_Code');
    }
}
