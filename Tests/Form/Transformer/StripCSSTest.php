<?php

namespace TP\RedactorBundle\Tests\Form\Transformer;

use TP\RedactorBundle\Form\Transformer\StripCSS;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class StripCSSTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StripCSS
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new StripCSS;
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
                '<h1>Foo is not </h1><style type="text/css">h1 { content: \'bar\'; }</style>',
                '<h1>Foo is not </h1>',
            ),
            array(
                '<h1>Foo is not </h1><style>h1 { content: \'bar\'; }</style>',
                '<h1>Foo is not </h1>',
            ),
            array(
                '<h1>Foo is not <style type="text/css">h1 { content: \'bar\'; }</style>but baz</h1>',
                '<h1>Foo is not but baz</h1>',
            ),
        );
    }
}
