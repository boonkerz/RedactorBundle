<?php

namespace TP\RedactorBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use TP\RedactorBundle\DependencyInjection\TPRedactorExtension;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class TPRedactorExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TPRedactorExtension
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new TPRedactorExtension;
    }

    public function testLoad()
    {
        $container = $this->getContainer();
        $this->object->load($this->getConfig(), $container);

        $this->assertContains('TPRedactorBundle:Form:redactor_widget.html.twig', $container->getParameter('twig.form.resources'));
        $this->assertContains('strip_css', $container->getDefinition('tp_redactor.form.type')->getArgument(0));
        $this->assertContains('strip_js', $container->getDefinition('tp_redactor.form.type')->getArgument(0));
        $this->assertContains('strip_comments', $container->getDefinition('tp_redactor.form.type')->getArgument(0));
        $this->assertSame(array('default'), array_keys($container->getDefinition('tp_redactor.form.type')->getArgument(1)));
        $this->assertSame('default', $container->getDefinition('tp_redactor.form.type')->getArgument(2));
    }

    private function getConfig()
    {
        return array('tp_redactor' => array());
    }

    private function getContainer()
    {
        $container = new ContainerBuilder();

        $container->setParameter('twig.form.resources', array('something'));

        return $container;
    }
}
