<?php

namespace Retrilhar\Shortcode;

abstract class AbstractShortcode
{
    /**
     * Nome da chave que armazena o template
     * @var string
     */
    static $key;

    /**
     * Processamento do shotcode
     * @return string HTML
     */
    abstract static function shortcode($atts, $content = null);
    abstract static function getDicionarioShow();
    abstract static function getTemplateDefault();

    /**
     * Renderiza o template
     *
     * @param array $aDicionario
     * @param string template
     * @return string HTML
     */
    static function render(array $aDicionario, $template = null)
    {
        if (!$template) {
            $template = static::getTemplate();
        }
        $template = preg_replace_callback('/\{{(.*?)\}}/',
            function($matches) {
                return strtolower(strip_tags($matches[0]));
            },
            $template
        );
        foreach ($aDicionario as $campo => $valor) {
            $template = str_replace('{' . $campo . '}', $valor, $template);
        }
        return $template;
    }

    /**
     * Grava template para o shortcode
     * @return void
     */
    static public function setTemplate($template)
    {
        $template = htmlentities(stripslashes($template));
        $templateStore = static::getTemplate();
        if (!$templateStore) {
            \add_option(static::$key, $template);
        } else {
            \update_option(static::$key, $template);
        }
    }

    /**
     * Retorna otemplate
     *
     * @return string phtml
     */
    static public function getTemplate()
    {
        $template = \get_option(static::$key);
        if (!$template) {
            $template = static::getTemplateDefault();
        }
        return html_entity_decode($template);
    }

    static function getTemplateChild($tagname, $template, array $aDicionario)
    {
        $pattern = '/<' . $tagname . '>(.*?)<\/'. $tagname . '>/s';
        preg_match($pattern, $template, $match);
        return static::render($aDicionario, $match[1]);
    }
}
