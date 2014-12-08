<div class="<?php print $classes; ?>">
  
  <?php if ($exposed): ?>
    <div class="view-filters">
      <?php print $exposed; ?>
    </div>
  <?php endif; ?>
  
  <?php
    $view = views_get_current_view();
    $res = $view->total_rows;
    if ($view -> total_rows !== NULL && $view->name == 'search') { ?>
      <div class="counter_rows">
        <?php print '"'.$view->total_rows.'"'.' Businesses found in your search'; ?>
      </div>  
  <?php } ?> 

  <?php if ($rows): ?>
    <div class="view-content">
      <?php print $rows; ?>
    </div>
  <?php elseif ($empty): ?>
    <div class="view-empty">
      <?php print $empty; ?>
    </div>
  <?php endif; ?>

  <?php if ($pager): ?>
    <?php print $pager; ?>
  <?php endif; ?>

</div><?php /* class view */ ?>

