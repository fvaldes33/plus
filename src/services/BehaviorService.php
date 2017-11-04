<?php
/**
 * Union plugin for Craft CMS 3.x
 *
 * UNION.co Plugin
 *
 * @link      union.co
 * @copyright Copyright (c) 2017 UNION
 */
namespace fvaldes\plus\services;

use Craft;
use craft\base\Component;
use fvaldes\plus\Plugin;

/**
 * Union Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    UNION
 * @package   Union
 * @since     1.0.1
 */
class BehaviorService extends Component
{   
    /**
     * @var behaviors array
     */
    protected static $baseBehaviorNamespace = 'fvaldes\\plus\\behaviors\\';

    /**
     * @var behaviors array
     */
    protected $extraBehaviorNamespace;

    /**
     *  Init new behavior service
     *
     * @return void
     */
    public function __construct()
    {
        $namespace = Plugin::$plugin->getSettings()->namespace;
        $path = Plugin::$plugin->getSettings()->folderPath;
        
        if (isset($namespace) && isset($path)) {
            $this->extraBehaviorNamespace = $namespace . 'behaviors\\';
        }
    }

    /**
     *  Register all behaviors
     *  Usage | Union::$plugin->union->exampleService()
     *
     *  @param event array
     *  @return mixed
     */
    public function register($event)
    {
        $element = $event->element;
        $elementType = $element->refHandle();

        switch ($elementType) {
            case 'asset':
                break;

            case 'category':
                $behaviorBaseClass = static::$baseBehaviorNamespace . 'categories\\BaseCategoryBehavior';
                $behaviorClassName = static::$baseBehaviorNamespace . 'categories\\' . ucFirst($element->group->handle) . 'Behavior';

                //extra 
                $extraBehaviorClassName = $this->extraBehaviorNamespace . 'categories\\' . ucFirst($element->group->handle) . 'Behavior';

                if (class_exists($extraBehaviorClassName)) {
                    $element->attachBehavior(uniqid('categories.' . $element->group->handle), new $extraBehaviorClassName);
                } else if (class_exists($behaviorClassName)) {
                    $element->attachBehavior(uniqid('categories.' . $element->group->handle), new $behaviorClassName);
                } else {
                    $element->attachBehavior('categories.base', new $behaviorBaseClass);
                }
                break;

            case 'entry':
                $section = $element->section;
                $behaviorBaseClass = static::$baseBehaviorNamespace . 'entries\\BaseEntryBehavior';
                $behaviorClassName = static::$baseBehaviorNamespace . 'entries\\' . ucFirst($section->handle) . 'Behavior';

                //extra 
                $extraBehaviorClassName = $this->extraBehaviorNamespace . 'entries\\' . ucFirst($section->handle) . 'Behavior';

                if (class_exists($extraBehaviorClassName)) {
                    $element->attachBehavior(uniqid('entries.' . $section->handle), new $extraBehaviorClassName);
                } else if (class_exists($behaviorClassName)) {
                    $element->attachBehavior(uniqid('entries.' . $section->handle), new $behaviorClassName);
                } else {
                    $element->attachBehavior('entries.base', new $behaviorBaseClass);
                }
                break;

            case 'globalset':
                $behaviorBaseClass = static::$baseBehaviorNamespace . 'globals\\BaseGlobalBehavior';
                $behaviorClassName = static::$baseBehaviorNamespace . 'globals\\' . ucFirst($element->handle) . 'Behavior';

                //extra 
                $extraBehaviorClassName = $this->extraBehaviorNamespace . 'globals\\' . ucFirst($element->handle) . 'Behavior';

                if (class_exists($extraBehaviorClassName)) {
                    $element->attachBehavior(uniqid('globalset.' . $element->handle), new $extraBehaviorClassName);
                } else if (class_exists($behaviorClassName)) {
                    $element->attachBehavior(uniqid('globalset.' . $element->handle), new $behaviorClassName);
                } else {
                    $element->attachBehavior('globalset.base', new $behaviorBaseClass);
                }
                break;

            case 'matrixblock':
                $field = Craft::$app->getFields()->getFieldById($element->fieldId);
                $behaviorBaseClass = static::$baseBehaviorNamespace . 'matrixblocks\\BaseMatrixBehavior';
                $behaviorClassName = static::$baseBehaviorNamespace . 'matrixblocks\\' . ucFirst($field->handle) . 'Behavior';

                //extra 
                $extraBehaviorClassName = $this->extraBehaviorNamespace . 'matrixblocks\\' . ucFirst($field->handle) . 'Behavior';

                if (class_exists($extraBehaviorClassName)) {
                    $element->attachBehavior(uniqid('matrixblocks.' . $field->handle), new $extraBehaviorClassName);
                } else if (class_exists($behaviorClassName)) {
                    $element->attachBehavior(uniqid('matrixblocks.' . $field->handle), new $behaviorClassName);
                } else {
                    $element->attachBehavior('matrixblocks.base', new $behaviorBaseClass);
                }
                break;

            case 'tag':
                break;

            case 'user':
                break;
        }
    }
}