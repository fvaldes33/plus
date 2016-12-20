<?php
namespace Craft;

use Plus;

class PlusService extends BaseApplicationComponent
{
    private $services = [];
    protected static $baseServicePath = 'Plus\\Services\\';
    protected static $baseBehaviorName = 'Plus\\Behaviors\\';

    /**
     * Magic Method to __get and return a class
     * @param $name [classname]
     * @return class 
     */
    public function __get(string $name)
    {
        $calledService = static::$baseServicePath . ucfirst($name) . 'Service';
        
        if (isset($this->services[$name])) {
            return $this->services[$name];
        } else {
            return $this->services[$name] = new $calledService;
        }

        return false;
    }

    /**
     * Magic Method to __get and return a class
     * @param $name [classname]
     * @return class 
     */
    public function __call(string $name, array $params)
    {
        $calledService = static::$baseServicePath . ucfirst($name) . 'Service';
        
        if (isset($this->services[$name])) {
            return $this->services[$name];
        } else {
            return $this->services[$name] = new $calledService;
        }

        return false;        
    }
    
    /**
     * Create Behaviors
     *
     * @param $name BehaviorName
     * @param $type ElementType
     * @return bool
     */
    public function createBehavior($name, $type)
    {
        $behaviorFile = $this->behaviorPath($type, $name);
        
        if (!IOHelper::fileExists($behaviorFile)) {
            $file = IOHelper::createFile($behaviorFile);

            if ($file) {
                if ( IOHelper::writeToFile($behaviorFile, $this->blankBehavior($name, $type))) {
                    echo 'Behavior ' . $name . ' for ' . $type . ' created!';
                    exit;
                }
            }

        } else {
            echo 'File ' . $name . ' in ' . $type . ' Already Exists... Exit';
            exit;
        }
    
    }

    /**
     * On Populate Element Event Trigger
     *
     * @param $event EventModal
     * @return void
     */
    public function onPopulateElement(Event $event)
    {
        $element = $event->params['element'];

        switch ($element->elementType) {
            case 'Asset':
            break;

            case 'Category':
                $behaviorAdded = false;

                $categoryGroup = craft()->categories->getGroupById($element->groupId);
                $behaviorClassName = static::$baseBehaviorName . 'Categories\\' . ucFirst($categoryGroup->handle) . 'Behavior';

                if (class_exists($behaviorClassName)) {
                    $element->attachBehavior(uniqid('Categories.' . $categoryGroup->handle), new $behaviorClassName);
                    $behaviorAdded = true;
                }

                if (!$behaviorAdded) {
                    $baseBehaviorName = static::$baseBehaviorName . 'Categories\BaseCategoryBehavior';

                    $element->attachBehavior('Categories.Base', new $baseBehaviorName);    
                }
            break;

            case 'Entry':
                $behaviorAdded = false;

                $section = craft()->sections->getSectionById($element->sectionId);
                $behaviorClassName = static::$baseBehaviorName . 'Entries\\' . ucFirst($section->handle) . 'Behavior';

                if (class_exists($behaviorClassName)) {
                    $element->attachBehavior(uniqid('Entries.' . $section->handle), new $behaviorClassName);
                    $behaviorAdded = true;
                }

                if (!$behaviorAdded) {
                    $baseBehaviorName = static::$baseBehaviorName . 'Entries\BaseEntryBehavior';

                    $element->attachBehavior('Entries.Base', new $baseBehaviorName);    
                }
                
            break;

            case 'GlobalSet':
                $behaviorAdded = false;
                $behaviorClassName = static::$baseBehaviorName . 'Globals\\' . ucFirst($element->handle) . 'Behavior';

                if (class_exists($behaviorClassName)) {
                    $element->attachBehavior(uniqid('Globals.' . $globalSet->handle), new $behaviorClassName);
                    $behaviorAdded = true;
                }

                if (!$behaviorAdded) {
                    $baseBehaviorName = static::$baseBehaviorName . 'Globals\BaseGlobalsBehavior';

                    $element->attachBehavior('Globals.Base', new $baseBehaviorName);    
                }
            break;

            case 'MatrixBlock':
                $behaviorAdded = false;

                $matrixBlock = craft()->matrix->getBlockTypeById($element->typeId);
                $field = craft()->fields->getFieldById($matrixBlock->fieldId);                
                $behaviorClassName = static::$baseBehaviorName . 'MatrixBlocks\\' . ucFirst($field->handle) . 'Behavior';

                if (class_exists($behaviorClassName)) {
                    $element->attachBehavior(uniqid('MatrixBlocks.' . $field->handle), new $behaviorClassName);
                    $behaviorAdded = true;
                }

                if (!$behaviorAdded) {
                    $baseBehaviorName = static::$baseBehaviorName . 'MatrixBlocks\BaseMatrixBlocksBehavior';

                    $element->attachBehavior('MatrixBlocks.Base', new $baseBehaviorName);    
                }
            break;
        }
    }

    public function behaviorPath($dir, $file)
    {
        return CRAFT_BASE_PATH . 'config/plus/Behaviors/' . $dir . '/' . $file . '.php';
    }

    public function blankBehavior($name, $type)
    {
        $baseMap = [
            'Entries' => 'BaseEntryBehavior',
            'Categories' => 'BaseCategoryBehavior',
            'Globals' => 'BaseGlobalsBehavior',
            'MatrixBlocks' => 'BaseMatrixBlocksBehavior'
        ];

        $content = "<?php 
namespace Plus\Behaviors\\". $type . "

use CBehavior;
use Craft;
use Craft\ElementType;

use function Craft\craft;

class " . $name . " extends " . $baseMap[$type] . "
{
    
}";

        return $content;
    }
}