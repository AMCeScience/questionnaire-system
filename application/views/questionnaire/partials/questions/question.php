<?php
  $name = $question_obj['name'];
  $type = $question_obj['type'];
  $question = $question_obj['question'];
  $answers = $question_obj['answers'];
  $other = $question_obj['other'];
  $is_followup = isset($question_obj['is_follow_up']) ? $question_obj['is_follow_up'] : '';
  $followup = isset($question_obj['follow_up']) ? $question_obj['follow_up'] : '';

  switch ($type) { 
    case 'checkbox':
      require('checkboxes.php');
      
      break;
    case 'scale':
      require('scales.php');

      break;
    case 'radio':
      require('radios.php');

      break;
  }
?>

<script>

</script>