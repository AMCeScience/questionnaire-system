<fieldset class="form-group">
  <legend><?php echo $question; ?></legend>
  <input type="text" id="<?php echo $name; ?>-slider" name="<?php echo $name; ?>" value="0"/>
</fieldset>

<script>
  $(function() {
    $("#<?php echo $name; ?>-slider").ionRangeSlider({
      min: 0,
      max: <?php echo $answers; ?>
    });
  });
</script>