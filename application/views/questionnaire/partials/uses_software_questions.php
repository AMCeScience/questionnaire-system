<div class="container main-form-container">
  <form>
    <?php if ($form_page * 1 == 0 || is_null($form_page)) { ?>
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

        <div class="row btn-page-change">
          <div class="col-12">
            <a class="btn btn-primary btn-continue" href="/questionnaire/form/1" role="button">Next »</a>
          </div>
        </div>
      </div>
    <?php } ?>

    <?php if ($form_page * 1 == 1) { ?>
      <div data-list-name="specific" class="question-container tool-specific-questions">
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </p>

        <?php require('questions/software_pick.php'); ?>

        <?php $user_answers = $user_answers['specific']; ?>

        <?php foreach ($tool_questions as $question_number => $question_obj) {
          require ('questions/question.php');
        } ?>

        <?php $list_type = 'specific'; ?>

        <?php require('questions/comments.php'); ?>

        <div class="row btn-page-change">
          <div class="col-4"><a class="btn btn-previous row-btn" href="/questionnaire/form" role="button">Previous</a></div>
          <div class="col-8"><a class="btn btn-primary btn-continue row-btn" href="/questionnaire/form/2" role="button">Next »</a></div>
        </div>
      </div>
    <?php } ?>

    <?php if ($form_page * 1 == 2) { ?>
      <div data-list-name="usability" class="question-container usability-questions">
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </p>

        <?php require('questions/software_pick.php'); ?>

        <?php $user_answers = $user_answers['usability']; ?>

        <?php foreach ($sus_questions as $question_number => $question_obj) {
          require ('questions/question.php');
        } ?>

        <?php $list_type = 'usability'; ?>

        <?php require('questions/comments.php'); ?>

        <div class="row btn-page-change">
          <div class="col-4"><a class="btn btn-previous row-btn" href="/questionnaire/form/1" role="button">Previous</a></div>
          <div class="col-8"><a class="btn btn-primary btn-continue row-btn" href="/questionnaire/redo" role="button">Next »</a></div>
        </div>
      </div>
    <?php } ?>
  </form>
</div>