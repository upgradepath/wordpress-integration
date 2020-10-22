<?php


namespace Upgradepath\Cron;

class CronjobScheduler
{

    /**
     * @var SendPluginInformationCronjob
     */
    private $sendPluginInformationCronjob;

    /**
     * CronScheduler constructor.
     */
    public function __construct()
    {
        $this->sendPluginInformationCronjob = new SendPluginInformationCronjob();
    }

    public function init()
    {
        $this->sendPluginInformationCronjob->init();
    }

    public function deactivate()
    {
        $this->sendPluginInformationCronjob->deactivate();
    }
}
