<?php

namespace TP\RedactorBundle\Tests\Form\Transformer;

use TP\RedactorBundle\Form\Transformer\StripComments;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class StripCommentsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StripComments
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new StripComments;
    }

    /**
     * @dataProvider reverseTransformDataProvider
     */
    public function testReverseTransform($source, $wanted)
    {
        $this->assertSame($wanted, $this->object->reverseTransform($source), 'CSS is removed from HTML');
    }

    public function reverseTransformDataProvider()
    {
        return array(
            array(
                '<h1>Foo is not </h1><!-- bar -->',
                '<h1>Foo is not </h1>',
            ),
            array(
                '<h1>Foo is not <!-- bar -->but baz</h1>',
                '<h1>Foo is not but baz</h1>',
            ),
        );
    }
}
