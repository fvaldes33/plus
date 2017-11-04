<?php
namespace fvaldes33\plus\behaviors\entries;

use Craft;
use yii\base\Behavior;
use fvaldes33\plus\Plugin;
use fvaldes33\plus\behaviors\traits\AssetTrait;

class BaseEntryBehavior extends Behavior
{
    use AssetTrait;

    public function _test()
    {
        return 'this is a test';
    }
}