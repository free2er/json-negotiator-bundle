# json-negotiator-bundle
JSON Negotiator Bundle

## Installation
This component can be installed with the [Composer](https://getcomposer.org/) dependency manager.

1. [Install Composer](https://getcomposer.org/doc/00-intro.md)

2. Install the component as a dependency of your project

        composer require free2er/json-negotiator-bundle

3. Enable the bundle

```php
<?php

// config/bundles.php
return [
    // ...
    Free2er\Json\JsonNegotiatorBundle::class => ['all' => true],
    // ...
];
```

4. Configure negotiation options

```yml
# config/packages/json_negotiator.yaml
json_negotiator:
    content_types:
        - json
        - jsonld
    methods:
        - POST
        - PATCH
        - PUT 
```

5. Done!
