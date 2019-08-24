<div class="json-editor">
    <input onclick="$('#<?= $id ?>').jsoneditor('input')" type="button" value="<?= $inputButtonLabel ?>" />
    <input onclick="$('#<?= $id ?>').jsoneditor('init')" type="button" value="<?= $initButtonLabel ?>" />
    <div id="<?= $id ?>" class="<?= $class ?>" name="<?= $name ?>" style="<?= $style ?>" ></div>
</div>
