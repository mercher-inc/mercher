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

    public function init()
    {

    }

    public function run()
    {
        switch (get_class($this->model)) {
            case 'Shop':
                $shop_id   = $this->model->id;
                $imageSize = 'sh';
                break;
            default:
                $shop_id   = $this->model->shop_id;
                $imageSize = 'l';
        }

        if (!isset($this->htmlOptions['class'])) {
            $this->htmlOptions['class'] = 'imageField';
        } else {
            $this->htmlOptions['class'] .= ' imageField';
        }
        $this->htmlOptions['id'] = $this->id;

        if ($this->model->{$this->attribute}) {
            $image = Image::model()->findByPk($this->model->{$this->attribute});
        } else {
            $image = null;
        }

        if ($image) {
            if (!isset($this->htmlOptions['style'])) {
                $this->htmlOptions['style'] = 'background-image: url(' . $image->getSize($imageSize) . ');';
            } else {
                $this->htmlOptions['style'] .= ' background-image: url(' . $image->getSize($imageSize) . ');';
            }
        }

        $js = <<<JS
            $("#{$this->id}").click(function(e){
                var holder = $("#{$this->id}");
                if (holder.hasClass('loading')) {
                    return false;
                }
                var fileInputForm = $("#{$this->id}_fileInputForm");
                if (!fileInputForm.length) {
                    fileInputForm = $("<form></form>");
                    fileInputForm.attr("id", "{$this->id}_fileInputForm");
                    fileInputForm.attr("enctype", "multipart/form-data");
                    fileInputForm.appendTo("body");

                    var fileInput = $("<input/>");
                    fileInput.attr("type", "file");
                    fileInput.attr("name", "image");
                    fileInput.css("display", "none");
                    fileInput.appendTo(fileInputForm);

                    fileInput.change(function(){
                        holder.addClass('loading');
                        var hidden = $('input[type="hidden"]', holder);
                        var prevBg = holder.css('background-image');
                        var prevId = hidden.val();

                        holder.css('background-image', '');
                        hidden.val('');

                        var formData = new FormData(fileInputForm[0]);
                        $.ajax({
                            url: '/api/shops/{$shop_id}/images',
                            type: 'POST',
                            data: formData,
                            success: function(image) {
                                holder.removeClass('loading');
                                holder.css('background-image', 'url(' + image.data.{$imageSize} + ')');
                                hidden.attr("value", image.id);

                                holder.parent().removeClass('has-error');
                                $('.help-block', holder.parent()).remove();

                                var v = {};
                                v[hidden.attr("name")] = hidden.attr("value");

                                $.ajax({
                                    url: hidden.parentsUntil("form").parent("form").attr("action"),
                                    type: 'POST',
                                    data: v
                                });
                            },
                            error: function (response) {
                                holder.removeClass('loading');

                                holder.css('background-image', prevBg);
                                hidden.attr("value", prevId);

                                holder.parent().append('<div class="help-block">'+response.responseJSON.error.message+'</div>');
                                holder.parent().addClass('has-error');
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    });
                }
                $('input[type="file"]', fileInputForm).click();
                return false;
            });
JS;
        Yii::app()->clientScript->registerScript(
            $this->id,
            $js
        );

        echo CHtml::openTag('div', $this->htmlOptions);
        echo CHtml::activeHiddenField($this->model, $this->attribute);
        echo CHtml::closeTag('div');
        echo CHtml::tag(
            'div',
            ['class' => 'text-muted'],
            '* ' . CHtml::tag('em', [], 'Max. image size is 5MB, 10000*10000 pixels')
        );
    }
}