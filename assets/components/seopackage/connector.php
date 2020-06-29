<?php

/**
 * SEO Package
 *
 * Copyright 2020 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

require_once dirname(dirname(dirname(__DIR__))) . '/config.core.php';

require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$modx->getService('seopackage', 'SeoPackage', $modx->getOption('seopackage.core_path', null, $modx->getOption('core_path') . 'components/seopackage/') . 'model/seopackage/');

if ($modx->seopackage instanceOf SeoPackage) {
    $modx->request->handleRequest([
        'processors_path'   => $modx->seopackage->config['processors_path'],
        'location'          => ''
    ]);
}
