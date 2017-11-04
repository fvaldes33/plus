<?php
namespace fvaldes\plus\behaviors\entries;

use Craft;
use yii\base\Behavior;
use fvaldes\plus\Plugin;
use fvaldes\plus\behaviors\traits\AssetTrait;

class BaseEntryBehavior extends Behavior
{
    use AssetTrait;

    public function _test()
    {
        return 'this is a test';
    }
}