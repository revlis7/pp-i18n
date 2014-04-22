<?php echo $page_links; ?>

<div class="container-fluid">
  <?php foreach($page_messages as $string_name => $message): ?>
    <div class="row show-grid">
      <div class="col-md-10"><?php echo $string_name; ?></span></div>
      <div class="col-md-2"><a href="#"><span class="glyphicon glyphicon-trash"></span></a></div>
    </div>
    <div class="row show-grid messages">
        <div class="col-md-2 break"><?php echo isset($message['p']['trans_de']) ? $message['p']['trans_de'] : ''; ?></div>
        <div class="col-md-2 break"><?php echo isset($message['p']['trans_en']) ? $message['p']['trans_en'] : ''; ?></div>
        <div class="col-md-2 break"><?php echo isset($message['p']['trans_es']) ? $message['p']['trans_es'] : ''; ?></div>
        <div class="col-md-2 break"><?php echo isset($message['g']['trans_de']) ? $message['g']['trans_de'] : ''; ?></div>
        <div class="col-md-2 break"><?php echo isset($message['g']['trans_en']) ? $message['g']['trans_en'] : ''; ?></div>
        <div class="col-md-2 break"><?php echo isset($message['g']['trans_es']) ? $message['g']['trans_es'] : ''; ?></div>
    </div>
    <?php endforeach; ?>
</div>

<?php echo $page_links; ?>