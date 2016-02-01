<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Suggest;

use ONGR\ElasticsearchDSL\BuilderInterface;

class Suggest implements BuilderInterface
{
    const DEFAULT_SIZE = 3;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $text;

    /**
     * @var array
     */
    private $params;

    public function __construct($name, $text, $params = [])
    {
        $this->name = $name;
        $this->text = $text;
        $this->params = $params;
    }

    /**
     * Returns element type.
     *
     * @return string
     */
    public function getType()
    {
        return 'suggest';
    }

    /**
     * Returns suggest name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        if (!isset($this->params['field'])) {
            $this->params['field'] = '_all';
        }

        if (!isset($this->params['size'])) {
            $this->params['size'] = self::DEFAULT_SIZE;
        }

        $output = [
            'text' => $this->text,
            'term' => $this->params,
        ];

        return $output;
    }
}