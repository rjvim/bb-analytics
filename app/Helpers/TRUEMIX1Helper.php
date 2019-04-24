<?php

namespace App\Helpers;

use App\TRUEMIX1BatchDatTrans;

class TRUEMIX1Helper {


	public static function last5()
	{
		$dbBatches = TRUEMIX1BatchDatTrans::with('transactions')
										->orderBy('Batch_Date','desc')
										->take(5)
										->get();

		return self::processBatches($dbBatches, false);
	}

	public static function get($fromDate = null, $toDate = null, $all = false)
	{
		// var_dump($fromDate); die;
		// var_dump($toDate); die;

		$dbBatchesBuilder = TRUEMIX1BatchDatTrans::with('transactions')
										->whereDate('Batch_Date','>=', $fromDate)
										->whereDate('Batch_Date','<=', $toDate);


		// var_dump($dbBatchesBuilder->get()); die;
										

		if(!$all)
		{
			$dbBatchesBuilder = $dbBatchesBuilder->where('Customer_Code', 'LIKE', 'BB-%');
		}

		$dbBatches = $dbBatchesBuilder
							->orderBy('Batch_Date','asc')
							->get();



		return self::processBatches($dbBatches);
	}

	public static function processBatches($dbBatches, $includeDetails = true)
	{
		$batches = [];

		foreach($dbBatches as $dbBatch)
		{
			$batch = [];
			$batch['batchNo'] = $dbBatch['Batch_No'];
			$batch['batchDate'] = $dbBatch->Batch_Date->format('Y-m-d H:i:s');
			$batch['productionQty'] = $dbBatch->transactions()->sum('Production_Qty');
			$batch['customerName'] = $dbBatch->Customer_Code;
			$batch['vehicle'] = $dbBatch["Truck_No"];
			$batch['grade'] = $dbBatch["Recipe_Name"];
			$batch['agg1Target'] = $dbBatch["Gate1_Target"] ?: 0;
			$batch['agg2Target'] = $dbBatch["Gate2_Target"] ?: 0;
			$batch['agg3Target'] = $dbBatch["Gate3_Target"] ?: 0;
			$batch['agg4Target'] = $dbBatch["Gate4_Target"] ?: 0;
			$batch['agg5Target'] = $dbBatch["Gate5_Target"] ?: 0;
			$batch['agg6Target'] = $dbBatch["Gate6_Target"] ?: 0;
			$batch['agg7Target'] = $dbBatch["Cement1_Target"] ?: 0;
			$batch['agg8Target'] = $dbBatch["Cement2_Target"] ?: 0;
			$batch['agg9Target'] = $dbBatch["Cement2_Target"] ?: 0;
			$batch['agg10Target'] = $dbBatch["Cement4_Target"] ?: 0;
			$batch['agg11Target'] = $dbBatch["Filler1_Target"] ?: 0;
			$batch['agg12Target'] = $dbBatch["Water1_Target"] ?: 0;
			$batch['agg13Target'] = $dbBatch["Water2_Target"] ?: 0;
			$batch['agg14Target'] = $dbBatch["Silica_Target"] ?: 0;
			$batch['agg15Target'] = $dbBatch["Slurry_Target"] ?: 0;
			$batch['agg16Target'] = $dbBatch["Adm1_Target1"] ?: 0;
			$batch['agg17Target'] = $dbBatch["Adm1_Target2"] ?: 0;
			$batch['agg18Target'] = $dbBatch["Adm2_Target1"] ?: 0;
			$batch['agg19Target'] = $dbBatch["Adm2_Target2"] ?: 0;
			$batch['agg20Target'] = $dbBatch["Pigment_Target"] ?: 0;
			$batch['cement1Target'] = 0;
			$batch['cement2Target'] = 0;
			$batch['cement3Target'] = 0;
			$batch['cement4Target'] = 0;
			$batch['cement5Target'] = 0;
			$batch['additive1Target1'] = 0;
			$batch['additive1Target2'] = 0;
			$batch['additive2Target1'] = 0;
			$batch['additive2Target2'] = 0;
			$batch['waterTarget'] = 0;
			// $batch['waterTarget1'] = $dbBatch["Water1_Target"] ?: 0;
			// $batch['waterTarget2'] = $dbBatch["Water2_Target"] ?: 0;
			$details = [];

			foreach($dbBatch->transactions as $dbTransaction)
			{
				$detail = [];

				$detail['bNo'] = $dbTransaction['Batch_Index'];
				$detail['bTime'] = $dbTransaction->Batch_Date->format('Y-m-d H:i:s');
				$detail['finalAggr1'] = floatval($dbTransaction["Gate1_Actual"]) ?: 0;
				$detail['finalAggr2'] = floatval($dbTransaction["Gate2_Actual"]) ?: 0;
				$detail['finalAggr3'] = floatval($dbTransaction["Gate3_Actual"]) ?: 0;
				$detail['finalAggr4'] = floatval($dbTransaction["Gate4_Actual"]) ?: 0;
				$detail['finalAggr5'] = floatval($dbTransaction["Gate5_Actual"]) ?: 0;
				$detail['finalAggr6'] = floatval($dbTransaction["Gate6_Actual"]) ?: 0;
				$detail['finalAggr7'] = floatval($dbTransaction["Cement1_Actual"]) ?: 0;
				$detail['finalAggr8'] = floatval($dbTransaction["Cement2_Actual"]) ?: 0;
				$detail['finalAggr9'] = floatval($dbTransaction["Cement3_Actual"]) ?: 0;
				$detail['finalAggr10'] = floatval($dbTransaction["Cement4_Actual"]) ?: 0;
				$detail['finalAggr11'] = floatval($dbTransaction["Filler1_Actual"]) ?: 0;
				$detail['finalAggr12'] = floatval($dbTransaction["Water1_Actual"]) ?: 0;
				$detail['finalAggr13'] = floatval($dbTransaction["Water2_Actual"]) ?: 0;
				$detail['finalAggr14'] = floatval($dbTransaction["Silica_Actual"]) ?: 0;
				$detail['finalAggr15'] = floatval($dbTransaction["Slurry_Actual"]) ?: 0;
				$detail['finalAggr16'] = floatval($dbTransaction["Adm1_Actual1"]) ?: 0;
				$detail['finalAggr17'] = floatval($dbTransaction["Adm1_Actual2"]) ?: 0;
				$detail['finalAggr18'] = floatval($dbTransaction["Adm2_Actual1"]) ?: 0;
				$detail['finalAggr19'] = floatval($dbTransaction["Adm2_Actual2"]) ?: 0;
				$detail['finalAggr20'] = floatval($dbTransaction["Pigment_Actual"]) ?: 0;
				$detail['finalCem1'] = 0;
				$detail['finalCem2'] = 0;
				$detail['finalCem3'] = 0;
				$detail['finalCem4'] = 0;
				$detail['finalCem5'] = 0;
				$detail['finalAdditive1_1'] = 0;
				$detail['finalAdditive1_2'] =  0;
				$detail['finalAdditive2_1'] = 0;
				$detail['finalAdditive2_2'] = 0;
				$detail['finalWater1'] = 0;
				$detail['finalWater2'] = 0;

				$details[] = $detail;
			}

			if($includeDetails)
			{
				$batch['details'] = $details;
			}
			
			$batches[] = $batch;
		}

		return $batches;
	}


}