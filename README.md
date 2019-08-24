# JsonEditor widget for Yii2 Framework uses Json Editor plugin for jQuery

The extension uses Json Editor plugin by Author Jadesoul http://jadesoul.org for jQuery 
and makes user interface for changing json values.

![JsonEditor widget](http://yii2.kadastrcard.ru/uploads/jsoneditor.jpg)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run:

```bash
composer require slavkovrn/yii2-jsoneditor
```

or add

```bash
"slavkovrn/yii2-jsoneditor": "*"
```

to the require section of your `composer.json` file.

Usage
-----

Set link to extension in your view:

```php
<?php
use slavkovrn\jsoneditor\JsonEditorWidget;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
    <?php $ form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->widget(JsonEditorWidget::class,[
        'rootNodeName' => 'root1',
    ]) ?>

    <?= $form->field($model, 'email')->widget(JsonEditorWidget::class,[
        'rootNodeName' => 'root2',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>​
```
<a href="mailto:slavko.chita@gmail.com">write comments to admin</a>
