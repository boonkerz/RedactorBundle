<?php

namespace TP\RedactorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * CKEditor type
 *
 */
class RedactorType extends AbstractType
{
    protected $container;
    protected $transformers;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function addTransformer(DataTransformerInterface $transformer, $alias)
    {
        if (isset($this->transformers[$alias])) {
            throw new \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException('Transformer alias must be unique.');
        }
        $this->transformers[$alias] = $transformer;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($options['transformers'] as $transformer_alias) {
            if (isset($this->transformers[$transformer_alias])) {
                $builder->addViewTransformer($this->transformers[$transformer_alias]);
            } else {
                throw new \Exception(sprintf("'%s' is not a valid transformer.", $transformer_alias));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {



    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'required'                     => false,
            'transformers'                 => $this->container->getParameter('tp_redactor.editor.transformers'),
        ));

        $resolver->setAllowedValues(array(
            'required'               => array(false)
        ));

        $resolver->setAllowedTypes(array(
            'transformers'   => 'array'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'textarea';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'redactor';
    }
}