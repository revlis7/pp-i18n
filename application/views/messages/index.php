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
      <?php foreach ($communities as $community => $community_name): ?>
        <?php $label = $community == 'poppen' ? 'label-danger' : 'label-primary'; ?>
        <?php $languages = $this->app->get_languages_by_community($community); ?>
        <?php foreach ($languages as $language): ?>
          <h4><span class="label <?php echo $label; ?>"><?php echo $community_name; ?> <?php echo $this->app->get_language_name($language); ?></span></h4>
          <textarea name="<?php echo $community; ?>-<?php echo $language; ?>-<?php echo $string_name; ?>" class="form-control" rows="3" readonly><?php echo isset($message[$community][$this->app->get_language_field($language)]) ? $message[$community][$this->app->get_language_field($language)] : ''; ?></textarea>
          <p class="action-box">
            <button name="save" type="button" class="btn btn-primary btn-sm" comm="<?php echo $community; ?>" lang="<?php echo $language; ?>" stn="<?php echo $string_name; ?>" >Save</button>
            <button type="button" class="btn btn-default btn-sm">Cancel</button>
          </p>
          <hr />
        <?php endforeach; ?>
      <?php endforeach; ?>
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
    var area_name = $(this).attr('comm') + '-' + $(this).attr('lang') + '-' + $(this).attr('stn');
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