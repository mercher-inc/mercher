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

        if ($this->model->{$this->attribute}) {
            $image = Image::model()->findByPk($this->model->{$this->attribute});
        } else {
            $image = null;
        }

        if ($image) {
            $this->htmlOptions['style'] = 'background-image: url('.$image->getSize('l').')';
        }

        $js = <<<JS
            $("#{$this->id}").click(function(e){
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
                        var file = this.files[0];
                        var formData = new FormData(fileInputForm[0]);
                        $.ajax({
                            url: '/api/shops/{$this->model->shop_id}/images',
                            type: 'POST',
                            data: formData,
                            success: function(image) {
                                $("#{$this->id}").css('background-image', 'url(' + image.data.l + ')');
                                var hidden = $('#{$this->id} input[type="hidden"]');
                                hidden.attr("value", image.id);

                                $("#{$this->id}").parent().removeClass('has-error');
                                $('.help-block', $("#{$this->id}").parent()).remove();
                            },
                            error: function (response) {
                                $("#{$this->id}").after('<div class="help-block">'+response.responseJSON.error.message+'</div>');
                                $("#{$this->id}").parent().addClass('has-error');
                                $("#{$this->id}").css('background-image', '');
                                var hidden = $('#{$this->id} input[type="hidden"]');
                                hidden.attr("value", '');
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    });
                }
                $('input[type="file"]', fileInputForm).click();
            });
JS;
        Yii::app()->clientScript->registerScript(
            $this->id,
            $js
        );

        echo CHtml::openTag('div', $this->htmlOptions);
        echo CHtml::activeHiddenField($this->model, $this->attribute);
        echo CHtml::closeTag('div');
    }
}