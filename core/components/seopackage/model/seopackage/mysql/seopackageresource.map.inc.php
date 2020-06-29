<?php

/**
 * SEO Package
 *
 * Copyright 2020 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

$xpdo_meta_map['SeoPackageResource'] = [
    'package'       => 'seopackage',
    'version'       => '1.0',
    'table'         => 'seopackage_resource',
    'extends'       => 'xPDOSimpleObject',
    'fields'        => [
        'id'            => null,
        'resource_id'   => null,
        'url'           => null,
        'keywords'      => null,
        'index'         => null,
        'follow'        => null,
        'sitemap'       => null,
        'sitemap_prio'  => null,
        'sitemap_freq'  => null
    ],
    'fieldMeta'     => [
        'id'            => [
            'dbtype'        => 'int',
            'precision'     => '11',
            'phptype'       => 'integer',
            'null'          => false,
            'index'         => 'pk',
            'generated'     => 'native'
        ],
        'resource_id'   => [
            'dbtype'        => 'int',
            'precision'     => '11',
            'phptype'       => 'integer',
            'null'          => false,
        ],
        'url'           => [
            'dbtype'        => 'varchar',
            'precision'     => '255',
            'phptype'       => 'string',
            'null'          => true,
            'default'       => null
        ],
        'keywords'      => [
            'dbtype'        => 'varchar',
            'precision'     => '255',
            'phptype'       => 'string',
            'null'          => true,
            'default'       => null
        ],
        'index'         => [
            'dbtype'        => 'int',
            'precision'     => '4',
            'phptype'       => 'integer',
            'null'          => true,
            'default'       => null
        ],
        'follow'         => [
            'dbtype'        => 'int',
            'precision'     => '4',
            'phptype'       => 'integer',
            'null'          => true,
            'default'       => null
        ],
        'sitemap'       => [
            'dbtype'        => 'int',
            'precision'     => '4',
            'phptype'       => 'integer',
            'null'          => true,
            'default'       => null
        ],
        'sitemap_prio'  => [
            'dbtype'        => 'varchar',
            'precision'     => '15',
            'phptype'       => 'string',
            'null'          => true
        ],
        'sitemap_freq'  => [
            'dbtype'        => 'varchar',
            'precision'     => '15',
            'phptype'       => 'string',
            'null'          => true
        ]
    ],
    'indexes'       => [
        'PRIMARY'       => [
            'alias'         => 'PRIMARY',
            'primary'       => true,
            'unique'        => true,
            'columns'       => [
                'id'            => [
                    'collation'     => 'A',
                    'null'          => false
                ]
            ]
        ]
    ],
    'aggregates'    => [
        'modResource'   => [
            'local'         => 'resource_id',
            'class'         => 'modResource',
            'foreign'       => 'id',
            'owner'         => 'local',
            'cardinality'   => 'one'
        ]
    ]
];
