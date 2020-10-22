<?php


namespace Upgradepath\Cron;

use Upgradepath\Service\SyncService;

class SendPluginInformationCronjob extends Cronjob
{
    const HOOK_NAME = 'upgradepath_cj_send_plugin_information';

    const INTERVAL = 'daily';

    public function init()
    {
        if (!wp_next_scheduled(self::HOOK_NAME)) {
            wp_schedule_event(time(), self::INTERVAL, self::HOOK_NAME);
        }

        add_action(self::HOOK_NAME, [$this, 'handle']);
    }

    public function handle()
    {
        $apiToken = get_option('upgradepath-api-key');
        $apiClientToken = get_option('upgradepath-client-token');
        if (empty($apiToken) || empty($apiClientToken)) {
            return;
        }

        $syncService = new SyncService();
        $syncService->syncPlugins();
    }

    public function deactivate()
    {
        $timestamp = wp_next_scheduled(self::HOOK_NAME);
        wp_unschedule_event($timestamp, self::HOOK_NAME);
    }
}
