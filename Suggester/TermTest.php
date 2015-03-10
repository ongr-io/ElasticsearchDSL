<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\Tests\Unit\DSL\Suggester;

use ONGR\ElasticsearchBundle\DSL\Suggester\Term;
use ONGR\ElasticsearchBundle\Test\EncapsulationTestAwareTrait;

class TermTest extends \PHPUnit_Framework_TestCase
{
    use EncapsulationTestAwareTrait;

    /**
     * @return array
     */
    public function getTestToArrayData()
    {
        $out = [];

        // Case #0: simple.
        $term0 = new Term('body', 'lorem ipsum');
        $expected0 = [
            'body-term' => [
                'text' => 'lorem ipsum',
                'term' => ['field' => 'body'],
            ],
        ];
        $out[] = [
            $expected0,
            $term0,
        ];

        // Case #1: full suggester.
        $term1 = new Term('body', 'lorem ipsum');
        $term1
            ->setSize(2)
            ->setAnalyzer('simple')
            ->setSuggestMode(Term::SUGGEST_MODE_ALWAYS)
            ->setSort(Term::SORT_BY_SCORE);

        $expected1 = [
            'body-term' => [
                'text' => 'lorem ipsum',
                'term' => [
                    'field' => 'body',
                    'analyzer' => 'simple',
                    'sort' => 'score',
                    'suggest_mode' => 'always',
                ],
                'size' => 2,
            ],
        ];

        $out[] = [
            $expected1,
            $term1,
        ];

        return $out;
    }

    /**
     * Tests toArray method.
     *
     * @param array $expected
     * @param Term  $suggester
     *
     * @dataProvider getTestToArrayData
     */
    public function testToArray($expected, $suggester)
    {
        $this->assertEquals($expected, $suggester->toArray());
    }

    /**
     * Tests toArray method exception.
     *
     * @expectedException \LogicException
     */
    public function testToArrayException()
    {
        $term = new Term('', '');
        $term->toArray();
    }

    /**
     * Tests setSort method.
     */
    public function testSetSort()
    {
        $term = new Term('foo', 'bar');

        $term->setSort(Term::SORT_BY_FREQ);
        $this->assertEquals(Term::SORT_BY_FREQ, $term->getSort());

        $term->setSort(Term::SORT_BY_SCORE);
        $this->assertEquals(Term::SORT_BY_SCORE, $term->getSort());

        $initValue = $term->getSort();
        $term->setSort('wrongSort');
        $this->assertEquals($initValue, $term->getSort());
    }

    /**
     * Tests setSuggestMode method.
     */
    public function testSetSuggestMode()
    {
        $term = new Term('foo', 'bar');

        $term->setSuggestMode(Term::SUGGEST_MODE_ALWAYS);
        $this->assertEquals(Term::SUGGEST_MODE_ALWAYS, $term->getSuggestMode());

        $term->setSuggestMode(Term::SUGGEST_MODE_MISSING);
        $this->assertEquals(Term::SUGGEST_MODE_MISSING, $term->getSuggestMode());

        $initValue = $term->getSuggestMode();
        $term->setSuggestMode('wrongMode');
        $this->assertEquals($initValue, $term->getSuggestMode());
    }

    /**
     * Returns list of fields to test. Works as data provider.
     *
     * @return array
     */
    public function getFieldsData()
    {
        return [
            ['analyzer'],
            ['size'],
        ];
    }

    /**
     * Returns entity class name.
     *
     * @return string
     */
    public function getClassName()
    {
        $this->setStub(new Term('foo', 'bar'));
        $this->addIgnoredField('sort');
        $this->addIgnoredField('suggestMode');

        return 'ONGR\ElasticsearchBundle\DSL\Suggester\Term';
    }
}
