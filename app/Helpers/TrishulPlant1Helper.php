<?php

namespace App\Helpers;

use App\TrishulPlant1BatchDatTrans;

class TrishulPlant1Helper {


	public static function get($fromDate = null, $toDate = null)
	{
		// var_dump($fromDate); die;
		// var_dump($toDate); die;

		$dbBatches = TrishulPlant1BatchDatTrans::with('transactions','customer')
										->where('Batch_Date','>=', $fromDate)
										->where('Batch_Date','<=', $toDate)
										->get();

		$batches = [];

		foreach($dbBatches as $dbBatch)
		{
			$batch = [];
			$batch['batchNo'] = $dbBatch['Batch_No'];
			$batch['batchDate'] = $dbBatch->Batch_Date->format('Y-m-d').$dbBatch->Batch_Time->format(' H:i:s');
			$batch['productionQty'] = $dbBatch->transactions()->sum('Production_Qty');
			$batch['customerName'] = $dbBatch->customer->Customer_Name;
			$batch['vehicle'] = $dbBatch["Truck_No"];
			$batch['grade'] = $dbBatch["Recipe_Name"];
			$batch['agg1Target'] = $dbBatch["Gate1_Target"] ?: 0;
			$batch['agg2Target'] = $dbBatch["Gate2_Target"] ?: 0;
			$batch['agg3Target'] = $dbBatch["Gate3_Target"] ?: 0;
			$batch['agg4Target'] = $dbBatch["Gate4_Target"] ?: 0;
			$batch['agg5Target'] = $dbBatch["Gate5_Target"] ?: 0;
			$batch['agg6Target'] = $dbBatch["Gate6_Target"] ?: 0;
			$batch['agg7Target'] = 0;
			$batch['agg8Target'] = 0;
			$batch['agg9Target'] = 0;
			$batch['agg10Target'] = 0;
			$batch['agg11Target'] = 0;
			$batch['agg12Target'] = 0;
			$batch['agg13Target'] = 0;
			$batch['agg14Target'] = 0;
			$batch['agg15Target'] = 0;
			$batch['agg16Target'] = 0;
			$batch['agg17Target'] = $dbBatch["Filler1_Target"] ?: 0;
			$batch['agg18Target'] = $dbBatch["Silica_Target"] ?: 0;
			$batch['agg19Target'] = $dbBatch["slurry_Target"] ?: 0;
			$batch['agg20Target'] = $dbBatch["Pigment_Target"] ?: 0;
			$batch['cement1Target'] = $dbBatch["Cement1_Target"] ?: 0;
			$batch['cement2Target'] = $dbBatch["Cement2_Target"] ?: 0;
			$batch['cement3Target'] = $dbBatch["Cement3_Target"] ?: 0;
			$batch['cement4Target'] = $dbBatch["Cement4_Target"] ?: 0;
			$batch['cement5Target'] = 0;
			$batch['additive1Target1'] = $dbBatch["Adm1_Target1"] ?: 0;
			$batch['additive1Target2'] = $dbBatch["Adm1_Target2"] ?: 0;
			$batch['additive2Target1'] = $dbBatch["Adm2_Target1"] ?: 0;
			$batch['additive2Target2'] = $dbBatch["Adm2_Target2"] ?: 0;
			$batch['waterTarget'] = $dbBatch["Water1_Target"] ?: 0;
			$batch['waterTarget1'] = $dbBatch["Water1_Target"] ?: 0;
			$batch['waterTarget2'] = $dbBatch["Water2_Target"] ?: 0;
			$details = [];

			foreach($dbBatch->transactions as $dbTransaction)
			{
				$detail = [];

				$detail['bNo'] = $dbTransaction['Batch_Index'];
				$detail['bTime'] = $dbTransaction->Batch_Date->format('Y-m-d').$dbTransaction->Batch_Time->format(' H:i:s');
				$detail['finalAggr1'] = $dbTransaction["Gate1_Actual"] ?: 0;
				$detail['finalAggr2'] = $dbTransaction["Gate2_Actual"] ?: 0;
				$detail['finalAggr3'] = $dbTransaction["Gate3_Actual"] ?: 0;
				$detail['finalAggr4'] = $dbTransaction["Gate4_Actual"] ?: 0;
				$detail['finalAggr5'] = $dbTransaction["Gate5_Actual"] ?: 0;
				$detail['finalAggr6'] = $dbTransaction["Gate6_Actual"] ?: 0;
				$detail['finalAggr7'] = 0;
				$detail['finalAggr8'] = 0;
				$detail['finalAggr9'] = 0;
				$detail['finalAggr10'] = 0;
				$detail['finalAggr11'] = 0;
				$detail['finalAggr12'] = 0;
				$detail['finalAggr13'] = 0;
				$detail['finalAggr14'] = 0;
				$detail['finalAggr15'] = 0;
				$detail['finalAggr16'] = 0;
				$detail['finalAggr17'] = $dbTransaction["Filler1_Actual"] ?: 0;
				$detail['finalAggr18'] = $dbTransaction["Silica_Actual"] ?: 0;
				$detail['finalAggr19'] = $dbTransaction["Slurry_Actual"] ?: 0;
				$detail['finalAggr20'] = $dbTransaction["Pigment_Actual"] ?: 0;
				$detail['finalCem1'] = $dbTransaction["Cement1_Actual"] ?: 0;
				$detail['finalCem2'] = $dbTransaction["Cement2_Actual"] ?: 0;
				$detail['finalCem3'] = $dbTransaction["Cement3_Actual"] ?: 0;
				$detail['finalCem4'] = $dbTransaction["Cement4_Actual"] ?: 0;
				$detail['finalCem5'] = 0;
				$detail['finalAdditive1_1'] = $dbTransaction["Adm1_Actual1"] ?: 0;
				$detail['finalAdditive1_2'] = $dbTransaction["Adm1_Actual2"] ?: 0;
				$detail['finalAdditive2_1'] = $dbTransaction["Adm2_Actual1"] ?: 0;
				$detail['finalAdditive2_2'] = $dbTransaction["Adm2_Actual2"] ?: 0;
				$detail['finalWater1'] = $dbTransaction["Water1_Actual"] ?: 0;
				$detail['finalWater2'] = $dbTransaction["Water2_Actual"] ?: 0;

				$details[] = $detail;
			}


			$batch['details'] = $details;
			$batches[] = $batch;
		}

		return $batches;
	}


}