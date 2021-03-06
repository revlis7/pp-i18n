<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>The Netcircle - Translate Tool</title>
  <link rel="stylesheet" type="text/css" href="/static/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/static/css/bootstrap-theme.min.css">
  <link rel="stylesheet" type="text/css" href="/static/css/bootstrap-dialog.css" />
  <script src="/static/js/jquery-1.11.0.min.js"></script>
  <script src="/static/js/jquery-migrate-1.2.1.min.js"></script>
  <script src="/static/js/bootstrap.min.js"></script>
  <script src="/static/js/jquery.cookie.js"></script>
  <script src="/static/js/bootstrap-dialog.js"></script>
  <style>
  body {
    padding-top: 160px;
  }
  header {
    background: white;
  }
  header .row {
    margin-top: 5px;
  }
  .top-blank {
    margin-top: 26px;
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
<?php echo $contents; ?>
</body>
</html>
