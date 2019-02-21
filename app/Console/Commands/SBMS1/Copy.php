<?php namespace App\Console\Commands\SBMS1;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use DB;

class Copy extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'bb:sbms1_copy';

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
		$localPathPrefix = "/home/forge/SBMS1/";
		// $localPathPrefix = "/Users/rajiv/Desktop/";

		$command = "sed -i -e 's/Adm2_Target2 /Adm2_Target2/g' $localPathPrefix"."Batch_Dat_Trans.csv";
		$this->line($command);
		shell_exec($command);

		$command = "ln -sf $localPathPrefix"."Batch_Dat_Trans.csv $localPathPrefix"."SBMS1_Batch_Dat_Trans.csv";

		$this->line($command);
		shell_exec($command);

		$command = "ln -sf $localPathPrefix"."Batch_Transaction.csv $localPathPrefix"."SBMS1_Batch_Transaction.csv";

		$this->line($command);
		shell_exec($command);

		$files = [
			'SBMS1_Batch_Dat_Trans.csv',
			'SBMS1_Batch_Transaction.csv'
		];

		$dbUsername = env('DB_USERNAME');
		$dbPassword = env('DB_PASSWORD');
		$dbDatabase = env('DB_DATABASE');

		DB::table('SBMS1_Batch_Dat_Trans')->truncate();
		DB::table('SBMS1_Batch_Transaction')->truncate();

		foreach($files as $file)
		{
			
			$command = "mysqlimport --ignore-lines=1 --fields-terminated-by=, --local -u $dbUsername -p$dbPassword $dbDatabase "."$localPathPrefix$file";

			$this->line($command);

			// var_dump($command); die;

			shell_exec($command);

			// shell_exec("rm ".storage_path("$suffix$file"));

			// die;
		}


		$command = "rm $localPathPrefix"."SBMS1_Batch_Dat_Trans.csv";

		$this->line($command);
		shell_exec($command);

		$command = "rm $localPathPrefix"."SBMS1_Batch_Transaction.csv";

		$this->line($command);
		shell_exec($command);


		shell_exec("ssh forge@139.59.7.176 'php buildbuy.in/current/artisan bb:get_365_data'");


	}

}
