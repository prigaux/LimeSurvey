<div class="input-group col-12">
    <?php if (isset($this->setting['aFormElementOptions']['inputGroup']['prefix'])) : ?>
        <div class="input-group-addon">
            <?= $this->setting['aFormElementOptions']['inputGroup']['prefix']; ?>
        </div>
    <?php endif; ?>
    <textarea
        class="form-control" 
        name="advancedSettings[<?= $this->setting['name']; ?>]"
        id="advancedSettings[<?= $this->setting['name']; ?>]"
      ></textarea>
    <?php if (isset($this->setting['aFormElementOptions']['inputGroup']['suffix'])) : ?>
        <div class="input-group-addon">
            <?= $this->setting['aFormElementOptions']['inputGroup']['suffix']; ?>
        </div>
    <?php endif; ?>
</div>