<!--div class="form-group">
  <label for=""></label>
  <input type="text" class="form-control" id="" placeholder="">
</div-->

<?php foreach ($generic_questions as $question_obj) {
  require ('questions/question.php');
} ?>