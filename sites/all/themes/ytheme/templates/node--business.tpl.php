<?php
/**
 * Ytheme's theme implementation to display a node.
 */
?>
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

  <div class="content clearfix"
  <?php 
  print $content_attributes; 
  ?>
  >
    <div class="business-column1">
    <?php
      // We make the first column and hide the field for the second column and 
	    //the comments and links now so that we can render them later
      hide($content['comments']);
      hide($content['links']);
	    hide($content['field_image']);
	    hide($content['field_description']);	  
      print render($content);
						
      if(isset($node->field_website['und'][0]['value'])) { ?>
        <div class="web_link">
          <?php print $biz_web_link; ?>
        </div>
      <?php
      }
      if(isset($node->field_fb_page['und'][0]['value'])) { ?>
        <div class="fb_link">
          <?php print $fb_page_link; ?>
        </div>
      <?php
      }
    		
		?>
      <div class="social-buttons">
        <iframe src="http://www.facebook.com/plugins/like.php?href=<?php $curr_url = check_plain("http://" .$_SERVER['HTTP_HOST'] .$node_url); echo $curr_url; ?>&amp;layout=button_count&amp;show_faces=false&amp;width=200&amp;action=like&amp;font=verdana&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border    :none; overflow:hidden; width:130px; height:21px;" allowTransparency="true"></iframe>    
      </div>
    
    </div>
    <div class="business-column2">
    <?php
      // We make second column for 'business' pictures 
	    // print ('This is the div for the column 2');
      print render($content['field_image']);
	    print render($content['field_description']);
    ?>
    </div>
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

  <?php print render($content['comments']); ?>
  
  <?php
  if(!empty($node->field_rating['und'][0]['average']) && !empty($node->field_rating['und'][0]['count'])) {
//  if(array_key_exists('average', $node->field_rating['und'][0]) && array_key_exists('count', $node->field_rating['und'][0]) && !empty($node->field_rating['und'][0]['average']) && !empty($node->field_rating['und'][0]['count'])) {
//creating dublicate fields for 'Average' and 'Count'
//in fields 'Rate' and 'Review'
	  
//		var_dump($node->field_rating['und'][0]);
    $node = node_load($node->nid);
    if(isset($node->field_rating['und'][0]['average'])) { //w/o got "Notice: Undefined index:..."
      $node->field_rate['und'][0]['value'] = $node->field_rating['und'][0]['average'];
    }
    if(isset($node->field_rating['und'][0]['count'])) {
      $node->field_review['und'][0]['value'] = $node->field_rating['und'][0]['count'];
    }			
      field_attach_update('node', $node);
	}
  ?>
</div>