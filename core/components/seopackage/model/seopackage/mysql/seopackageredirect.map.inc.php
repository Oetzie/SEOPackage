<?php

/**
 * SEO Package
 *
 * Copyright 2020 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

$xpdo_meta_map['SeoPackageRedirect'] = [
    'package'       => 'seopackage',
    'version'       => '1.0',
    'table'         => 'seopackage_redirect',
    'extends'       => 'xPDOSimpleObject',
    'fields'        => [
        'id'            => null,
        'context'       => null,
        'old_url'       => null,
        'new_url'       => null,
        'redirect_type' => null,
        'visits'        => null,
        'last_visit'    => null,
        'active'        => null,
        'editedon'      => null
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
        'context'       => [
            'dbtype'        => 'varchar',
            'precision'     => '75',
            'phptype'       => 'string',
            'null'          => true
        ],
        'old_url'       => [
            'dbtype'        => 'text',
            'precision'     => '2048',
            'phptype'       => 'string',
            'null'          => true,
            'default'       => ''
        ],
        'new_url'       => [
            'dbtype'        => 'text',
            'precision'     => '2048',
            'phptype'       => 'string',
            'null'          => true,
            'default'       => ''
        ],
        'redirect_type' => [
            'dbtype'        => 'varchar',
            'precision'     => '75',
            'phptype'       => 'string',
            'null'          => false,
            'default'       => 'HTTP/1.1 301 Moved Permanently'
        ],
        'visits'        => [
            'dbtype'        => 'int',
            'precision'     => '11',
            'phptype'       => 'integer',
            'null'          => false,
            'default'       => 0
        ],
        'last_visit'    => [
            'dbtype'        => 'timestamp',
            'phptype'       => 'timestamp',
            'null'          => false,
            'default'       => '0000-00-00 00:00:00'
        ],
        'active'        => [
            'dbtype'        => 'int',
            'precision'     => '1',
            'phptype'       => 'integer',
            'null'          => false,
            'default'       => 1
        ],
        'editedon'      => [
            'dbtype'        => 'timestamp',
            'phptype'       => 'timestamp',
            'attributes'    => 'ON UPDATE CURRENT_TIMESTAMP',
            'null'          => false
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
        'modContext'    => [
            'local'         => 'context',
            'class'         => 'modContext',
            'foreign'       => 'key',
            'owner'         => 'local',
            'cardinality'   => 'one'
        ]
    ]
];
