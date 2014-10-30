<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Suggester;

/**
 * Suggesters class.
 */
class Suggesters
{
    /**
     * @var AbstractSuggester
     */
    private $suggesters = [];

    /**
     * Adds a suggester.
     *
     * @param AbstractSuggester $suggester
     */
    public function add(AbstractSuggester $suggester)
    {
        $this->suggesters[$suggester->getName()] = $suggester;
    }

    /**
     * Checks if suggester is set.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        return isset($this->suggesters[$name]);
    }

    /**
     * Removes suggester.
     *
     * @param string $name
     */
    public function remove($name)
    {
        unset($this->suggesters[$name]);
    }

    /**
     * Gets a suggester by it's name.
     *
     * @param string $name
     *
     * @return AbstractSuggester
     */
    public function get($name)
    {
        return $this->suggesters[$name];
    }

    /**
     * Gets all suggesters.
     *
     * @param string|null $name
     *
     * @return AbstractSuggester[]
     */
    public function all($name = null)
    {
        return array_filter(
            $this->suggesters,
            function ($build) use ($name) {
                /** @var AbstractSuggester $suggester */

                return $name === null || $suggester->getName() == $name;
            }
        );
    }
}
