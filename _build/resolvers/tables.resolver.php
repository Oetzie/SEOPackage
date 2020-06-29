<?php

/**
 * SEO Package
 *
 * Copyright 2020 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;
            $modx->addPackage('seopackage', $modx->getOption('seopackage.core_path', null, $modx->getOption('core_path') . 'components/seopackage/') . 'model/');

            $manager = $modx->getManager();

            $manager->createObjectContainer('SeoPackageResource');
            $manager->createObjectContainer('SeoPackageRedirect');

            break;
    }
}

return true;
