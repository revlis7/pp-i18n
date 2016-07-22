<style type="text/css">
body {
  padding-top: 15px;
}
</style>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-6">
      <div side="left">
        <p>Collection: <?= $this->config->item('poppen_collection'); ?></p>
        <p>Diff entries: <?= count($page_messages); ?></p>
      </div>
    </div>
    <div class="col-lg-6">
      <p>Collection: <?= $this->config->item('gays_collection'); ?></p>
    </div>
  </div>
</div>
<div class="container-fluid">
  <?php foreach($page_messages as $string_name => $message): ?>
  <div class="row">
    <div class="col-lg-6">
      <div class="message-body" side="left">
        <h4 class="message-name"><?= htmlspecialchars($string_name); ?></h4>
        <?php if (empty($message['L'])): ?>
          <p class="message-text">
            <span class="light-grey">STRING IS EMPTY</span>
          </p>
        <?php else: ?>
          <p class="message-text"><?= htmlspecialchars($message['L']); ?></p>
          <hr class="hr-set" />
          <div class="message-action">
            <span class="message-hint">Last Update: <span class="message-hint-ts"><?= date('Y-m-d H:i:s', $message['L_TS']); ?></span></span>
          </div>
          <div style="clear: both;"></div>
        <?php endif; ?>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="message-body" side="right">
        <h4 class="message-name"><?= htmlspecialchars($string_name); ?></h4>
        <?php if (empty($message['R'])): ?>
          <p class="message-text">
            <span class="light-grey">STRING IS EMPTY</span>
          </p>
        <?php else: ?>
          <p class="message-text"><?= htmlspecialchars($message['R']); ?></p>
          <hr class="hr-set" />
          <div class="message-action">
            <span class="message-hint">Last Update: <span class="message-hint-ts"><?= date('Y-m-d H:i:s', $message['R_TS']); ?></span></span>
          </div>
          <div style="clear: both;"></div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>