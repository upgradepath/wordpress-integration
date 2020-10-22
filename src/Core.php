<?php


namespace Upgradepath;

use Upgradepath\Admin\SettingsPage;
use Upgradepath\Cron\CronjobScheduler;
use Upgradepath\Service\SyncService;

class Core
{
    const DEFAULT_UPGRADEPATH_API_URL = 'https://upgradepath.io/api/';

    const OPTIONS = [
        'upgradepath-api-key',
        'upgradepath-client-token',
    ];

    /**
     * @var string $file
     */
    private $file;

    /**
     * @var CronjobScheduler
     */
    private $cronScheduler;

    /**
     * Core constructor.
     * @param $file
     */
    public function __construct(string $file)
    {
        $this->cronScheduler = new CronjobScheduler();
        $this->file = $file;
    }

    public function init()
    {
        register_deactivation_hook($this->file, [$this, 'deactivate']);
        register_uninstall_hook($this->file, [__CLASS__, 'uninstall']);

        if (!defined('UPGRADEPATH_API_URL')) {
            define('UPGRADEPATH_API_URL', self::DEFAULT_UPGRADEPATH_API_URL);
        }

        $this->cronScheduler->init();

        if (is_admin()) {
            $settingsPage = new SettingsPage();
            $settingsPage->init();
        }
        add_action('upgrader_process_complete', [$this, 'updateHandler']);
    }

    /**
     * Plugin deactivation handler
     */
    public function deactivate()
    {
        $this->cronScheduler->deactivate();
    }

    /**
     * Plugin uninstallation handler
     */
    public static function uninstall()
    {
        foreach (self::OPTIONS as $option) {
            delete_option($option);
        }
    }

    public function updateHandler()
    {
        $syncService = new SyncService();
        $syncService->syncPlugins();
    }
}
