<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 12/2/13
 * Time: 1:30 PM
 */

class ImageUploadWidget extends CWidget
{
    public $model;
    public $attribute;
    public $htmlOptions = [];

    public function init() {

    }

    public function run()
    {

        if (!isset($this->htmlOptions['class'])) {
            $this->htmlOptions['class'] = 'imageField';
        }
        $this->htmlOptions['id'] = $this->id;

        Yii::app()->clientScript->registerScript(
            $this->id,
            "
            $(\"#{$this->id}\").click(function(e){
                if (e.target == this) {
                    $('input[type=\"file\"]', this).click();
                }
            });
            $('#{$this->id} input[type=\"file\"]').change(function(){
                var input = this;
                var holder = $(\"#{$this->id}\");
                var iframe = $('<iframe></iframe>');
                iframe.attr(\"name\", \"{$this->id}iframe\");
                iframe.attr(\"id\", \"{$this->id}iframe\");
                iframe.css(\"display\", \"none\");
                iframe.appendTo(\"body\");

                var form = $('<form></form>');
                form.attr(\"action\", \"/api/images\");
                form.attr(\"method\", \"post\");
                form.attr(\"enctype\", \"multipart/form-data\");
                form.attr(\"encoding\", \"multipart/form-data\");
                form.attr(\"target\", \"{$this->id}iframe\");
                form.appendTo(\"body\");
                form.append(input);

                form.submit();

                holder.append(input);

                $(\"#{$this->id}iframe\").load(function () {
                    console.log($(\"#{$this->id}iframe\")[0].contentWindow.document.body.innerHTML);
                });
            });
            "
        );

        echo CHtml::openTag('div', $this->htmlOptions);
        echo CHtml::fileField('image');
        echo CHtml::closeTag('div');
    }
}