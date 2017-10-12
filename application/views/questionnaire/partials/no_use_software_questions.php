<div class="container">
  <form>
    <div data-list-name="generic" class="question-container generic-questions">
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
      </p>

      <?php $user_answers = $user_answers['generic']; ?>

      <?php foreach ($generic_questions as $question_number => $question_obj) {
        require ('questions/question.php');
      } ?>

      <?php $list_type = 'generic'; ?>

      <?php require('questions/comments.php'); ?>

      <a class="btn btn-primary btn-continue" href="/questionnaire" role="button">Next »</a>
    </div>
  </form>
</div>