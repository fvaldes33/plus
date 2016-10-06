<?php namespace Craft;

class CraftPlusPlugin extends BasePlugin
{

    // =========================================================================
    // PLUGIN INFO
    // =========================================================================
    public function getName()
    {
        return Craft::t('Craft Plus');
    }

    public function getVersion()
    {
        return '1.0.0';
    }

    public function getSchemaVersion()
    {
        return '1.0.0';
    }

    public function getDeveloper()
    {
        return 'Franco Valdes | Union';
    }

    public function getDeveloperUrl()
    {
        return 'http://union.co';
    }

    public function getPluginUrl()
    {
        return 'http://union.co';
    }

    public function getDocumentationUrl()
    {           
        return $this->getPluginUrl() . '/hidden/craft-plus/README.md';
    }

    // =========================================================================
    // Events
    // =========================================================================
    public function onPopulateElement()
    {
        craft()->on('elements.onPopulateElement', function(Event $event) {
            craft()->craftPlus->onPopulateElement($event);
        });
    }

    // =========================================================================
    // Twig Extensions
    // =========================================================================
    public function addTwigExtension()
    {
        Craft::import('plugins.craftplus.twigextensions.TwigExtensions');

        return new TwigExtensions();
    }


    // =========================================================================
    // Before Install
    // =========================================================================
    public function onBeforeInstall()
    {   
        // Check for php70 or greater
        if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID < 70000) {
            $error = $this->getName() . ' requires PHP 7.0.0 or later, but you\'re running '.PHP_VERSION.'.';
            craft()->userSession->setNotice($error);

            return false;
        }

        if (!IOHelper::folderExists(CRAFT_BASE_PATH . 'config/plus')){
            try {
                IOHelper::createFolder(CRAFT_BASE_PATH . 'config/plus');
                IOHelper::copyFolder(CRAFT_PLUGINS_PATH . 'craftplus/install/plus', CRAFT_BASE_PATH . 'config/plus');
            } catch(Exception $e) {
                $error = $this->getName() . ' encountered an error while moving files.';
                craft()->userSession->setNotice($error);

                return false;
            }
        } else {
            $error = 'A "Plus" folder already exist in "'. CRAFT_BASE_PATH .'/config". We rather not overrite your stuff.';
            craft()->userSession->setNotice($error);

            return true;
        }

        return true;
    }

    // =========================================================================
    // Init
    // =========================================================================
    public function init()
    {
        parent::init();

        // Only handle behaviors outside of CP
        if (!craft()->request->isCpRequest()) {
            $loader = require CRAFT_PLUGINS_PATH . '/craftplus/vendor/autoload.php';
            $loader->addPsr4('CraftPlus\\', CRAFT_BASE_PATH . 'config/plus');
            
            $this->onPopulateElement();    
        }
    }
}