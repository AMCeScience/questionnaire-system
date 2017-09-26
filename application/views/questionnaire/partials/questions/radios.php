<fieldset class="custom-controls-stacked">
  <legend><?php echo $question; ?></legend>
  <?php foreach ($answers as $value => $answer) { ?>
    <label class="custom-control custom-radio">
      <input name="<?php echo $name; ?>" type="radio" class="custom-control-input" value="<?php echo $value; ?>">
      <span class="custom-control-indicator"></span>
      <span class="custom-control-description"><?php echo $answer; ?></span>
    </label>
  <?php } ?>
</fieldset>

<?php if ($followup) { ?>
  <script>
    $(function() {
      $('input[name=<?php echo $name; ?>]').change(function() {
        if ($(this).val() === 'yes') {
          $('.<?php echo $followup; ?>-container').css('display', 'flex');

          return;
        }

        $('.<?php echo $followup; ?>-container').hide();
      });
    });
  </script>
<?php } ?>