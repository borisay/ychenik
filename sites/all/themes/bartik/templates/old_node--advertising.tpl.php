<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php if (!$page): ?>
    <h2<?php print $title_attributes; ?>>
      <a href="<?php print $node_url; ?>"><?php print $title; ?></a>
    </h2>
  <?php endif; ?>
  <?php print render($title_suffix); ?>

  <?php if ($display_submitted): ?>
    <div class="meta submitted">
      <?php print $user_picture; ?>
      <?php print $submitted; ?>
    </div>
  <?php endif; ?>

  <div class="content clearfix"<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      print render($content);
    ?>
  </div>

  <?php
    // Remove the "Add new comment" link on the teaser page or if the comment
    // form is being displayed on the same page.
    if ($teaser || !empty($content['comments']['comment_form'])) {
      unset($content['links']['comment']['#links']['comment-add']);
    }
    // Only display the wrapper div if there are links.
    $links = render($content['links']);
    if ($links):
  ?>
    <div class="link-wrapper">
      <?php print $links; ?>
    </div>
  <?php endif; ?>

  <?php print render($content['comments']);?> 

</div>

<?php
/*    $date = getdate();
		$node = node_load($node->nid);
    if(!empty($node->field_ad_finish['und'][0]['value']) ) { //w/o got "Notice: Undefined index:..."
		$finish = $node->field_ad_finish['und'][0]['value'];
		$remain = $finish-$date[0];
      $d_r = round($remain/(60*60*24));
			$h_r = ($remain/(60*60))%24;
			$m_r = ($remain/60)%60;
			if ($remain >=0) {
				$node->field_ad_status['und'][0]['value'] = 'Active';
				$node->field_ad_remain['und'][0]['value'] = $d_r.' days '.$h_r.' hours';

				field_attach_update('node', $node);
				
			}else{
				$node->field_ad_status['und'][0]['value'] = 'Complete';
				$node->field_ad_remain['und'][0]['value'] = '0 days  0 hours';	
		    
				field_attach_update('node', $node);
				
		  }
	  }
*/	
?>