<?php
/**
 * Union plugin for Craft CMS 3.x
 *
 * UNION.co Plugin
 *
 * @link      union.co
 * @copyright Copyright (c) 2017 UNION
 */

namespace fvaldes\plus;

use Craft;
use craft\base\Plugin as BasePlugin;
use craft\base\Element;
use craft\elements\Entry;
use craft\base\ElementAction;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\console\Application as ConsoleApplication;
use craft\web\UrlManager;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterUrlRulesEvent;
use craft\events\ModelEvent;
use craft\events\RegisterElementActionsEvent;
use craft\elements\actions\View;
use craft\elements\db\ElementQuery;
use craft\events\PopulateElementEvent;

use yii\base\Event;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    UNION
 * @package   Union
 * @since     1.0.1
 *
 * @property  UnionService $union
 */
class Plugin extends BasePlugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * Union::$plugin
     *
     * @var Union
     */
    public static $plugin;

    // Public Methods
    // =========================================================================

    /**
     * Set our $plugin static property to this class so that it can be accessed via
     * Union::$plugin
     *
     * Called after the plugin class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        /**
         * Have to set at least this component to extend later
         * also comes with some base traits that can be used 
         * out of the box.
         */
        $this->setComponents([
            'behavior' => \fvaldes\plus\services\BehaviorService::class,
        ]);

        /**
         * Base plus twig extension
         */
        Craft::$app->view->twig->addExtension(new \fvaldes\plus\twigextensions\PlusTwigExtension());

        /**
         * Settings
         */
        $namespace = $this->getSettings()->namespace;
        $path = $this->getSettings()->folderPath;
        if (isset($namespace) && isset($path)) {
            $loader = require __DIR__ . '/../vendor/autoload.php';
            $loader->addPsr4($namespace, $path);
        
            $services = $this->getSettings()->services;
            if (isset($services)) {
                foreach ($services as $name => $service) {
                    $this->setComponents([
                        $name => $service,
                    ]);
                }
            }

            $controllerNamespace = $this->getSettings()->controllerNamespace;
            if (isset($controllerNamespace)) {
                $this->controllerNamespace = $controllerNamespace;
            }

            $twigextension = $this->getSettings()->twigextension;
            if ($twigextension) {
                Craft::$app->view->twig->addExtension(new $twigextension);    
            }
        }

        Event::on(
            ElementQuery::class,
            ElementQuery::EVENT_AFTER_POPULATE_ELEMENT,
            function(PopulateElementEvent $event) {
                // attach stuff here
                $this->behavior->register($event);
            }
        );

        // Register our variables
        $variables = $this->getSettings()->variables;
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) use($variables) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('plus', \fvaldes\plus\variables\PlusVariable::class);

                if (isset($variables)) {
                    foreach ($variables as $n => $v) {
                        $variable->set($n, $v);
                    }
                }
            }
        );

        // Do something after we're installed
        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    // We were just installed
                }
            }
        );

        Event::on(
            Entry::class,
            Element::EVENT_AFTER_SAVE,
            function (ModelEvent $event) {

            }
        );

        /**
         * Logging in Craft involves using one of the following methods:
         *
         * Craft::trace(): record a message to trace how a piece of code runs. This is mainly for development use.
         * Craft::info(): record a message that conveys some useful information.
         * Craft::warning(): record a warning message that indicates something unexpected has happened.
         * Craft::error(): record a fatal error that should be investigated as soon as possible.
         *
         * Unless `devMode` is on, only Craft::warning() & Craft::error() will log to `craft/storage/logs/web.log`
         *
         * It's recommended that you pass in the magic constant `__METHOD__` as the second parameter, which sets
         * the category to the method (prefixed with the fully qualified class name) where the constant appears.
         *
         * To enable the Yii debug toolbar, go to your user account in the AdminCP and check the
         * [] Show the debug toolbar on the front end & [] Show the debug toolbar on the Control Panel
         *
         * http://www.yiiframework.com/doc-2.0/guide-runtime-logging.html
         */
        Craft::info(
            Craft::t(
                'plus',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================
    protected function createSettingsModel()
    {
        return new Settings();
    }
}