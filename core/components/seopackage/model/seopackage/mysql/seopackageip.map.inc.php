<?php

/**
 * SEO Package
 *
 * Copyright 2020 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

$xpdo_meta_map['SeoPackageIP'] = [
    'package'       => 'seopackage',
    'version'       => '1.0',
    'table'         => 'seopackage_ip',
    'extends'       => 'xPDOSimpleObject',
    'fields'        => [
        'id'            => null,
        'context'       => null,
        'type'          => null,
        'ip'            => null,
        'useragent'     => null,
        'description'   => null,
        'active'        => null,
        'editedon'      => null,
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
            'null'          => true,
            'default'       => ''
        ],
        'type'          => [
            'dbtype'        => 'varchar',
            'precision'     => '10',
            'phptype'       => 'string',
            'null'          => true,
            'default'       => null
        ],
        'ip'            => [
            'dbtype'        => 'varchar',
            'precision'     => '20',
            'phptype'       => 'string',
            'null'          => false
        ],
        'useragent'     => [
            'dbtype'        => 'varchar',
            'precision'     => '255',
            'phptype'       => 'string',
            'null'          => true,
            'default'       => null
        ],
        'description'   => [
            'dbtype'        => 'varchar',
            'precision'     => '255',
            'phptype'       => 'string',
            'null'          => true,
            'default'       => null
        ],
        'active'        => [
            'dbtype'        => 'int',
            'precision'     => '1',
            'phptype'       => 'integer',
            'null'          => false,
            'default'       => 1,
            'index'         => 'index'
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
        ],
        'ip'            => [
            'alias'         => 'active',
            'primary'       => false,
            'unique'        => false,
            'type'          => 'BTREE',
            'columns'       => [
                'active'        => [
                    'length'        => '767',
                    'collation'     => 'A',
                    'null'          => false
                ]
            ]
        ],
        'active'        => [
            'alias'         => 'active',
            'primary'       => false,
            'unique'        => false,
            'type'          => 'BTREE',
            'columns'       => [
                'active'        => [
                    'length'        => '767',
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
