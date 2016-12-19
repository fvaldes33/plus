<?php namespace Craft;

class PlusPlugin extends BasePlugin
{

    // =========================================================================
    // PLUGIN INFO
    // =========================================================================
    public function getName()
    {
        return Craft::t('Plus');
    }

    public function getVersion()
    {
        return '1.0.5';
    }

    public function getSchemaVersion()
    {
        return '1.0.5';
    }

    public function getDeveloper()
    {
        return 'Franco Valdes';
    }

    public function getDeveloperUrl()
    {
        return 'https://github.com/fvaldes33';
    }

    public function getPluginUrl()
    {
        return 'https://github.com/fvaldes33/plus';
    }

    public function getDocumentationUrl()
    {           
        return $this->getPluginUrl() . '/blob/master/readme.md';
    }

    // =========================================================================
    // Events
    // =========================================================================
    public function onPopulateElement()
    {
        craft()->on('elements.onPopulateElement', function(Event $event) {
            craft()->plus->onPopulateElement($event);
        });
    }

    // =========================================================================
    // Twig Extensions
    // =========================================================================
    public function addTwigExtension()
    {
        Craft::import('plugins.plus.twigextensions.TwigExtensions');

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

        if (!IOHelper::folderExists(CRAFT_BASE_PATH . 'plus')){
            try {
                IOHelper::createFolder(CRAFT_BASE_PATH . 'plus');
                IOHelper::copyFolder(CRAFT_PLUGINS_PATH . 'plus/install/plus', CRAFT_BASE_PATH . 'plus/');
            } catch(Exception $e) {
                $error = $this->getName() . ' encountered an error while moving files.';
                craft()->userSession->setNotice($error);

                return false;
            }
        } else {
            $error = 'A "Plus" folder already exist in "'. CRAFT_BASE_PATH .'". We rather not overrite your stuff.';
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

        /* Load Plus */
        $loader = require CRAFT_PLUGINS_PATH . '/plus/vendor/autoload.php';
        $loader->addPsr4('Plus\\', CRAFT_BASE_PATH . 'plus');

        // Only handle behaviors outside of CP
        if (!craft()->request->isCpRequest()) {
            $this->onPopulateElement();    
        }
    }
}

/**
 * @return PlusService
 */
function plus()
{
    return Craft::app()->getComponent('plus');
}