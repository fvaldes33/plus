<?php namespace Craft;

use Twig_Extension;
use Twig_Environment;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

class TwigExtensions extends Twig_Extension
{
    protected $env;

    public function getName()
    {
        return 'Twig Extensions';
    }

    /**
     * Init Runtime
     * This creates a `plus` variable available in your templates
     * @return void
     */
    public function initRuntime(Twig_Environment $env)
    {
        $this->env = $env;

        $env->addGlobal('plus', plus());
    }

    public function getFilters()
    {
        return [];
    }

    public function getFunctions()
    {
        return [];
    }
}
