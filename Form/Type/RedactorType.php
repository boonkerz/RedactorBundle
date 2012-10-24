<?php

namespace TP\RedactorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * RedactorJS form type
 */
class RedactorType extends AbstractType
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var array<DataTransformerInterface>
     */
    protected $transformers;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param DataTransformerInterface $transformer
     * @param string                   $alias
     *
     * @throws InvalidConfigurationException
     */
    public function addTransformer(DataTransformerInterface $transformer, $alias)
    {
        if (isset($this->transformers[$alias])) {
            throw new InvalidConfigurationException('Transformer alias must be unique.');
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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'required'     => false,
            'transformers' => $this->container->getParameter('tp_redactor.editor.transformers'),
        ));

        $resolver->setAllowedValues(array(
            'required' => array(false)
        ));

        $resolver->setAllowedTypes(array(
            'transformers' => 'array'
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
