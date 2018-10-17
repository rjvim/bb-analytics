<?php namespace App\Console\Commands\TrishulPlant1;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use DB;

class Copy extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'bb:trishul_plant_1_copy';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Make Copy';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$source = 'root@139.59.59.181:/home/export/';
		$suffix = 'logs/Trishul_Plant_1_';


		$files = [
			'Batch_Dat_Trans',
			'Batch_Transaction',
			'Customer_Master',
		];

		foreach($files as $file)
		{
			$command = "mdb-export /home/forge/Wincc_batch.mdb $file > ".storage_path($suffix"$file.csv");
			$this->line($command);
		}

		return true;
		// shell_exec("mdb-export /home/forge/Wincc_batch.mdb Batch_Dat_Trans > Batch_Dat_Trans.csv");
		// shell_exec("mdb-export /home/forge/Wincc_batch.mdb Batch_Transaction > Batch_Transaction.csv");

		$files = [
			'Batch_Dat_Trans.csv',
			'Batch_Transaction.csv',
			'Customer_Master.csv',
		];

		$dbUsername = env('DB_USERNAME');
		$dbPassword = env('DB_PASSWORD');
		$dbDatabase = env('DB_DATABASE');

		DB::table('Trishul_Plant_1_Batch_Dat_Trans')->truncate();
		DB::table('Trishul_Plant_1_Batch_Transaction')->truncate();
		DB::table('Trishul_Plant_1_Customer_Master')->truncate();

		DB::statement('ALTER TABLE `Trishul_Plant_1_Batch_Dat_Trans` CHANGE `Batch_Date` `Batch_Date` TEXT  NULL');
		DB::statement('ALTER TABLE `Trishul_Plant_1_Batch_Transaction` CHANGE `Batch_Date` `Batch_Date` TEXT  NULL');

		DB::statement('ALTER TABLE `Trishul_Plant_1_Batch_Dat_Trans` CHANGE `Batch_Time` `Batch_Time` TEXT  NULL');
		DB::statement('ALTER TABLE `Trishul_Plant_1_Batch_Transaction` CHANGE `Batch_Time` `Batch_Time` TEXT  NULL');

		foreach($files as $file)
		{
			
			$command = "scp $source$file ".storage_path("$suffix$file");
	
			$this->line($command);

			shell_exec($command);

			$command = "mysqlimport --delete --fields-optionally-enclosed-by='\"' --ignore-lines=1 --fields-terminated-by=, --local -u $dbUsername -p$dbPassword $dbDatabase ".storage_path("$suffix$file");

			$this->line($command);

			// var_dump($command); die;

			shell_exec($command);

			shell_exec("rm ".storage_path("$suffix$file"));

			// die;
		}

		DB::statement("UPDATE Trishul_Plant_1_Batch_Dat_Trans SET Batch_Date = STR_TO_DATE(Batch_Date,'%m/%d/%Y %H:%i:%s');");
		DB::statement("UPDATE Trishul_Plant_1_Batch_Transaction SET Batch_Date = STR_TO_DATE(Batch_Date,'%m/%d/%Y %H:%i:%s');");
		DB::statement('ALTER TABLE `Trishul_Plant_1_Batch_Dat_Trans` CHANGE `Batch_Date` `Batch_Date` DATETIME  NULL;');
		DB::statement('ALTER TABLE `Trishul_Plant_1_Batch_Transaction` CHANGE `Batch_Date` `Batch_Date` DATETIME  NULL;');

		DB::statement("UPDATE Trishul_Plant_1_Batch_Dat_Trans SET Batch_Time = STR_TO_DATE(Batch_Time,'%m/%d/%Y %H:%i:%s');");
		DB::statement("UPDATE Trishul_Plant_1_Batch_Transaction SET Batch_Time = STR_TO_DATE(Batch_Time,'%m/%d/%Y %H:%i:%s');");
		DB::statement('ALTER TABLE `Trishul_Plant_1_Batch_Dat_Trans` CHANGE `Batch_Time` `Batch_Time` DATETIME  NULL;');
		DB::statement('ALTER TABLE `Trishul_Plant_1_Batch_Transaction` CHANGE `Batch_Time` `Batch_Time` DATETIME  NULL;');

	}

}
