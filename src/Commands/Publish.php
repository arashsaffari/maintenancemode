<?php namespace CodeigniterExt\MaintenanceMode\Commands;

use Config\Autoload;
use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\BaseCommand;

class Publish extends BaseCommand
{
    
    protected $group        = 'Maintenance Mode';
    protected $name         = 'mm:publish';
    protected $description  = 'Publish 503 Error code view into the current application folder.';
    protected $usage        = 'mm:publish';
    protected $arguments    = [];
	protected $options 		= [];
    protected $sourcePath;

    //--------------------------------------------------------------------

    /**
     * Displays the help for the spark cli script itself.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $this->determineSourcePath();

        // Views
        if (CLI::prompt('Publish Views?', ['y', 'n']) == 'y')
        {
            $map = false;
            $map = directory_map($this->sourcePath . '/Views/errors/cli');
            $this->publishViews($map, 'errors/cli/');

            $map = false;
            $map = directory_map($this->sourcePath . '/Views/errors/html');
            $this->publishViews($map, 'errors/html/');
        }
    }

    protected function publishViews($map, $subfolder)
    {
        
        $prefix = '';

        foreach ($map as $key => $view)
        {
            if (is_array($view))
            {
                $oldPrefix = $prefix;
                $prefix .= $key;

                foreach ($view as $file)
                {
                    $this->publishView($file, $prefix, $subfolder);
                }

                $prefix = $oldPrefix;

                continue;
            }

            $this->publishView($view, $prefix, $subfolder);
        }
    }

    protected function publishView($view, string $prefix = '', string $subfolder = '')
    {
        $path = "{$this->sourcePath}/Views/{$subfolder}{$prefix}{$view}";
		$namespace = defined('APP_NAMESPACE') ? APP_NAMESPACE : 'App';

        $content = file_get_contents($path);

        $this->writeFile("Views/{$subfolder}{$prefix}{$view}", $content);
    }

    /**
     * Determines the current source path from which all other files are located.
     */
    protected function determineSourcePath()
    {
        $this->sourcePath = realpath(__DIR__ . '/../');

        if ($this->sourcePath == '/' || empty($this->sourcePath))
        {
            CLI::error('Unable to determine the correct source directory. Bailing.');
            exit();
        }
    }

    /**
     * Write a file, catching any exceptions and showing a
     * nicely formatted error.
     *
     * @param string $path
     * @param string $content
     */
    protected function writeFile(string $path, string $content)
    {
        $config = new Autoload();
        $appPath = $config->psr4[APP_NAMESPACE];

        $directory = dirname($appPath . $path);

        if (! is_dir($directory))
        {
            mkdir($directory);
        }

        try
        {
            write_file($appPath . $path, $content);
        }
        catch (\Exception $e)
        {
            $this->showError($e);
            exit();
        }

        $path = str_replace($appPath, '', $path);

        CLI::write(CLI::color('  created: ', 'green') . $path);
    }
}
