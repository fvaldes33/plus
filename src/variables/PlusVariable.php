<?php
namespace fvaldes\plus\variables;

use Craft;
use fvaldes\plus\Plugin;

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
