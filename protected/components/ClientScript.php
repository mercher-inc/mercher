<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/4/13
 * Time: 7:20 PM
 */

class ClientScript extends CClientScript
{

    const POS_FB = 5;

    /**
     * Inserts the scripts at the end of the body section.
     * @param string $output the output to be inserted with scripts.
     */
    public function renderBodyEnd(&$output)
    {
        if (!isset($this->scriptFiles[self::POS_END]) && !isset($this->scripts[self::POS_END])
            && !isset($this->scripts[self::POS_READY]) && !isset($this->scripts[self::POS_LOAD])
            && !isset($this->scripts[self::POS_FB])
        ) {
            return;
        }

        $fullPage = 0;
        $output   = preg_replace('/(<\\/body\s*>)/is', '<###end###>$1', $output, 1, $fullPage);
        $html     = '';
        if (isset($this->scriptFiles[self::POS_END])) {
            foreach ($this->scriptFiles[self::POS_END] as $scriptFileUrl => $scriptFileValue) {
                if (is_array($scriptFileValue)) {
                    $html .= CHtml::scriptFile($scriptFileUrl, $scriptFileValue) . "\n";
                } else {
                    $html .= CHtml::scriptFile($scriptFileUrl) . "\n";
                }
            }
        }
        $scripts = array();
        if (isset($this->scripts[self::POS_FB])) {
            if ($fullPage) {
                $scripts[] = "window.fbAsyncInit = function() {\n" . implode(
                    "\n",
                    $this->scripts[self::POS_FB]
                ) . "\n};";
            } else {
                $scripts[] = implode("\n", $this->scripts[self::POS_FB]);
            }
        }
        $scripts = array_merge($scripts, isset($this->scripts[self::POS_END]) ? $this->scripts[self::POS_END] : array());
        if (isset($this->scripts[self::POS_READY])) {
            if ($fullPage) {
                $scripts[] = "jQuery(function($) {\n" . implode(
                    "\n",
                    $this->scripts[self::POS_READY]
                ) . "\n});";
            } else {
                $scripts[] = implode("\n", $this->scripts[self::POS_READY]);
            }
        }
        if (isset($this->scripts[self::POS_LOAD])) {
            if ($fullPage) {
                $scripts[] = "jQuery(window).on('load',function() {\n" . implode(
                    "\n",
                    $this->scripts[self::POS_LOAD]
                ) . "\n});";
            } else {
                $scripts[] = implode("\n", $this->scripts[self::POS_LOAD]);
            }
        }
        if (!empty($scripts)) {
            $html .= $this->renderScriptBatch($scripts);
        }

        if ($fullPage) {
            $output = str_replace('<###end###>', $html, $output);
        } else {
            $output = $output . $html;
        }
    }
}