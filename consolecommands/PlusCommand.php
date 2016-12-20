<?php namespace Craft;

/**
 * PlusCommand is helper class to quickly create behaviors from the command line.
 *
 * @author    Franco Valdes https://github.com/fvaldes33
 * @since     1.0
 */
class PlusCommand extends BaseCommand
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
            echo 'Element Type does not exist in ';
            echo print_r($this->elementTypeMap, true);
            exit;
        }

        craft()->craftPlus->createBehavior($behaviorName, $behaviorType);
    }
}