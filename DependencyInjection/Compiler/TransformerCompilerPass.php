<?php

namespace TP\RedactorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class TransformerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('tp_redactor.form.type')) {
            return;
        }

        $definition = $container->getDefinition('tp_redactor.form.type');

        foreach ($container->findTaggedServiceIds('tp_redactor.transformer') as $id => $attributes) {
            $definition->addMethodCall('addTransformer', array(new Reference($id), $attributes[0]['alias']));
        }
    }
}
