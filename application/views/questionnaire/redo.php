<script src="/js/redo.js"></script>

<div class="container main-container">
  <div class="alert alert-info">
    <h3>Thank you for completing the questionnaire!</h3>

    We would like to gather data on as many tools as possible.
    You indicated that you are using more than one tool.<br/>
    Answer below whether you want to redo the questionnaire for another tool (<span class="text-danger">this takes approximately 10 minutes</span>).
  </div>

  <div class="container">
    <div class="row">
      <div class="col-12">
        <legend>For which tool would you like to fill out the questionnaire?</legend>
        
        <select class="form-control">
          <option value="">Please select an option</option>
          <?php foreach ($interesting_software as $software_id => $name) { ?>
            <option value="<?php echo $software_id; ?>"><?php echo $name; ?></option>
          <?php } ?>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="col-3">
        <a class="btn btn-continue" href="/questionnaire" role="button">Exit</a>
      </div>

      <div class="col-9">
        <a class="btn btn-primary btn-continue btn-redo" href="/questionnaire/form/1" role="button">Next</a>
      </div>
    </div>
  </div>
</div>