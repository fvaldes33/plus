<?php
namespace Craft;

class CraftPlusVariable
{
    private $classes = [];
    protected $baseUtil = 'CraftPlus\\Util\\';
    protected $baseService = 'CraftPlus\\Services\\';

    public function __call($name, $params = null)
    {
        return $this->checkService($name) ?? null;
    }

    private function checkService($name)
    {
        $calledService = $this->baseService . ucfirst($name) . 'Service';

        if (isset($this->classes[$calledService])) {
            return $this->classes[$calledService];
        } else if (class_exists($calledService)) {
            return $this->classes[$calledService] = new $calledService;
        }

        return false;
    }

}