<?php namespace MaintenanceMode\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Down extends BaseCommand
{
	protected $group        = 'Maintenance Mode';
	protected $name         = 'mm:down';
	protected $description  = 'Put the application into maintenance mode';
	protected $usage        = 'mm:down';
	protected $arguments    = [];
	protected $options 		= [];

	public function run(array $params)
	{
		if (! file_exists(config( 'MaintenanceMode\\MaintenanceMode' )->FilePath)) {
			
			$message = CLI::prompt("Message");
			$ips_str = CLI::prompt("Allowed ips [example: 0.0.0.0 127.0.0.1]");

			$ips_array = explode(" ", $ips_str);

			file_put_contents(
				config( 'MaintenanceMode\\MaintenanceMode' )->FilePath,
				json_encode([
					"time"			=> strtotime("now"),
					"message" 		=> $message,
					"cookie_name"	=> $this->randomhash(8),
					"allowed_ips"	=> $ips_array
				], JSON_PRETTY_PRINT)
			);

			CLI::write('');
			CLI::write('**** Application is now DOWN. ****', 'red');
			CLI::write('');
		}else{
			CLI::write('');
			CLI::write('**** Application is already DOWN. ****', 'red');
			CLI::write('');
		}
	}

	function randomhash($len = 8){
		$seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'); // and any other characters
		shuffle($seed); // probably optional since array_is randomized; this may be redundant
		$rand = '';
		foreach (array_rand($seed, $len) as $k){
			$rand .= $seed[$k];
		}
		return $rand;
	  }
}
