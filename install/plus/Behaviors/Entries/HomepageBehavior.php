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

    public function _relatedSponsors()
    {
        /*
         * Template usage {% for sponsor in entry._relatedSponsors %}
         */

        /* Handle on the entry model */
        $model = clone($this->getOwner());

        /** 
         * Handle on the related field `relatedSponsors` 
         * This field is an entry field type relating to the sponsors channel
        */
        $criteria = $model->relatedSponsors;

        $criteria->with = [
            ['logoColor'], /* This is the handle of the field to eager load from the sponsors entry */
            ['matrixHandle.matrixBlockType:matrixFieldHandle'] /* If this field is inside a matrix block this is how its eager loaded */
        ];

        return $criteria->find();
    }
}