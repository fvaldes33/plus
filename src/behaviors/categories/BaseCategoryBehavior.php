<?php
namespace fvaldes\plus\behaviors\categories;

use Craft;
use yii\base\Behavior;
use fvaldes\plus\Plugin;
use fvaldes\plus\behaviors\traits\AssetTrait;

class BaseCategoryBehavior extends Behavior
{
    use AssetTrait;
    
    public function _test()
    {
        return 'this is a test';
    }
}