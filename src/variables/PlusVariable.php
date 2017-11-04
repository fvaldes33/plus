<?php
namespace fvaldes33\plus\variables;

use Craft;
use fvaldes33\plus\Plugin;

/**
 * USAGE:: {{ craft.plus.[service].[method ]}}
 *
 */
class PlusVariable
{
    // Public Methods
    // =========================================================================
    public function __call($name, $params = null)
    {
        return Plugin::$plugin->{$name};
    }
}
