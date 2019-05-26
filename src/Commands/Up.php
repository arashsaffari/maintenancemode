<?php namespace CodeigniterExt\MaintenanceMode\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Up extends BaseCommand
{
	protected $group        = 'Maintenance Mode';
	protected $name         = 'mm:up';
	protected $description  = 'Bring the application out of maintenance mode';
	protected $usage        = 'mm:up';
	protected $arguments    = [];
	protected $options 		= [];

	public function run(array $params)
	{
		$config = config( 'CodeigniterExt\\MaintenanceMode\\MaintenanceMode' );

		//
		//delete the file with json content
		//
		@unlink($config->FilePath . $config->FileName);
		
		CLI::write('');
		CLI::write('**** Application is now live. ****', 'green');
		CLI::write('');
	}
}
