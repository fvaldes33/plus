<?php
namespace Plus\Behaviors\Entries;

use CBehavior;
use Craft;
use Craft\ElementType;

use function Craft\craft;

class HomepageBehavior extends BaseEntryBehavior
{
    public function example()
    {
        /*
         * Template usage {{ entry.example }}
         */
        
        /* Handle on the entry model */
        $model = clone($this->getOwner());
        
        /* Handle on the field `body` */
        $criteria = $model->body;

        /* For the example's sake, just returning the field */
        return $criteria;
    }
}