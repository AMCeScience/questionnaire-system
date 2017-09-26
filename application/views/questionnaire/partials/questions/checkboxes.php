<fieldset class="custom-controls-stacked <?php echo ($is_followup === true ? $name . '-container hidden' : ''); ?>">
  <legend><?php echo $question; ?></legend>
  <?php foreach($answers as $key => $option) { ?>
    <label class="custom-control custom-checkbox">
      <input name="<?php echo $name; ?>[]" type="checkbox" class="custom-control-input" value="<?php echo $key; ?>">
      <span class="custom-control-indicator"></span>
      <span class="custom-control-description"><?php echo $option; ?></span>
    </label>
  <?php } ?>
  <?php if ($other === true) { ?>
    <label class="custom-control custom-checkbox">
      <input name="<?php echo $name; ?>[]" type="checkbox" class="custom-control-input other-option" value="0">
      <span class="custom-control-indicator"></span>
      <span class="custom-control-description">Other (open)</span>
    </label>
    <div class="form-group hidden other-container">
      <label for="other">Other</label>
      <input name="<?php echo $name . '-open-input'; ?>" type="text" class="form-control" id="" placeholder="">
    </div>
  <?php } ?>
</fieldset>