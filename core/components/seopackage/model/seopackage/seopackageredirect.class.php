<?php

/**
 * SEO Package
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

class SeoPackageRedirect extends xPDOSimpleObject
{
    /**
     * @access public.
     * @return Array.
     */
    public function getOldUrl()
    {
        $url        = $this->get('old_url');
        $context    = $this->get('context');

        if (is_numeric($url)) {
            $url = $this->xpdo->makeUrl($url, null, null, 'full');
        }

        return [
            'domain'    => !empty($context) ? $this->getDomainFromContext($context) : $this->getDomainFromUrl($url),
            'path'      => $this->getPath($url)
        ];
    }

    /**
     * @access public.
     * @return Array.
     */
    public function getNewUrl()
    {
        $url = $this->get('new_url');

        if (is_numeric($url)) {
            $url = $this->xpdo->makeUrl($url, null, null, 'full');
        }

        return [
            'domain'    => $this->getDomainFromUrl($url),
            'path'      => $this->getPath($url)
        ];
    }

    /**
     * @access public.
     * @param String $url.
     * @return String.
     */
    protected function getPath($url)
    {
        $url    = trim($url, '/');

        if (preg_match('/^(www)/i', $url)) {
            $url = 'http://' . $url;
        }

        $domain = parse_url($url, PHP_URL_HOST);

        if ($pos = strpos($url, $domain)) {
            $url = substr($url, $pos + strlen($domain), strlen($url));
        }

        return trim($url, '/');
    }

    /**
     * @access public.
     * @param String $url.
     * @return String.
     */
    protected function getDomainFromUrl($url)
    {
        $url = trim($url, '/');

        if (preg_match('/^(www)/i', $url)) {
            $url = 'http://' . $url;
        }

        $domain = parse_url($url, PHP_URL_HOST);
        $scheme = parse_url($url, PHP_URL_SCHEME);

        if (!empty($scheme)) {
            return $scheme . '://' . trim($domain, '/');
        }

        return trim($domain, '/');
    }

    /**
     * @access public.
     * @param String $key.
     * @return String.
     */
    protected function getDomainFromContext($key)
    {
        $context = $this->xpdo->getObject('modContext', [
            'key' => $key
        ]);

        if ($context && $context->prepare()) {
            return trim($context->getOption('site_url'), '/');
        }

        return '';
    }
}
