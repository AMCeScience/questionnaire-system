<link rel="stylesheet" href="/css/form_layout.css">
<link rel="stylesheet" href="/css/questionnaire.css">

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="/">Systematic Review Questionnaire</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item <?php echo ($tab_active === 'landing' ? 'active' : ''); ?>">
        <a class="nav-link" href="/questionnaire">Home</a>
      </li>
      <li class="nav-item <?php echo ($tab_active === 'software_check' ? 'active' : ''); ?>">
        <a class="nav-link" href="/questionnaire/software">Previous answers</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-warning" href="/questionnaire/form">Questionnaire</a>
      </li>
    </ul>
  </div>
</nav>

<div class="spacer"></div>