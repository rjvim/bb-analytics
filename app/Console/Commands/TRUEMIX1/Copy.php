<?php namespace App\Console\Commands\TRUEMIX1;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use DB;

class Copy extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'bb:truemix1_copy';

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
		$localPathPrefix = "/home/forge/TRUEMIX/";
		// $localPathPrefix = "/Users/rajiv/Desktop/";

		$command = "sed -i -e 's/Adm2_Target2 /Adm2_Target2/g' $localPathPrefix"."Batch_Dat_Trans.csv";
		$this->line($command);
		shell_exec($command);

		$command = "ln -sf $localPathPrefix"."Batch_Dat_Trans.csv $localPathPrefix"."TRUEMIX1_Batch_Dat_Trans.csv";

		$this->line($command);
		shell_exec($command);

		$command = "ln -sf $localPathPrefix"."Batch_Transactions.csv $localPathPrefix"."TRUEMIX1_Batch_Transaction.csv";

		$this->line($command);
		shell_exec($command);

		$files = [
			'TRUEMIX1_Batch_Dat_Trans.csv',
			'TRUEMIX1_Batch_Transaction.csv'
		];

		$dbUsername = env('DB_USERNAME');
		$dbPassword = env('DB_PASSWORD');
		$dbDatabase = env('DB_DATABASE');

		DB::table('TRUEMIX1_Batch_Dat_Trans')->truncate();
		DB::table('TRUEMIX1_Batch_Transaction')->truncate();

		/**
			"mysqlimport --delete --fields-optionally-enclosed-by='\"' --ignore-lines=1 --fields-terminated-by=, --local -u $dbUsername -p$dbPassword $dbDatabase "."$localPathPrefix$file";
		**/

		$file = 'TRUEMIX1_Batch_Dat_Trans.csv';
		$command = "mysqlimport --ignore-lines=1 --fields-terminated-by=, --local -u $dbUsername -p$dbPassword $dbDatabase "."$localPathPrefix$file";

		$this->line($command);
		shell_exec($command);

		$file = 'TRUEMIX1_Batch_Transaction.csv';
		$command = "mysqlimport --ignore-lines=1 --fields-terminated-by=, --local -u $dbUsername -p$dbPassword $dbDatabase "."$localPathPrefix$file";

		$this->line($command);
		shell_exec($command);


		$command = "rm $localPathPrefix"."TRUEMIX1_Batch_Dat_Trans.csv";

		$this->line($command);
		shell_exec($command);

		$command = "rm $localPathPrefix"."TRUEMIX1_Batch_Transaction.csv";

		$this->line($command);
		shell_exec($command);


		shell_exec("ssh forge@139.59.7.176 'php buildbuy.in/current/artisan bb:get_365_data'");


	}

}
