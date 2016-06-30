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

/**
 * Class representing a raw aggregation, that allows to set
 * a custom type and body
 */
class RawAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * @var string
     */
    private $type;
    /**
     * @var array
     */
    private $body;

    /**
     * Inner aggregations container init.
     *
     * @param string $name
     * @param string $type
     * @param array $body
     */
    public function __construct($name, $type, $body)
    {
        parent::__construct($name);

        $this->setType($type);
        $this->setBody($body);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param array $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * {@inheritdoc}
     */
    protected function getArray()
    {
        return $this->getBody();
    }
}
