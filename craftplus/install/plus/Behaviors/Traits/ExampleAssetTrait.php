<?php
namespace CraftPlus\Behaviors\Traits;

use Exception;

trait ExampleAssetTrait
{
    public function _assetUrl($property, $transform = null, $default = null)
    {
        $model = $this->getOwner();

        $asset = ($model->{$property})->first();

        if($asset) {
            return $asset->getUrl($transform);
        }

        return $default;
    }

    public function _eAssetUrl($property, $transform = null, $default = null)
    {
        $model = $this->getOwner();

        try {
            $asset = $model->{$property}[0] ?? null;

            if($asset) {
                return $asset->getUrl($transform);
            }
        } catch(Exception $e) {
            //
        }

        return $default;
    }
}
