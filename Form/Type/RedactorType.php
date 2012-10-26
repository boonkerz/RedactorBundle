<?php

namespace TP\RedactorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * RedactorJS form type
 */
class RedactorType extends AbstractType
{
    /**
     * @var array<DataTransformerInterface>
     */
    protected $transformers;

    /**
     * @var array
     */
    protected $transformerAliases;

    /**
     * @var
     */
    protected $configSets;

    /**
     * @var string
     */
    protected $defaultConfigSet;

    /**
     * @param array  $transformers
     * @param array  $configSets
     * @param string $defaultConfigSet
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $transformers, array $configSets, $defaultConfigSet)
    {
        $this->transformerAliases = $transformers;
        $this->configSets         = $configSets;
        $this->defaultConfigSet   = $defaultConfigSet;

        if (!array_key_exists($defaultConfigSet, $configSets)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The default config set "%s" must be in defined config sets (%s).',
                    $defaultConfigSet,
                    implode(', ', array_keys($configSets))
                )
            );
        }
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
     * @{inheritDoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['parameters'] = $this->configSets[$options['config_set']];
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'required'     => false,
            'transformers' => $this->transformerAliases,
            'config_set'   => $this->defaultConfigSet
        ));

        $resolver->setAllowedValues(array(
            'required'   => array(false),
            'config_set' => array_keys($this->configSets),
        ));

        $resolver->setAllowedTypes(array(
            'transformers' => 'array',
            'config_set'   => 'string',
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
