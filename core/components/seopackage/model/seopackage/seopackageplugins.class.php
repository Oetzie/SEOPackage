<?php

/**
 * SEO Package
 *
 * Copyright 2020 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

require_once __DIR__ . '/seopackage.class.php';

class SeoPackagePlugins extends SeoPackage
{
    /**
     * @access public.
     * @param Array $properties.
     */
    public function onLoadWebDocument(array $properties = [])
    {
        if (!in_array($this->modx->context->get('key'), $this->getOption('exclude_contexts'), true)) {
            $data = $this->modx->getObject('SeoPackageResource', [
                'resource_id' => $this->modx->resource->get('id')
            ]);

            if ($data) {
                $data = array_merge($data->toArray(), [
                    'robots' => []
                ]);
            } else {
                $data = [
                    'robots' => []
                ];
            }

            if (isset($data['index'])) {
                $data['robots'][] = (int) $data['index'] === 1 ? 'index' : 'noindex';
            } else {
                $data['robots'][] = $this->config['seo_index'] ? 'index' : 'noindex';
            }

            if (isset($data['follow'])) {
                $data['robots'][] = (int) $data['follow'] === 1 ? 'follow' : 'nofollow';
            } else {
                $data['robots'][] = $this->config['seo_follow'] ? 'follow' : 'nofollow';
            }

            $this->modx->setPlaceholders(array_merge($this->getSeoDefaults($data), [
                'title'         => $this->getSeoTitle(),
                'robots'        => implode(',', $data['robots']),
                'searchable'    => $this->modx->resource->get('searchable')
            ]), 'seopackage.');
        }
    }
    /**
     * @access public.
     * @param Array $properties.
     */
    public function onDocFormRender(array $properties = [])
    {
        $record = [];

        if ($properties['mode'] !== 'new') {
            $data = $this->modx->getObject('SeoPackageResource', [
                'resource_id' => $properties['resource']->get('id')
            ]);

            if ($data) {
                $record = array_merge($data->toArray(), [
                    'searchable' => $properties['resource']->get('searchable')
                ]);
            }
        }

        $this->modx->regClientCSS($this->config['css_url'] . 'mgr/seopackage.css');

        $this->modx->regClientStartupScript($this->config['js_url'] . 'mgr/seopackage.js');

        $this->modx->regClientStartupHTMLBlock('<script type="text/javascript">
            Ext.onReady(function() {
                SeoPackage.config = ' . $this->modx->toJSON(array_merge($this->config, [
                    'branding_url'          => $this->getBrandingUrl(),
                    'branding_url_help'     => $this->getHelpUrl()
                ])) . ';
                
                SeoPackage.record = ' . $this->modx->toJSON($this->getSeoDefaults($record)) . ';
            });
        </script>');

        $this->modx->regClientStartupScript($this->config['js_url'] . 'mgr/widgets/resource.panel.js');

        if (is_array($this->config['lexicons'])) {
            foreach ($this->config['lexicons'] as $lexicon) {
                $this->modx->controller->addLexiconTopic($lexicon);
            }
        } else {
            $this->modx->controller->addLexiconTopic($this->config['lexicons']);
        }
    }

    /**
     * @access public.
     * @param Array $properties.
     */
    public function onDocFormSave(array $properties = [])
    {
        if (isset($properties['resource'])) {
            $this->handleResource($properties['resource']);
        }
    }

    /**
     * @access public.
     * @param Array $properties.
     */
    public function onResourceSort(array $properties = [])
    {
        if (isset($properties['nodesAffected'])) {
            foreach ((array) $properties['nodesAffected'] as $resource) {
                $this->handleResource($resource);
            }
        }
    }

    /**
     * @access public.
     */
    public function onPageNotFound()
    {
        if (!in_array($this->modx->context->get('key'), $this->getOption('exclude_contexts'), true)) {
            $request = urldecode(trim($_SERVER['REQUEST_URI'], '/'));
            $baseUrl = ltrim(trim($this->modx->getOption('base_url', null, MODX_BASE_URL)), '/');

            if ($baseUrl !== '/' && $baseUrl !== '') {
                $request = trim(str_replace($baseUrl, '', $request), '/');
            }

            if ($request !== '') {
                foreach (array_reverse($this->getRedirects()) as $redirect) {
                    $regex = preg_quote(trim($redirect->get('old_url'), '/'));
                    $regex = str_replace(['%', '\^', '\$', '/'], ['(.+?)', '^', '$', '\/'], $regex);

                    if (!preg_match('/\^/', $regex) && !preg_match('/\$/', $regex)) {
                        $regex = sprintf('/^%s$/si', $regex);
                    } else {
                        $regex = sprintf('/%s/si', $regex);
                    }

                    if (preg_match($regex, $request, $matches)) {
                        $location = $redirect->get('new_url');

                        if (is_numeric($location)) {
                            $location = $this->modx->makeUrl($location, null, null, 'full');
                        }

                        foreach ((array) $matches as $key => $value) {
                            $location = str_replace(sprintf('$%s', $key), $value, $location);
                        }

                        if (preg_match('/(\[\[\~([\d]+)\]\])/i', $location, $matches)) {
                            if (isset($matches[2])) {
                                $location = str_replace($matches[1], $this->modx->makeUrl($matches[2]), $location);
                            }
                        }

                        $location = trim($location, '/');

                        if ($location !== $this->modx->resourceIdentifier) {
                            if ($baseUrl !== '') {
                                if (0 === ($pos = strpos($location, $baseUrl))) {
                                    $location = substr($location, strlen($baseUrl), strlen($location));
                                }
                            }

                            $redirect->set('visits', (int) $redirect->get('visits') + 1);
                            $redirect->set('last_visit', date('Y-m-d H:i:s'));

                            if ($redirect->save()) {
                                $this->modx->sendRedirect($location, [
                                    'responseCode' => $redirect->get('type')
                                ]);
                            }
                        }
                    }
                }

                $notFound = $this->modx->getObject('SeoPackageRedirect', [
                    'context'   => $this->modx->context->get('key'),
                    'old_url'   => $request,
                    'active'    => 2
                ]);

                if (!$notFound) {
                    $notFound = $this->modx->newObject('SeoPackageRedirect');
                }

                $notFound->fromArray([
                    'context'      => $this->modx->context->get('key'),
                    'old_url'      => $request,
                    'active'       => 2,
                    'visits'       => (int) $notFound->get('visits') + 1,
                    'last_visit'   => date('Y-m-d H:i:s')
                ]);

                $notFound->save();
            }
        }
    }

    /**
     * @access protected.
     * @param Object $resource.
     * @param Boolean $handlePost.
     * @return Boolean.
     */
    protected function handleResource($resource, $handlePost = true)
    {
        if ($resource instanceof modResource) {
            if (!in_array($resource->get('context_key'), $this->getOption('exclude_contexts'), true)) {
                $data = $this->modx->getObject('SeoPackageResource', [
                    'resource_id' => $resource->get('id')
                ]);

                if (!$data) {
                    $data = $this->modx->newObject('SeoPackageResource', [
                        'resource_id' => $resource->get('id')
                    ]);
                }

                if ($data) {
                    if ($data->get('url')) {
                        $oldUrl = trim($data->get('url'), '/');
                        $newUrl = trim($resource->get('uri'), '/');

                        if ($oldUrl !== '' && $newUrl !== '') {
                            if ($oldUrl !== $newUrl) {
                                $redirect = $this->modx->getObject('SeoPackageRedirect', [
                                    'context'   => $resource->get('context_key'),
                                    'old_url'   => $newUrl,
                                    'new_url'   => $oldUrl,
                                    'active:!=' => 2
                                ]);

                                if (!$redirect) {
                                    $redirect = $this->modx->getObject('SeoPackageRedirect', [
                                        'context'   => $resource->get('context_key'),
                                        'old_url'   => $oldUrl
                                    ]);

                                    if (!$redirect) {
                                        $redirect = $this->modx->newObject('SeoPackageRedirect', [
                                            'context'   => $resource->get('context_key'),
                                            'old_url'   => $oldUrl
                                        ]);
                                    }

                                    if ($redirect) {
                                        $redirect->fromArray([
                                            'new_url'   => $newUrl,
                                            'type'      => 'HTTP/1.1 301 Moved Permanently',
                                            'active'    => 1
                                        ]);

                                        $redirect->save();
                                    }
                                } else {
                                    $redirect->remove();
                                }

                                if ($this->modx->getOption('use_alias_path')) {
                                    $childResources = $this->modx->getChildIds($resource->get('id'), 1, [
                                        'context' => $resource->get('context_key')
                                    ]);

                                    if ($childResources) {
                                        foreach ($childResources as $childResource) {
                                            $childResource = $this->modx->getObject('modResource', $childResource);

                                            if ($childResource) {
                                                $this->handleResource($childResource, false);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $data->set('url', $resource->get('uri'));

                    if ($handlePost) {
                        if (isset($_POST['keywords'])) {
                            $data->set('keywords', trim($_POST['keywords'], ','));
                        }

                        if (isset($_POST['index'])) {
                            $data->set('index', (int) $_POST['index'] === 1 ? 1 : 0);
                        }

                        if (isset($_POST['follow'])) {
                            $data->set('follow', (int) $_POST['follow'] === 1 ? 1 : 0);
                        }

                        if (isset($_POST['sitemap'])) {
                            $data->set('sitemap', (int) $_POST['sitemap'] === 1 ? 1 : 0);
                        }

                        if (isset($_POST['sitemap_prio'])) {
                            $data->set('sitemap_prio', $_POST['sitemap_prio']);
                        }

                        if (isset($_POST['sitemap_freq'])) {
                            $data->set('sitemap_freq', $_POST['sitemap_freq']);
                        }
                    }

                    /* Set the data to the resource, after the save the form will be resetted. */
                    foreach ((array) $data->toArray() as $key => $value) {
                        if (in_array($key, ['keywords', 'index', 'follow', 'sitemap', 'sitemap_prio', 'sitemap_freq'], true)) {
                            $resource->set($key, $value);
                        }
                    }

                    return $data->save();
                }
            }
        }

        return true;
    }
}
