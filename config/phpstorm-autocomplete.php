<?php

return [

    'output' => '.phpstorm.meta.php',
    'view'   => 'phpstorm-autocomplete::meta',
    'metas'  => [
        'bindings'     => 'Laradic\\Phpstorm\\Autocomplete\\Metas\\BindingsMeta',
        'config'       => 'Laradic\\Phpstorm\\Autocomplete\\Metas\\ConfigMeta',
        'routes'       => 'Laradic\\Phpstorm\\Autocomplete\\Metas\\RoutesMeta',
        'translations' => 'Laradic\\Phpstorm\\Autocomplete\\Metas\\TransMeta',
    ],
];
