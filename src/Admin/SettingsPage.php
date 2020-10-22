<?php

namespace Upgradepath\Admin;

use Upgradepath\Api\ApiService;
use Upgradepath\Service\SyncService;

class SettingsPage
{

    /**
     * @var string $newApiKey
     */
    private $newApiKey;

    const PAGE_SLUG = 'upgradepath';

    public function __construct()
    {
    }

    /**
     * @return string
     */
    private function getNewApiKey()
    {
        return $this->newApiKey;
    }

    /**
     * @param string $newApiKey
     */
    private function setNewApiKey(string $newApiKey)
    {
        $newApiKey = trim($newApiKey);
        if ($newApiKey === '') {
            $this->newApiKey = null;
        } else {
            $this->newApiKey = $newApiKey;
        }
    }

    private function clearNewApiKey()
    {
        $this->newApiKey = null;
    }

    public function init()
    {
        add_action('admin_menu', [$this, 'registerMenuItemAndSettingsPage']);
        add_action('admin_init', [$this, 'handlePostRequest']);
        add_action('admin_init', [$this, 'registerSettingsPageContent']);
    }

    public function registerMenuItemAndSettingsPage()
    {
        add_options_page(
            'UpgradePath Settings', // page_title
            esc_html__('UpgradePath', 'upgradepath'), // menu_title
            'manage_options', // capability
            'upgradepath', // menu_slug
            [$this, 'renderSettingsPage'] // function
        );
    }

    public function handlePostRequest()
    {
        if (empty($_POST) || !isset($_GET['page']) || $_GET['page'] !== self::PAGE_SLUG) {
            return;
        }
        check_admin_referer(self::PAGE_SLUG);
        if (isset($_POST['upgradepath-save'])) {
            $this->handleSavePostRequest();
        } elseif (isset($_POST['upgradepath-delete'])) {
            $this->handleDeletePostRequest();
        } elseif (isset($_POST['upgradepath-sync'])) {
            $this->handleSyncPostRequest();
        }
    }

    public function handleSavePostRequest()
    {
        if (empty($_POST['upgradepath-new_api_key'])) {
            return;
        }
        $this->setNewApiKey(sanitize_text_field($_POST['upgradepath-new_api_key']));

        $apiService = new ApiService();
        $response = $apiService->register($this->getNewApiKey());
        if (isset($response->token) && isset($response->client_token)) {
            update_option('upgradepath-api-key', $response->token);
            update_option('upgradepath-client-token', $response->client_token);
            $this->clearNewApiKey();
            $syncService = new SyncService();
            $syncService->syncPlugins();
        } else {
            add_settings_error(
                'upgradepath-temp-api-key',
                'dropin',
                esc_html__('An unknown error occurred during the registration of this wordpress instance. Please contact the UpgradePath support team.', 'upgradepath'),
                'error'
            );
        }
    }

    public function handleDeletePostRequest()
    {
        delete_option('upgradepath-api-key');
        delete_option('upgradepath-client-token');
    }

    public function handleSyncPostRequest()
    {
        $syncService = new SyncService();
        $syncService->syncPlugins();
    }

    public function renderSettingsPage()
    {
        echo '
        <div class="wrap">
            <h2>'.esc_html__('Upgradepath Wordpress Integration', 'upgradepath') .'</h2>
            <p></p>

            <form method="post" action="">';
        wp_nonce_field(self::PAGE_SLUG);
        do_settings_sections('upgradepath-admin');
        submit_button(__('Save'), 'primary', 'upgradepath-save', false, ['style' => 'margin-right: 10px;']);
        if ($this->isSetUp()) {
            submit_button(__('Sync manually', 'upgradepath'), 'secondary', 'upgradepath-sync', false, ['style' => 'margin-right: 10px;']);
            submit_button(__('Delete API key', 'upgradepath'), 'delete', 'upgradepath-delete', false, ['style' => 'margin-right: 10px;']);
        }
        echo '
            </form>
        </div>
		';
    }

    public function isSetUp()
    {
        return !empty(get_option('upgradepath-api-key'));
    }

    public function registerSettingsPageContent()
    {
        add_settings_section(
            'upgradepath_setting_section', // id
            'Settings', // title
            [$this, 'renderSettingsSection'], // callback
            'upgradepath-admin' // page
        );
        if ($this->isSetUp()) {
            add_settings_field(
                'api_key', // id
                esc_html__('Active API key', 'upgradepath'), // title
                [$this, 'renderFieldApiKey'], // callback
                'upgradepath-admin', // page
                'upgradepath_setting_section' // section
            );
        }
        add_settings_field(
            'upgradepath-new_api_key', // id
            esc_html__('New API key', 'upgradepath'), // title
            [$this, 'renderFieldNewApiKey'], // callback
            'upgradepath-admin', // page
            'upgradepath_setting_section' // section
        );
    }

    public function renderSettingsSection()
    {
        _e('Please register at <a href="https://upgradepath.io">upgradepath.io</a> and create an wordpress integration. You will receive an API key which you can copy into the "New API key" field. Make sure that you Wordpress instance can access the internet. On save, the plugin will register this wordpress instance and starts sending plugin meta information to UpgradePath. If you need help connecting your Wordpress instance with UpgradePath feel free to connect our support team.', 'upgradepath');
    }

    public function renderFieldApiKey()
    {
        printf(
            '<input class="regular-text" type="text" name="upgradepath-api-key" readonly="readonly" id="api_key" value="%s">',
            esc_attr(get_option('upgradepath-api-key'))
        );
    }

    public function renderFieldNewApiKey()
    {
        printf(
            '<input class="regular-text" type="text" name="upgradepath-new_api_key" id="upgradepath-new_api_key" value="%s">',
            $this->getNewApiKey() !== null ? esc_attr($this->getNewApiKey()) : ''
        );
    }
}
