<?php
namespace Craft;

class PlusVariable
{
    private $classes = [];
    protected $baseService = 'Plus\\Services\\';

    public function __call($name, $params = null)
    {
        return $this->service_exists($name) ?? null;
    }

    private function service_exists($name)
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