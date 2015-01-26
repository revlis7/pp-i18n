<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>The Netcircle - Translate Tool</title>
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
  <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
  <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
  <script src="/static/js/jquery.cookie.js"></script>
  <style>
  body {
    padding-top: 150px;
  }
  header {
    background: white;
  }
  .break {
    -ms-word-break: break-all;
    word-break: break-all;

    /* Non standard for webkit */
    word-break: break-word;

    -webkit-hyphens: auto;
    -moz-hyphens: auto;
    hyphens: auto;
    overflow: auto;
  }
  .show-grid [class^="col-"] {
    /* background-color: rgba(86, 61, 124, 0.15); */
    border: 1px solid rgba(86, 61, 124, 0.2);
    padding-bottom: 10px;
    padding-top: 10px;
  }
  .messages div {
    height: 150px;
  }
  .action-box {
    margin-top: 10px;
  }
  .options-box {
    float: left;
    padding-bottom: 15px;
    width: 16.66666667%;
    margin-right: 15px;
  }
  .message-body {
    border: 2px dashed #c0c0c0;
    border-radius: 5px;
    margin-bottom: 15px;
    padding: 10px;
  }
  .message-name {
    word-break: break-all;
  }
  .light-grey {
    color: #cccccc;
  }
  .hr-set {
    margin-top: 0px;
    margin-bottom: 10px;
  }
  .message-hint {
    float: left;
    font-size: 0.7em;
    margin-right: 15px;
  }
  .message-action .action-link {
    float: right;
    font-size: 0.7em;
    margin-left: 15px;
  }
  .message-create {
    float: right;
  }
  .message-edit {
    margin: 0 0 10px;
  }
  </style>
</head>
<body>
  <!-- <header id="top" class="navbar navbar-inverse navbar-static-top bs-docs-nav" role="banner">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="/ ">Translate Tool</a>
      </div>
      <nav role="navigation" class="collapse navbar-collapse bs-navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="javascript:void();">Settings</a></li>
        </ul>
      </nav>
    </div>
  </header> -->
<?php echo $contents; ?>
</body>
</html>
