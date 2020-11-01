<?php
return [
    'backend' => [
        'frontName' => 'admin'
    ],
    'queue' => [
        'consumers_wait_for_messages' => 1
    ],
    'crypt' => [
        'key' => '49b444d716bac587382e35dc84be35c3'
    ],
    'db' => [
        'table_prefix' => 'm2_',
        'connection' => [
            'default' => [
                'host' => 'mysql',
                'dbname' => 'andrii_shkrebtii_build_local',
                'username' => 'andrii_shkrebtii_build_local',
                'password' => 'PRq5tf?rxcDk&9KG',
                'model' => 'mysql4',
                'engine' => 'innodb',
                'initStatements' => 'SET NAMES utf8;',
                'active' => '1',
                'driver_options' => [
                    1014 => false
                ]
            ]
        ]
    ],
    'resource' => [
        'default_setup' => [
            'connection' => 'default'
        ]
    ],
    'x-frame-options' => 'SAMEORIGIN',
    'MAGE_MODE' => 'production',
    'session' => [
        'save' => 'files'
    ],
    'cache' => [
        'frontend' => [
            'default' => [
                'id_prefix' => '69d_'
            ],
            'page_cache' => [
                'id_prefix' => '69d_'
            ]
        ],
        'allow_parallel_generation' => false
    ],
    'lock' => [
        'provider' => 'db',
        'config' => [
            'prefix' => null
        ]
    ],
    'cache_types' => [
        'config' => 1,
        'layout' => 1,
        'block_html' => 1,
        'collections' => 1,
        'reflection' => 1,
        'db_ddl' => 1,
        'compiled_config' => 1,
        'eav' => 1,
        'customer_notification' => 1,
        'config_integration' => 1,
        'config_integration_api' => 1,
        'full_page' => 1,
        'config_webservice' => 1,
        'translate' => 1,
        'vertex' => 1
    ],
    'downloadable_domains' => [
        'andrii-shkrebtii-dev.local'
    ],
    'install' => [
        'date' => 'Sat, 24 Oct 2020 08:25:32 +0000'
    ],
    'system' => [
        'default' => [
            'web' => [
                'unsecure' => [
                    'base_url' => 'https://andrii-shkrebtii-dev.local/',
                    'base_link_url' => '{{unsecure_base_url}}',
                    'base_static_url' => 'https://andrii-shkrebtii-dev.local/static/',
                    'base_media_url' => 'https://andrii-shkrebtii-dev.local/media/'
                ],
                'secure' => [
                    'base_url' => 'https://andrii-shkrebtii-dev.local/',
                    'base_link_url' => '{{secure_base_url}}',
                    'base_static_url' => 'https://andrii-shkrebtii-dev.local/static/',
                    'base_media_url' => 'https://andrii-shkrebtii-dev.local/media/'
                ],
            ],
        ],
        'websites' => [
            'base' => [
                'design' => [
                    'theme' => [
                        'theme_id' => 4
                    ]
                ]
            ],
            'secondary_site' => [
                'web' => [
                    'unsecure' => [
                        'base_url' => 'https://andrii-shkrebtii-secondary-site-dev.local/',
                        'base_link_url' => 'https://andrii-shkrebtii-secondary-site-dev.local/',
                        'base_static_url' => 'https://andrii-shkrebtii-secondary-site-dev.local/static/',
                        'base_media_url' => 'https://andrii-shkrebtii-secondary-site-dev.local/media/'
                    ],
                    'secure' => [
                        'base_url' => 'https://andrii-shkrebtii-secondary-site-dev.local/',
                        'base_link_url' => 'https://andrii-shkrebtii-secondary-site-dev.local/',
                        'base_static_url' => 'https://andrii-shkrebtii-secondary-site-dev.local/static/',
                        'base_media_url' => 'https://andrii-shkrebtii-secondary-site-dev.local/media/'
                    ]
                ]
            ]
        ]
    ]
];
