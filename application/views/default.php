<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>The Netcircle - Translate Tool</title>
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
  <style>
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
    background-color: rgba(86, 61, 124, 0.15);
    border: 1px solid rgba(86, 61, 124, 0.2);
    padding-bottom: 10px;
    padding-top: 10px;
  }
  .messages div {
    height: 150px;
  }
  </style>
</head>
<body>
<?php echo $contents; ?>
</body>
</html>
