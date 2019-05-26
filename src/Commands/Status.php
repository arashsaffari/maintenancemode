<?php namespace CodeigniterExt\MaintenanceMode\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Status extends BaseCommand
{
	protected $group        = 'Maintenance Mode';
	protected $name         = 'mm:status';
	protected $description  = 'Display the maintenance mode status';
	protected $usage        = 'mm:status';
	protected $arguments    = [];
	protected $options 		= [];

	public function run(array $params)
	{
		$config = config( 'CodeigniterExt\\MaintenanceMode\\MaintenanceMode' );

		if (file_exists($config->FilePath.$config->FileName)){

			$data = json_decode(file_get_contents($config->FilePath.$config->FileName), true);
			
			CLI::write('');
			CLI::write('**** Application is already DOWN. ****', 'red');
			CLI::write('');
			
			//
			// echo keys and values in table
			// without allowed_ips
			//
			$thead = [
				"key",
				"value"
			];

			$tbody = array();

			foreach ($data as $key => $value) {
				
				switch ($key)
				{
					case "allowed_ips":
						break;
					case "time":
						
						$tbody[] = [$key, date('Y-m-d H:i:s', $value)];
						break;
					default:
						$tbody[] = [$key, $value];
				}
			}

			CLI::table($tbody, $thead);


			//
			// echo allowed_ips in table
			//
			$thead = ["allowed ips"];

			$tbody = array();

			foreach ($data['allowed_ips'] as $ip) {
				$tbody[] = [$ip];
			}

			CLI::table($tbody, $thead);
			
			CLI::write('');

			
		}else{
			CLI::write('');
			CLI::write('**** Application is already live. ****', 'green');
			CLI::write('');
		}
	}
}
