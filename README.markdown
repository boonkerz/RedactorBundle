Installation 
------------

To instal this bundle, copy and paste to your composer.json

```
"friendsofsymfony/jsrouting-bundle": "dev-master",
"bnlab/redactor-bundle": "*",
```

Rember to configure JsRoutingBundle guiding their README file.

and

```
{
    "type": "package",
    "package": {
        "name": "bnlab/redactor-bundle",
        "version": "master",
        "autoload": { "psr-0": { "TP\\RedactorBundle": "" } },
        "target-dir": "TP/RedactorBundle",
        "source": {
            "url": "https://github.com/bnlab/RedactorBundle.git",
            "type": "git",
            "reference": "master"
        }
    }
}
```


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