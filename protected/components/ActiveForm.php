<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 11/4/13
 * Time: 2:07 PM
 */

class ActiveForm extends CActiveForm
{

    public function imageField($model, $attribute, $htmlOptions = array(), $imageAttribute = null)
    {
        $html = '';

        if (!isset($htmlOptions['class'])) {
            $htmlOptions['class'] = 'imageField';
        }

        if ($imageAttribute && $model->$imageAttribute) {
            if (!isset($htmlOptions['style'])) {
                $htmlOptions['style'] = '';
            }
            $htmlOptions['style'] .= "background-image: url('{$model->image->getSize('l')}');";
            $html .= $this->hiddenField($model, $imageAttribute);
        }

        $html .= CHtml::openTag('label', $htmlOptions);
        $html .= $this->fileField($model, $attribute);
        $html .= CHtml::closeTag('label');
        return $html;
    }
}