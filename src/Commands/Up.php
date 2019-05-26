<?php namespace MaintenanceMode\Commands;

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
		@unlink(config( 'MaintenanceMode\\MaintenanceMode' )->FilePath);
		CLI::write('');
		CLI::write('**** Application is now live. ****', 'green');
		CLI::write('');
	}
}
