<?php

namespace TP\RedactorBundle\Tests\Form\Type;

use TP\RedactorBundle\Form\Type\RedactorType;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class RedactorTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RedactorType
     */
    protected $object;

    protected function setUp()
    {
        $mock = $this->getMock('Symfony\Component\Form\DataTransformerInterface');
        $this->object = new RedactorType(array('foo', 'bar'), $this->getConfigSets(), 'default');
        foreach (array('foo', 'bar') as $alias) {
            $this->object->addTransformer($mock, $alias);
        }
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The default config set "foo" must be in defined config sets (default, other).
     */
    public function testConfigSetException()
    {
        new RedactorType(array(), $this->getConfigSets(), 'foo');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage 'baz' is not a valid transformer.
     */
    public function testBuild()
    {
        $mock = $this->getMock('Symfony\Component\Form\FormBuilder', array('addViewTransformer'), array(), '', false);
        $mock->expects($this->exactly(2))->method('addViewTransformer');
        $this->object->buildForm($mock, array('transformers' => array('foo', 'bar', 'baz')));
    }

    public function testBuildView()
    {
        $formView = $this->getMock('Symfony\Component\Form\FormView');
        $form = $this->getMock('Symfony\Component\Form\Form', array(), array(), '', false);
        $this->object->buildView($formView, $form, array('config_set' => 'default'));

        $this->assertSame(array('lang' => 'fr'), $formView->vars['parameters']);
    }

    private function getConfigSets()
    {
        return array(
            'default' => array(
                'lang' => 'fr'
            ),
            'other' => array(
                'lang' => 'en'
            )
        );
    }
}
