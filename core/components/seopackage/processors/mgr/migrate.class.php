<?php

/**
 * SEO Package
 *
 * Copyright 2020 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

class SeoPackageRedirectsMigrateProcessor extends modProcessor
{
    /**
     * @access public.
     * @var String.
     */
    public $classKey = 'SeoPackageRedirect';

    /**
     * @access public.
     * @var Array.
     */
    public $languageTopics = ['seopackage:default'];

    /**
     * @access public.
     * @var String.
     */
    public $objectType = 'seopackage.redirect';

    /**
     * @access public.
     * @return Mixed.
     */
    public function initialize()
    {
        $this->modx->getService('seopackage', 'SeoPackage', $this->modx->getOption('seopackage.core_path', null, $this->modx->getOption('core_path') . 'components/seopackage/') . 'model/seopackage/');

        return parent::initialize();
    }

    /**
     * @access public.
     * @return Mixed.
     */
    public function process()
    {
        $urls   = 0;
        $pages  = 0;

        /**
         * Check if Sterc SEO suite is installed, if yes migrate the redirects.
         */
        $seosuite = $this->modx->getService('seosuite', 'SeoSuite', $this->modx->getOption('seosuite.core_path', null, $this->modx->getOption('core_path') . 'components/seosuite/') . 'model/seosuite/');

        if ($seosuite instanceof SeoSuite) {
            foreach ($this->modx->getCollection('SeoSuiteUrl') as $url) {
                $path = parse_url($url->get('url'), PHP_URL_PATH);

                if ($path) {
                    $redirect = $this->modx->getObject('SeoPackageRedirect', [
                        'old_url' => $path
                    ]);

                    if (!$redirect) {
                        $redirect = $this->modx->newObject('SeoPackageRedirect', [
                            'old_url' => $path
                        ]);
                    }

                    if ($redirect) {
                        $redirect->fromArray([
                            'new_url'       => $url->get('redirect_to'),
                            'visits'        => $url->get('triggered'),
                            'last_visit'    => $url->get('last_triggered'),
                            'active'        => (int) $url->get('solved') === 1 ? 1 : 2
                        ]);

                        if ($redirect->save()) {
                            $urls++;
                        }
                    }
                }
            }
        }

        $contexts = $this->modx->getCollection('modContext', [
            'key:!=' => 'mgr'
        ]);

        foreach ($contexts as $context) {
            $resources = $this->modx->getCollection('modResource', [
                'context_key' => $context->get('key')
            ]);

            foreach ($resources as $resource) {
                $data = [];

                /**
                 * Check if Sterc SEO Pro is installed, if yes migrate the keywords of the resources.
                 */
                $seopro = $this->modx->getService('seopro', 'seoPro', $this->modx->getOption('seopro.core_path', null, $this->modx->getOption('core_path') . 'components/seopro/') . 'model/seopro/');

                if ($seopro instanceof seoPro) {
                    $seoproKeywords = $this->modx->getObject('seoKeywords', [
                        'resource' => $resource->get('id')
                    ]);

                    if ($seoproKeywords) {
                        $data['keywords'] = $seoproKeywords->get('keywords');
                    }
                }

                /**
                 * Check if Sterc SEO is installed, if yes migrate the properties of the resources.
                 */
                $stercseo = $this->modx->getService('stercseo', 'StercSEO', $this->modx->getOption('stercseo.core_path', null, $this->modx->getOption('core_path') . 'components/stercseo/') . 'model/stercseo/');

                if ($stercseo instanceof StercSEO) {
                    $properties = $resource->getProperties('stercseo');

                    if (!empty($properties)) {
                        $values = [
                            'index'         => 'index',
                            'follow'        => 'follow',
                            'sitemap'       => 'sitemap',
                            'sitemap_prio'  => 'priority',
                            'sitemap_freq'  => 'changefreq'
                        ];

                        foreach ($values as $newProperty => $oldProperty) {
                            if (!isset($properties[$oldProperty])) {
                                $data[$newProperty] = $properties[$oldProperty];
                            }
                        }
                    }
                }


                /**
                 * Check if Oetzie Redirections is installed, if yes migrate the properties of the resources.
                 */
                $redirections = $this->modx->getService('redirections', 'Redirections', $this->modx->getOption('redirections.core_path', null, $this->modx->getOption('core_path') . 'components/redirections/') . 'model/redirections/');

                if ($redirections instanceof Redirections) {
                    $properties = $resource->getProperties('redirections');

                    if (!empty($properties)) {
                        $values = [
                            'url'           => 'uri'
                        ];

                        foreach ($values as $newProperty => $oldProperty) {
                            if (!isset($properties[$oldProperty])) {
                                $data[$newProperty] = $properties[$oldProperty];
                            }
                        }
                    }
                }

                $object = $this->modx->getObject('SeoPackageResource', [
                    'resource_id' => $resource->get('id')
                ]);

                if (!$object) {
                    $object = $this->modx->newObject('SeoPackageResource', [
                        'resource_id' => $resource->get('id')
                    ]);
                }

                $object->fromArray(array_merge([
                    'url' => trim($resource->get('uri'), '/')
                ], $data));

                if ($object->save() && $resource->save()) {
                    $pages++;
                }
            }
        }

        $setting = $this->modx->getObject('modSystemSetting', [
            'key' => 'seopackage.migrate'
        ]);

        if ($setting) {
            $setting->fromArray([
                'value' => 1
            ]);

            if ($setting->save()) {
                $this->modx->cacheManager->refresh([
                    'system_settings' => []
                ]);
            }
        }

        return $this->success($this->modx->lexicon('seopackage.migrate_redirections_success', [
            'urls'  => $urls,
            'pages' => $pages
        ]));
    }
}

return 'SeoPackageRedirectsMigrateProcessor';
