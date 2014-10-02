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
        <?= form_dropdown('search', $this->app->get_search_range_list(), $search, 'class="form-control"'); ?>
      </div>
      <div class="col-lg-3">
        <div class="input-group">
          <input type="text" name="keyword" class="form-control" value="<?= $keyword; ?>">
          <div class="input-group-btn">
            <button name="search" type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
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
      <h4><span class="label label-danger">Poppen Deutsch</span></h4>
      <textarea name="poppen-de-<?php echo $string_name; ?>" class="form-control" rows="3" readonly><?php echo isset($message['p']['trans_de']) ? $message['p']['trans_de'] : ''; ?></textarea>
      <p class="action-box">
        <button name="save" type="button" class="btn btn-primary btn-sm" comm="poppen" lang="de" stn="<?php echo $string_name; ?>" >Save</button>
        <button type="button" class="btn btn-default btn-sm">Cancel</button>
      </p>
      <hr />
      <h4><span class="label label-danger">Poppen English</span></h4>
      <textarea name="poppen-en-<?php echo $string_name; ?>" class="form-control" rows="3" readonly><?php echo isset($message['p']['trans_en']) ? $message['p']['trans_en'] : ''; ?></textarea>
      <p class="action-box">
        <button name="save" type="button" class="btn btn-primary btn-sm" comm="poppen" lang="en" stn="<?php echo $string_name; ?>" >Save</button>
        <button type="button" class="btn btn-default btn-sm">Cancel</button>
      </p>
      <hr />
      <h4><span class="label label-danger">Poppen Española</span></h4>
      <textarea class="form-control" rows="3" readonly><?php echo isset($message['p']['trans_es']) ? $message['p']['trans_es'] : ''; ?></textarea>
      <hr />
      <h4><span class="label label-primary">Gays Deutsch</span></h4>
      <textarea class="form-control" rows="3" readonly><?php echo isset($message['g']['trans_de']) ? $message['g']['trans_de'] : ''; ?></textarea>
      <hr />
      <h4><span class="label label-primary">Gays English</span></h4>
      <textarea class="form-control" rows="3" readonly><?php echo isset($message['g']['trans_en']) ? $message['g']['trans_en'] : ''; ?></textarea>
      <hr />
      <h4><span class="label label-primary">Gays Española</span></h4>
      <textarea class="form-control" rows="3" readonly><?php echo isset($message['g']['trans_es']) ? $message['g']['trans_es'] : ''; ?></textarea>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<div class="container-fluid">
<?php echo $page_links; ?>
</div>

<script>
$(document).ready(function() {
  var redirectSearchPage = function() {
    var search  = $('select[name="search"] option:selected').val();
    var keyword = $('input[name="keyword"]').val();
    var uri = '/search/' + search + '/keyword/' + keyword;
    window.location = uri;
  };

  $('button[name="search"]').click(redirectSearchPage);

  $('input[name="keyword"]').keypress(function(e) {
    if (e.which == 13) {
      e.preventDefault();
      redirectSearchPage();
    }
  });

  $('button[name="save"]').click(function() {
    // console.log($(this).attr('comm'));
    // console.log($(this).attr('lang'));
    // console.log($(this).attr('stn'));
    var area_name = $(this).attr('comm') + '-' + $(this).attr('lang') + '-' + $(this).attr('stn');
    // console.log($('textarea[name="' + area_name + '"]').val());
    var message = $('textarea[name="' + area_name + '"]').val();

    $.ajax({
      type: "POST",
      url: "/messages/save",
      data: {
        'comm': $(this).attr('comm'),
        'lang': $(this).attr('lang'),
        'stn':  $(this).attr('stn'),
        'message': message
      },
      success: function(data) {console.log(data.r)},
      dataType: "json"
    });
  });
});
</script>