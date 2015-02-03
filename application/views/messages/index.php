<header id="top" class="navbar navbar-fixed-top bs-docs-nav" role="banner">
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
    <hr />
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
        <!-- <button name="switch-btn-left" type="button" class="btn btn-primary">Go</button> -->
        <button name="create-btn-left" type="button" class="btn btn-danger message-create">Create</button>
        <div style="clear: both;"></div>
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
        <!-- <button name="switch-btn-right" type="button" class="btn btn-primary">Go</button> -->
        <button name="create-btn-right" type="button" class="btn btn-danger message-create">Create</button>
        <div style="clear: both;"></div>
      </div>
      </form>
    </div>
  </div>
</header>

<div class="container-fluid">
  <?php foreach($page_messages as $string_name => $message): ?>
  <?php $update_ts = 0; ?>
  <div class="row">
    <div class="col-lg-6">
      <div class="message-body" side="left">
        <h4 class="message-name"><?= $string_name; ?></h4>
        <?php foreach($communities as $community => $community_name): ?>
          <?php foreach($languages as $language => $language_name): ?>
            <?php
              $data = $community.'_'.$language;
              $raw_text = '';
              if (isset($message[$community][$this->app->get_language_field($language)])) {
                $raw_text = $message[$community][$this->app->get_language_field($language)];
              }
            ?>
            <?php if (empty($raw_text)): ?>
              <p class="message-text" data="<?= $data; ?>" data-empty="true" style="display:none;">
                <span class="light-grey">STRING IS EMPTY</span>
              </p>
            <?php else: ?>
              <p class="message-text" data="<?= $data; ?>" style="display:none;"><?= htmlspecialchars($raw_text); ?></p>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endforeach; ?>
        <textarea class="form-control message-edit" rows="5" style="display: none;"></textarea>
        <hr class="hr-set" />
        <div class="message-action">
          <?php foreach($communities as $community => $community_name): ?>
            <span data="<?= $community; ?>" class="message-hint" style="display:none;">Last Update: <span class="message-hint-ts"><?= date('Y-m-d H:i:s', $message[$community]['updated_at']); ?></span></span>
          <?php endforeach; ?>
          <div class="action-base">
            <span class="action-link">Delete</span>
            <span class="action-link"><a class="btn-edit" href="javascript:void(0);">Edit</a></span>
            <span class="action-link">Preview</span>
          </div>
          <div class="action-edit" style="display:none;">
            <span class="action-link"><a class="btn-cancel" href="javascript:void(0);">Cancel</a></span>
            <span class="action-link"><a class="btn-save" href="javascript:void(0);">Save</a></span>
          </div>
          <div style="clear: both;"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="message-body" side="right">
        <h4 class="message-name"><?= $string_name; ?></h4>
        <?php foreach($communities as $community => $community_name): ?>
          <?php foreach($languages as $language => $language_name): ?>
            <?php
              $data = $community.'_'.$language;
              $raw_text = '';
              if (isset($message[$community][$this->app->get_language_field($language)])) {
                $raw_text = $message[$community][$this->app->get_language_field($language)];
              }
            ?>
            <?php if (empty($raw_text)): ?>
              <p class="message-text" data="<?= $data; ?>" data-empty="true" style="display:none;">
                <span class="light-grey">STRING IS EMPTY</span>
              </p>
            <?php else: ?>
              <p class="message-text" data="<?= $data; ?>" style="display:none;"><?= htmlspecialchars($raw_text); ?></p>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endforeach; ?>
        <textarea class="form-control message-edit" rows="5" style="display: none;"></textarea>
        <hr class="hr-set" />
        <div class="message-action">
          <?php foreach($communities as $community => $community_name): ?>
            <span data="<?= $community; ?>" class="message-hint" style="display:none;">Last Update: <span class="message-hint-ts"><?= date('Y-m-d H:i:s', $message[$community]['updated_at']); ?></span></span>
          <?php endforeach; ?>
          <div class="action-base">
            <span class="action-link">Delete</span>
            <span class="action-link"><a class="btn-edit" href="javascript:void(0);">Edit</a></span>
            <span class="action-link">Preview</span>
          </div>
          <div class="action-edit" style="display:none;">
            <span class="action-link"><a class="btn-cancel" href="javascript:void(0);">Cancel</a></span>
            <span class="action-link"><a class="btn-save" href="javascript:void(0);">Save</a></span>
          </div>
          <div style="clear: both;"></div>
        </div>
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
    var params = {
      search  : $('select[name="search"] option:selected').val(),
      keyword : $('input[name="keyword"]').val()
    };
    var uri = '/messages/search?' + $.param(params);
    window.location = uri;
  };

  var getCommunity = function(side) {
    side == 'left' ? side : 'right';
    return $('select[name="community-sel-' + side + '"] option:selected').val();
  }

  var getLanguage = function(side) {
    side == 'left' ? side : 'right';
    return $('select[name="language-sel-' + side + '"] option:selected').val();
  }

  var switchDisplay = function(side) {
    side == 'left' ? side : 'right';
    var community = getCommunity(side);
    var language  = getLanguage(side);

    $('.message-body[side="' + side + '"] > p').hide();
    $('.message-body[side="' + side + '"] > textarea').hide();
    $('.message-body[side="' + side + '"] > .message-action > .action-base').show();
    $('.message-body[side="' + side + '"] > .message-action > .action-edit').hide();
    $('.message-body[side="' + side + '"] > p[data="' + community + '_' + language + '"]').show();
    $('.message-body[side="' + side + '"] > .message-action > .message-hint').hide();
    $('.message-body[side="' + side + '"] > .message-action > .message-hint[data="' + community + '"]').show();

    $.cookie("community_" + side, community, { expires : <?= $this->app->get('cookie_expiration'); ?>, path : '/' });
    $.cookie("language_" + side, language, { expires : <?= $this->app->get('cookie_expiration'); ?> , path : '/'});
  }

  $('button[name="search"]').click(redirectSearchPage);

  $('select[name="community-sel-left"]').change(function() {
    switchDisplay('left');
  });

  $('select[name="language-sel-left"]').change(function() {
    switchDisplay('left');
  });

  $('select[name="community-sel-right"]').change(function() {
    switchDisplay('right');
  });

  $('select[name="language-sel-right"]').change(function() {
    switchDisplay('right');
  });

  $('input[name="keyword"]').keypress(function(e) {
    if (e.which == 13) {
      e.preventDefault();
      redirectSearchPage();
    }
  });

  $('.btn-edit').click(function() {
    $(this).parents('.message-body').find('p.message-text').hide();

    var side = $(this).parents('.message-body').attr('side');
    var community = getCommunity(side);
    var language  = getLanguage(side);

    var textarea = $(this).parents('.message-body').find('textarea');
    var text_dom = $(this).parents('.message-body').find('p[data="' + community + '_' + language + '"]');

    // do not show 'string is empty' sentence in textarea
    if (!text_dom.attr('data-empty')) {
      textarea.val(text_dom.text());
    }
    textarea.show();

    $(this).parents('.message-body').find('div.action-base').hide();
    $(this).parents('.message-body').find('div.action-edit').show();
  });

  $('.btn-save').click(function() {
    var side = $(this).parents('.message-body').attr('side');
    var community = getCommunity(side);
    var language  = getLanguage(side);
    var string_name = $(this).parents('.message-body').find('h4.message-name').html();

    var p_box       = $(this).parents('.message-body').find('p[data="' + community + '_' + language + '"]');
    var textarea    = $(this).parents('.message-body').find('textarea');
    var action_base = $(this).parents('.message-body').find('div.action-base');
    var action_edit = $(this).parents('.message-body').find('div.action-edit');
    var update_ts   = $(this).parents('.message-body').find('span.message-hint[data="' + community + '"] > .message-hint-ts');

    var data = {
      'comm' : community,
      'lang' : language,
      'stn'  : string_name,
      'message' : textarea.val()
    }
    $.ajax({
      type: "POST",
      url: '/messages/save',
      data: data,
      success: function(result) {
        if (result.r == 'ok') {
          textarea.hide();
          p_box.html(result.message);
          if (result.message == '') {
            p_box.html('<span class="light-grey">STRING IS EMPTY</span>');
          }
          if (result.update_ts) {
            update_ts.html(result.update_ts);
          }
          p_box.show();
          action_base.show();
          action_edit.hide();
        }
      },
      dataType: 'json'
    });
  });

  $('.btn-cancel').click(function() {
    var side = $(this).parents('.message-body').attr('side');
    var community = getCommunity(side);
    var language  = getLanguage(side);
    var string_name = $(this).parents('.message-body').find('h4.message-name').html();

    var p_box       = $(this).parents('.message-body').find('p[data="' + community + '_' + language + '"]');
    var textarea    = $(this).parents('.message-body').find('textarea');
    var action_base = $(this).parents('.message-body').find('div.action-base');
    var action_edit = $(this).parents('.message-body').find('div.action-edit');

    textarea.val('').hide();
    p_box.show();
    action_base.show();
    action_edit.hide();
  });

  switchDisplay('left');
  switchDisplay('right');
});
</script>