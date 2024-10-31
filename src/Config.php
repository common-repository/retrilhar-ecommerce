<?php

namespace Retrilhar;

class Config
{
    private $keyEcommerceUrl = 'retrilhar_ecommerce_url';

    public function setUrl($url)
    {
        if ('/' == substr($url, -1)) {
            $url = substr($url, 0, -1);
        }
        $temp = $this->getUrl();
        if (!$temp) {
            \add_option($this->keyEcommerceUrl, $url);
        } else {
            \update_option($this->keyEcommerceUrl, $url);
        }
    }

    public function getUrl()
    {
        return \get_option($this->keyEcommerceUrl);
    }
}
