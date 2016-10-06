<?php
namespace CraftPlus\Behaviors\Entries;

use CBehavior;
use Craft;
use Craft\ElementType;

use function Craft\craft;

class HomepageBehavior extends BaseEntryBehavior
{
    public function example()
    {
        $model = clone($this->getOwner());
        
        $criteria = $model->body;

        return $model->body;
    }
}