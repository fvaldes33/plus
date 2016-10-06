<?php
namespace Craft;

use CraftPlus;

class CraftPlusService extends BaseApplicationComponent
{
    private $classes = [];
    protected static $baseBehaviorName = 'CraftPlus\\Behaviors\\';

    public function variables()
    {
        if (isset($this->classes['CraftPlusVariable'])){
            return $this->classes['CraftPlusVariable'];
        } else {
            return $this->classes['CraftPlusVariable'] = new CraftPlusVariable;
        }
    }

    /**
     * Log Data
     *
     * @return void
     */
    public function log($key, $data)
    {
        $logger = new CraftPlus\Services\LogService;
        $logger->write($key, $data);
    }

    /**
     * On Populate Element Event Trigger
     *
     * @param $event EventModal
     *
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
                    $baseBehaviorName = static::$baseBehaviorName . 'Entries\BaseCategoryBehavior';

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
}