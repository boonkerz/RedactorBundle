Installation 
------------

contributors: Bartłomiej Noszka bnlab

To instal this bundle, copy and paste to your composer.json

```
"friendsofsymfony/jsrouting-bundle": "dev-master",
"tp/redactor-bundle": "dev-master",
```

Rember to configure JsRoutingBundle guiding their README file.


Configuration 
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

CSS: `'@TPRedactorBundle/Resources/public/css/redactor.css'`
Javascript: `'@TPRedactorBundle/Resources/public/js/redactor.js'`