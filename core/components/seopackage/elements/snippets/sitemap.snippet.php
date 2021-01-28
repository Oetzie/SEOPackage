<?php

/**
 * SEO Package
 *
 * Copyright 2020 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

$class = $modx->loadClass('SeoPackageSnippetSitemap', $modx->getOption('seopackage.core_path', null, $modx->getOption('core_path') . 'components/seopackage/') . 'model/seopackage/snippets/', false, true);

if ($class) {
    $instance = new $class($modx);

    if ($instance instanceof SeoPackageSnippets) {
        return $instance->run($scriptProperties);
    }
}

return '';
