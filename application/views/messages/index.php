<div class="container-fluid">
  <div class="row">
    <form role="form">
      <div class="col-lg-2">
        <label>Search in:</label>
        <?= form_dropdown('search', array('string_name' => 'String Name', 'translation' => 'Translation'), $search, 'class="form-control"'); ?>
      </div>
      <div class="col-lg-3">
        <label>Keyword:</label>
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
  <div class="row">
    <form role="form" autocomplete="off">
    <div class="col-lg-6">
      <div class="options-box">
        <select name="community-sel-left" class="form-control">
        <?php foreach($communities as $community => $community_name): ?>
          <option value="<?= $community; ?>" <?= $community == $current_community_left ? 'selected="selected"' : ''; ?>><?= $community_name; ?></option>
        <?php endforeach; ?>
        </select>
      </div>
      <div class="options-box">
        <select name="language-sel-left" class="form-control">
        <?php foreach($languages as $language => $language_name): ?>
          <option value="<?= $language; ?>" <?= $language == $current_language_left ? 'selected="selected"' : ''; ?>><?= $language_name; ?></option>
        <?php endforeach; ?>
        </select>
      </div>
      <div class="options-box">
        <button name="switch-btn-left" type="button" class="btn btn-primary">Go</button>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="options-box">
        <select name="community-sel-right" class="form-control">
        <?php foreach($communities as $community => $community_name): ?>
          <option value="<?= $community; ?>" <?= $community == $current_community_right ? 'selected="selected"' : ''; ?>><?= $community_name; ?></option>
        <?php endforeach; ?>
        </select>
      </div>
      <div class="options-box">
        <select name="language-sel-right" class="form-control">
        <?php foreach($languages as $language => $language_name): ?>
          <option value="<?= $language; ?>" <?= $language == $current_language_right ? 'selected="selected"' : ''; ?>><?= $language_name; ?></option>
        <?php endforeach; ?>
        </select>
      </div>
      <div class="options-box">
        <button name="switch-btn-right" type="button" class="btn btn-primary">Go</button>
      </div>
    </div>
    </form>
  </div>

  <?php foreach($page_messages as $string_name => $message): ?>
  <div class="row">
    <div class="col-lg-6">
      <div class="message-body" side="left">
        <h4><?= $string_name; ?></h4>
        <?php foreach($communities as $community => $community_name): ?>
          <?php foreach($languages as $language => $language_name): ?>
            <?php
              $data = $community.'_'.$language;
              $hide = $data == $current_community_left.'_'.$current_language_left ? false : true;
            ?>
            <p data="<?= $data; ?>" <?= $hide ? 'style="display:none;"': ''; ?>>
              <?php
                $raw_text = '';
                if (isset($message['poppen'][$this->app->get_language_field($language)])) {
                  $raw_text = $message['poppen'][$this->app->get_language_field($language)];
                }
              ?>
              <?php if (empty($raw_text)): ?>
                <span class="light-grey">
                <?= $language == 'en' ? 'STRING IS EMPTY' : ''; ?>
                <?= $language == 'de' ? 'ZEICHENKETTE IST LEER' : ''; ?>
                <?= $language == 'es' ? 'LA CADENA ES VACÍA' : ''; ?>
                </span>
              <?php else: ?>
                <?= htmlspecialchars($raw_text); ?>
              <?php endif; ?>
            </p>
          <?php endforeach; ?>
        <?php endforeach; ?>
        <hr class="hr-set" />
        <div>
          <span class="message-action">Delete</span>
          <span class="message-action">Edit</span>
          <span class="message-action">Preview</span>
          <div style="clear: both;"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="message-body" side="right">
        <h4><?= $string_name; ?></h4>
        <?php foreach($communities as $community => $community_name): ?>
          <?php foreach($languages as $language => $language_name): ?>
            <?php
              $data = $community.'_'.$language;
              $hide = $data == $current_community_right.'_'.$current_language_right ? false : true;
            ?>
            <p data="<?= $data; ?>" <?= $hide ? 'style="display:none;"': ''; ?>>
              <?php
                $raw_text = '';
                if (isset($message['poppen'][$this->app->get_language_field($language)])) {
                  $raw_text = $message['poppen'][$this->app->get_language_field($language)];
                }
              ?>
              <?php if (empty($raw_text)): ?>
                <span class="light-grey">
                <?= $language == 'en' ? 'STRING IS EMPTY' : ''; ?>
                <?= $language == 'de' ? 'ZEICHENKETTE IST LEER' : ''; ?>
                <?= $language == 'es' ? 'LA CADENA ES VACÍA' : ''; ?>
                </span>
              <?php else: ?>
                <?= htmlspecialchars($raw_text); ?>
              <?php endif; ?>
            </p>
          <?php endforeach; ?>
        <?php endforeach; ?>
      </div>
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

  var switchDisplay = function(side) {
    side == 'left' ? side : 'right';
    var community = $('select[name="community-sel-' + side + '"] option:selected').val();
    var language  = $('select[name="language-sel-' + side + '"] option:selected').val();
    console.log(community, language);
    $('.message-body[side="' + side + '"] > p').hide();
    $('.message-body[side="' + side + '"] > p[data="' + community + '_' + language + '"]').show();
  }

  $('button[name="search"]').click(redirectSearchPage);

  $('button[name="switch-btn-left"]').click(function() {
    switchDisplay('left');
  });

  $('button[name="switch-btn-right"]').click(function() {
    switchDisplay('right');
  });

  $('input[name="keyword"]').keypress(function(e) {
    if (e.which == 13) {
      e.preventDefault();
      redirectSearchPage();
    }
  });
});
</script>