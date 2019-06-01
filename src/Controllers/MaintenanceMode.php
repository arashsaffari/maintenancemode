<?php namespace CodeigniterExt\MaintenanceMode\Controllers;

use CodeIgniter\Controller;
use Config\Services;
use CodeigniterExt\MaintenanceMode\Libraries\IpUtils;
use CodeigniterExt\MaintenanceMode\Exceptions\ServiceUnavailableException;

class MaintenanceMode extends Controller
{
    private $config;

    public function __construct(){}

    public static function getConfig()
    {
        $config = config( 'MaintenanceMode' );
        
        if (empty($config)){
            
            $config = new \CodeigniterExt\MaintenanceMode\Config\MaintenanceMode();
        }

        return $config;
    }

    /**
     * 
     */
    public static function check()
    {

        //
        // if request is from CLI
        //
        if(is_cli()) return true;

        $config = (new self)->getConfig();

        $donwFilePath = $config->FilePath . $config->FileName;

        //
        // if donw file does not exist app should keep running
        //
        if (!file_exists($donwFilePath)) {
            return true;
        }


        //
        // get all json data from donw file
        //
        $data = json_decode(file_get_contents($donwFilePath), true);

        
        //
        // if request ip was entered in allowed_ips
        // the app should continue running
        //
        $lib = new IpUtils();
        if ($lib->checkIp(Services::request()->getIPAddress(), $data["allowed_ips"])) {
            return true;
        }

        //
        // if user's browser has been used the cookie pass
        // the app should continue running
        //
        helper('cookie');
        $cookieName = get_cookie($data["cookie_name"]);

        if($cookieName == $data["cookie_name"]){
            return true;
        }

        throw ServiceUnavailableException::forServerDow($data["message"]);
    }
}
