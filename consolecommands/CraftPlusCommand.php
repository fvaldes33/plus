<?php namespace Craft;

class CraftPlusCommand extends BaseCommand
{
    private $elementTypeMap = [
        'Entry' => 'Entries',
        'Category' => 'Categories',
        'MatrixBlock' => 'MatrixBlocks',
        'GlobalSet' => 'Globals'
    ];

    public function actionCreateBehavior($name, $type = null)
    {
        $behaviorName = $name . 'Behavior';

        if (isset($type) && array_key_exists($type, $this->elementTypeMap)) {
            $behaviorType = $this->elementTypeMap[$type];
        } else {
            echo 'Type does not exist in ';
            echo print_r($this->elementTypeMap, true);
            exit;
        }

        return craft()->craftPlus->createBehavior($behaviorName, $behaviorType);

    }
}