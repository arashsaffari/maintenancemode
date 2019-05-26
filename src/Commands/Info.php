<?php namespace MaintenanceMode\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Info extends BaseCommand
{
	protected $group        = 'Maintenance Mode';
	protected $name         = 'mm:info';
	protected $description  = 'Display the maintenance mode info';
	protected $usage        = 'mm:info';
	protected $arguments    = [];
	protected $options 		= [];

	public function run(array $params)
	{
		if (file_exists(config( 'MaintenanceMode\\MaintenanceMode' )->FilePath)){

			$data = json_decode(file_get_contents(config( 'MaintenanceMode\\MaintenanceMode' )->FilePath), true);
			
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
