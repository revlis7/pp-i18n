<div class="container-fluid">
  <div class="row">
    <div class="col-lg-2">
      <label>Search in:</label>
    </div>
    <div class="col-lg-3">
      <label>Keyword:</label>
    </div>
  </div>
  <div class="row">
    <form role="form">
      <div class="col-lg-2">
        <select class="form-control">
            <option value="0">String Name</option>
            <option value="1">Poppen DE</option>
            <option value="2">Poppen EN</option>
            <option value="3">Poppen ES</option>
            <option value="4">Gays DE</option>
            <option value="5">Gays EN</option>
            <option value="6">Gays ES</option>
        </select>
      </div>
      <div class="col-lg-3">
        <div class="input-group">
          <input type="text" class="form-control">
          <div class="input-group-btn">
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="container-fluid">
<?php echo $page_links; ?>
</div>

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

<div class="container-fluid">
<?php echo $page_links; ?>
</div>