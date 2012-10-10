<?php

namespace TP\RedactorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use TP\RedactorBundle\DependencyInjection\Compiler\TransformerCompilerPass;

class TPRedactorBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new TransformerCompilerPass());
    }
}
