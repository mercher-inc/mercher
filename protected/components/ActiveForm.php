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

        Yii::app()->clientScript->registerScript(
            'imageFieldScript',
            '$(".imageField input[type=\"file\"]").change(function(e){
                var imageField = $(e.target).parent(".imageField");
                var helpText = $(".helpText", imageField);
                var filename = $(e.target).val().replace(/^.*[\\\\\/]/, \'\');
                imageField.css("background-image", "none");
                helpText.html("<p>Save item to upload image " + filename + "</p>");
                helpText.show();
            });'
        );

        $html .= CHtml::openTag('label', $htmlOptions);
        $html .= $this->fileField($model, $attribute);
        $html .= CHtml::tag('div', ['class' => 'helpText', 'style' => 'display: none;'], '');
        $html .= CHtml::closeTag('label');
        return $html;
    }
}