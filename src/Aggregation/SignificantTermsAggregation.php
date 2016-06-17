<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Aggregation;

use ONGR\ElasticsearchDSL\Aggregation\Type\BucketingTrait;
use ONGR\ElasticsearchDSL\ScriptAwareTrait;

/**
 * Class representing TermsAggregation.
 */
class SignificantTermsAggregation extends AbstractAggregation
{
    use BucketingTrait;
    use ScriptAwareTrait;

    /**
     * Inner aggregations container init.
     *
     * @param string $name
     * @param string $field
     * @param array $parameters
     * @param string $script
     */
    public function __construct($name, $field = null, $parameters = [], $script = null)
    {
        parent::__construct($name);

        $this->setField($field);
        $this->setScript($script);
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'significant_terms';
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        $data = array_filter(
            [
                'field' => $this->getField(),
                'script' => $this->getScript(),
            ]
        );
        $data = $this->processArray($data);
        return $data;
    }
}
