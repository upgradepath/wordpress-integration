<?php


namespace Upgradepath\Service;

use Upgradepath\Api\ApiService;

class SyncService
{

    /**
     * @var ApiService
     */
    private $apiService;


    /**
     * SyncService constructor.
     */
    public function __construct()
    {
        $this->apiService = new ApiService();
    }

    public function syncPlugins()
    {
        $apiToken = get_option('upgradepath-api-key');
        $apiClientToken = get_option('upgradepath-client-token');
        if (empty($apiToken) || empty($apiClientToken)) {
            return;
        }
        $plugins = get_plugins();
        $software = [];
        foreach ($plugins as $pluginKey => $pluginInformation) {
            array_push($software, [
                'software_key' => $pluginInformation['TextDomain'],
                'tag' => $pluginInformation['Version'],
            ]);
        }
        $apiService = new ApiService();
        $response = $apiService->sync($apiToken, $apiClientToken, $software);
    }
}
