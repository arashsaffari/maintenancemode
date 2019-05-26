<?php namespace MaintenanceMode\Config;

use CodeIgniter\Config\BaseConfig;

class MaintenanceMode extends BaseConfig
{

    //--------------------------------------------------------------------
    // maintenance mode file path
    //--------------------------------------------------------------------
    // The amount of time, in seconds, that you want a login to last for.
    // Defaults to 30 days.
    //
    public $FilePath = WRITEPATH . 'framework/down';
}
