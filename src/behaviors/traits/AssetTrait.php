<?php
namespace fvaldes33\plus\behaviors\traits;

trait AssetTrait
{
    /**
     * Gets an asset for the resource along with its transform
     *
     * @param $property string asset handle
     * @param $transform mixed named transform or string object '{width: 250}'
     * @return string url
     */
    public function _assetUrl($property, $transform = null, $default = null)
    {
        $model = $this->owner;

        $asset = $model->{$property}->one();

        if($asset) {
            return $asset->getUrl($transform);
        }

        return $default;
    }

    /**
     * Gets asset for the an eagerly loaded resource along with its transform
     *
     * @param $property string asset handle
     * @param $transform mixed named transform or string object '{width: 250}'
     * @return string url
     */
    public function _eAssetUrl($property, $transform = null, $default = null)
    {
        $model = $this->owner;

        $asset = $model->{$property}[0] ?? null;

        if($asset) {
            return $asset->getUrl($transform);
        }

        return $default;
    }
}
