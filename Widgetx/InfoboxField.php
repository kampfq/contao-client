<?php

/**
 * @package   AuthClient
 * @author    Hendrik Obermayer - Comolo GmbH
 * @license   -
 * @copyright 2015 Hendrik Obermayer
 */

namespace AuthClient;

/**
 * Class InfoboxField
 * @package AuthClient
 */
class InfoboxField extends \Widget {

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'be_widget';

    /**
     * Generate the widget and return it as string
     * @return string
     */
    public function generate()
    {
        return sprintf('<code name="%s"
                               id="ctrl_%s" %s
                               onfocus="Backend.getScrollOffset();"
                               style="">%s
                          </code>',
            $this->strName,
            $this->strId,
            (strlen($this->strClass) ? ' '.$this->strClass : ''),
            str_replace("\n", '<br>', $this->varValue)
        );
    }
}