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
        <?= form_dropdown('search_in', array('String Name', 'Poppen DE'), 1); ?>
        <select class="form-control" name="search_in">
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
          <input type="text" name="keyword" class="form-control" value="<?= $keyword; ?>">
          <div class="input-group-btn">
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="container-fluid">
<?php echo $page_links ? $page_links : '<hr />'; ?>
</div>

<div class="container-fluid">
  <?php foreach($page_messages as $string_name => $message): ?>
  <div class="list-group">
    <div class="list-group-item">
      <h4 class="list-group-item-heading"><?php echo $string_name; ?></h4>
      <h4><span class="label label-primary">Poppen Deutsch</span></h4>
      <textarea class="form-control" rows="3" readonly><?php echo isset($message['p']['trans_de']) ? $message['p']['trans_de'] : ''; ?></textarea>
      <hr />
      <h4><span class="label label-success">Poppen English</span></h4>
      <textarea class="form-control" rows="3" readonly><?php echo isset($message['p']['trans_en']) ? $message['p']['trans_en'] : ''; ?></textarea>
      <hr />
      <h4><span class="label label-danger">Poppen Española</span></h4>
      <textarea class="form-control" rows="3" readonly><?php echo isset($message['p']['trans_es']) ? $message['p']['trans_es'] : ''; ?></textarea>
      <hr />
      <h4><span class="label label-primary">Gays Deutsch</span></h4>
      <textarea class="form-control" rows="3" readonly><?php echo isset($message['g']['trans_de']) ? $message['g']['trans_de'] : ''; ?></textarea>
      <hr />
      <h4><span class="label label-success">Gays English</span></h4>
      <textarea class="form-control" rows="3" readonly><?php echo isset($message['g']['trans_en']) ? $message['g']['trans_en'] : ''; ?></textarea>
      <hr />
      <h4><span class="label label-danger">Gays Española</span></h4>
      <textarea class="form-control" rows="3" readonly><?php echo isset($message['g']['trans_es']) ? $message['g']['trans_es'] : ''; ?></textarea>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<div class="container-fluid">
<?php echo $page_links; ?>
</div>