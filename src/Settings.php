<?php
/**
 * Union plugin for Craft CMS 3.x
 *
 * UNION.co Plugin
 *
 * @link      union.co
 * @copyright Copyright (c) 2017 UNION
 */
namespace fvaldes33\plus;

use craft\base\Model;

/**
 * Element API plugin.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since  2.0
 */
class Settings extends Model
{
    /**
     * @var array The default endpoint configuration.
     */
    public $namespace;

    /**
     * @var array The default endpoint configuration.
     */
    public $folderPath;

    /**
     * @var array The default endpoint configuration.
     */
    public $controllerNamespace;

    /**
     * @var array The default endpoint configuration.
     */
    public $services = [];

    /**
     * @var array The endpoint configurations.
     */
    public $behaviors = [];

    /**
     * @var array The endpoint configurations.
     */
    public $variables = [];
    
    /**
     * @var array The endpoint configurations.
     */
    public $twigextension;
}