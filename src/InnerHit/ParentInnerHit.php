<?php

namespace ONGR\ElasticsearchDSL\InnerHit;

class ParentInnerHit extends NestedInnerHit
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'parent';
    }
}
