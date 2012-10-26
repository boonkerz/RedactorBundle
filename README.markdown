Installation
------------

contributors: Bartłomiej Noszka bnlab

To instal this bundle, copy and paste to your composer.json

```
"friendsofsymfony/jsrouting-bundle": "dev-master",
"tp/redactor-bundle": "dev-master",
```

Rember to configure JsRoutingBundle guiding their README file.


Usage
-------------

in `config.yml`:

```
twig:
    form:
        resources:
            - 'TPRedactorBundle:Form:redactor_widget.html.twig'
```

in `routing.yml`:

```
tp_redactor:
    resource: "@TPRedactorBundle/Controller/"
    type:     annotation
```

add CSS and Javascript to your assetic:

 * CSS: `'@TPRedactorBundle/Resources/public/css/redactor.css'`
 * Javascripts: `'@TPRedactorBundle/Resources/public/js/redactor.js'` and
`'@TPRedactorBundle/Resources/public/js/tp_redactor.js'`

Configuration
-------------

RedactorBundle allows you to configure the RedactorJS editor. Options are managed by "config_sets".

 in `config.yml`
 ```yaml

 tp_redactor:
    default_config_set: default
    config_sets:
        default:
            lang: fr
        basic:
            lang: fr
            formattingTags:
                - 'h2'
                - 'h3'
                - 'p'
                - 'blockquote'
```

Chose your config set at form building :

```php
    $builder->add('your_form_field', 'redactor', array('config_set' => 'basic'));
```

All supported redactor options can be found (Here)[http://imperavi.com/redactor/docs/settings/]
