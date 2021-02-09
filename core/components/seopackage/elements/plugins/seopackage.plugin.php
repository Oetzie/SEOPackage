<?php
/**
 * SEO Package
 *
 * Copyright 2020 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

if (in_array($modx->event->name, ['OnHandleRequest', 'OnLoadWebDocument', 'OnPageNotFound', 'OnDocFormSave', 'OnResourceSort', 'OnDocFormRender', 'OnManagerLogin'], true)) {
    $instance = $modx->getService('seopackageplugins', 'SeoPackagePlugins', $modx->getOption('seopackage.core_path', null, $modx->getOption('core_path') . 'components/seopackage/') . 'model/seopackage/');

    if ($instance instanceof SeoPackagePlugins) {
        $method = lcfirst($modx->event->name);

        if (method_exists($instance, $method)) {
            $instance->$method($scriptProperties);
        }
    }
}