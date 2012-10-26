<?php

namespace TP\RedactorBundle\Tests\Form\Transformer;

use TP\RedactorBundle\Form\Transformer\StripJS;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class StripJSTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StripJS
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new StripJS;
    }

    /**
     * @dataProvider reverseTransformDataProvider
     */
    public function testReverseTransform($source, $wanted)
    {
        $this->assertSame($wanted, $this->object->reverseTransform($source), 'JS is removed from HTML');
    }

    public function reverseTransformDataProvider()
    {
        return array(
            array(
                'Foo is not <script type="text/javascript">document.write("bar");</script>',
                'Foo is not ',
            ),
            array(
                'Foo is not <script>document.write("bar");</script>',
                'Foo is not ',
            ),
            array(
                'Foo is not <script type="text/javascript">document.write("bar");</script>but baz',
                'Foo is not but baz',
            ),
        );
    }
}
