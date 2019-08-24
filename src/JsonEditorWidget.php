<?php

namespace slavkovrn\jsoneditor;

use yii\helpers\StringHelper;
use yii\widgets\InputWidget;

class JsonEditorWidget extends InputWidget {

    public $id = 'json';
    public $class = 'editor';
    public $name = 'json-editor';
    public $style = 'border:solid 1px grey';
    /**
     * @var string JSON contents for initial display, default empty object '{}'
     */
    public $data = '{}';

    /**
     * @var string name of the 'root' node in editor
     */
    public $rootNodeName = 'root';

    /**
     * @var string label for input button, default: 'Switch to text input'
     */
    public $inputButtonLabel = 'Switch to text input';

    /**
     * @var string label for init button, default: 'Switch to JSON editor'
     */
    public $initButtonLabel = 'Switch to JSON editor';

    public function init() {
        if($this->hasModel())
        {
            $modelName = StringHelper::basename(get_class($this->model));
            $this->id = strtolower($modelName.'-'.$this->attribute);
            $this->class = strtolower($modelName.'-'.$this->attribute);
            $this->name = $modelName.'['.$this->attribute.']';
            $attributes = $this->model->getAttributes([$this->attribute]);
            $json = $attributes[$this->attribute];
            $this->data = $json;
        }
        $result = json_decode($this->data);
        if (json_last_error() > JSON_ERROR_NONE) {
            $this->data = '{}';
        }
        parent::run();
    }

    public function run() {

        parent::run();

        $this->registryScript();

        return $this->render('jsoneditor',[
            'id' => $this->id,
            'class' => $this->class,
            'name' => $this->name,
            'style' => $this->style,
            'inputButtonLabel' => $this->inputButtonLabel,
            'initButtonLabel' => $this->initButtonLabel,
        ]);
    }

    protected function registryScript()
    {
        $path = \Yii::$app->getAssetManager()->publish(dirname(__FILE__) . '/assets/');

        $this->getView()->registerCssFile($path[1] . '/css/jsoneditor.css');
        $this->getView()->registerJsFile(
            $path[1] . '/js/jquery.json-2.3.min.js',
            [
                'position' => \yii\web\View::POS_END,
                'depends'  => ['\yii\web\JqueryAsset'],
            ]
        );

        $this->getView()->registerJsFile(
            $path[1] . '/js/jquery.jsoneditor.js',
            [
                'position' => \yii\web\View::POS_END,
                'depends'  => ['\yii\web\JqueryAsset'],
            ]
        );
        $script =<<<JS
            if (typeof ids == 'undefined'){
                var ids = [];
            }
            ids.push({
                key: jQuery('#{$this->id}').attr('id'), 
                val: jQuery('#{$this->id}').attr('name')
            });
            jQuery('#{$this->id}').jsoneditor('init', { root : '{$this->rootNodeName}' , data: {$this->data} } );
            var form = jQuery('#{$this->id}').closest('form');
            form.unbind('submit').submit(function(e){
                $.each(ids,function(index,value){
                    var obj = $('#' + value.key);
                    obj.jsoneditor('input');
                    obj.children('textarea').attr('name', value.val);
                });
            });
JS;
        $this->getView()->registerJs($script,\yii\web\View::POS_END);

    }
}