<?php

/**
 * Add body classes if certain regions have content.
 */
function ytheme_preprocess_html(&$variables) {
  if (!empty($variables['page']['featured'])) {
    $variables['classes_array'][] = 'featured';
  }

  if (!empty($variables['page']['triptych_first'])
    || !empty($variables['page']['triptych_middle'])
    || !empty($variables['page']['triptych_last'])) {
    $variables['classes_array'][] = 'triptych';
  }

  if (!empty($variables['page']['footer_firstcolumn'])
    || !empty($variables['page']['footer_secondcolumn'])
    || !empty($variables['page']['footer_thirdcolumn'])
    || !empty($variables['page']['footer_fourthcolumn'])) {
    $variables['classes_array'][] = 'footer-columns';
  }

  // Add conditional stylesheets for IE
  drupal_add_css(path_to_theme() . '/css/ie.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 7', '!IE' => FALSE), 'preprocess' => FALSE));
  drupal_add_css(path_to_theme() . '/css/ie6.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'IE 6', '!IE' => FALSE), 'preprocess' => FALSE));
  drupal_add_css('http://fonts.googleapis.com/css?family=Squada One',array('type' => 'external'));
  drupal_add_css('http://fonts.googleapis.com/css?family=Viga',array('type' => 'external'));
}

/**
 * Override or insert variables into the page template for HTML output.
 */
function ytheme_process_html(&$variables) {
  // Hook into color.module.
  if (module_exists('color')) {
    _color_html_alter($variables);
  }
}

/**
 * Override or insert variables into the page template.
 */
function ytheme_process_page(&$variables) {
  // Hook into color.module.
  if (module_exists('color')) {
    _color_page_alter($variables);
  }
  // Always print the site name and slogan, but if they are toggled off, we'll
  // just hide them visually.
  $variables['hide_site_name']   = theme_get_setting('toggle_name') ? FALSE : TRUE;
  $variables['hide_site_slogan'] = theme_get_setting('toggle_slogan') ? FALSE : TRUE;
  if ($variables['hide_site_name']) {
    // If toggle_name is FALSE, the site_name will be empty, so we rebuild it.
    $variables['site_name'] = filter_xss_admin(variable_get('site_name', 'Drupal'));
  }
  if ($variables['hide_site_slogan']) {
    // If toggle_site_slogan is FALSE, the site_slogan will be empty, so we rebuild it.
    $variables['site_slogan'] = filter_xss_admin(variable_get('site_slogan', ''));
  }
  // Since the title and the shortcut link are both block level elements,
  // positioning them next to each other is much simpler with a wrapper div.
  if (!empty($variables['title_suffix']['add_or_remove_shortcut']) && $variables['title']) {
    // Add a wrapper div using the title_prefix and title_suffix render elements.
    $variables['title_prefix']['shortcut_wrapper'] = array(
      '#markup' => '<div class="shortcut-wrapper clearfix">',
      '#weight' => 100,
    );
    $variables['title_suffix']['shortcut_wrapper'] = array(
      '#markup' => '</div>',
      '#weight' => -99,
    );
    // Make sure the shortcut link is the first item in title_suffix.
    $variables['title_suffix']['add_or_remove_shortcut']['#weight'] = -100;
  }
}

/**
 * Override or insert variables into the node template.
 */
function ytheme_preprocess_node(&$variables) {
  if ($variables['view_mode'] == 'full' && node_is_page($variables['node'])) {
    $variables['classes_array'][] = 'node-full';
  }
  $node = $variables['node'];
  $variables['full_url'] = url('node/' . $node->nid, array('absolute' => TRUE));
  if ($node->type == 'business') {
    if (isset($node->field_website[LANGUAGE_NONE][0]['value'])) {
      $uri = $node->field_website[LANGUAGE_NONE][0]['value'];
      $uri_trim = ltrim($uri);
      $four_uri = substr ($uri_trim, 0, 4);
      if ($four_uri != 'http') {
        $url = substr_replace($uri_trim, 'http://',0,0);
      } 
      else {
        $url = $uri_trim;
      }		
      $text = 'Website link';
      $variables['biz_web_link'] = l($text, $url);
    }	
    if (isset($node->field_fb_page[LANGUAGE_NONE][0]['value'])) {
      $uri = $node->field_fb_page[LANGUAGE_NONE][0]['value'];
      $uri_trim = ltrim($uri);
      $four_uri = substr ($uri_trim, 0, 4);
      if ($four_uri != 'http') {
        $urlf = substr_replace($uri_trim, 'http://',0,0);
      } 
      else {
        $urlf = $uri_trim;
      }		
      $text = 'Facebook page';
      $variables['fb_page_link'] = l($text, $urlf);
    }			
  }
//  code for fb-share
//  if ($node->type == 'blog') {
//    $testmessage = 'Get a life!';
//    $variables['testmessage'] = $testmessage;
//  }
}

/**
 * Override or insert variables into the block template.
 */
function ytheme_preprocess_block(&$variables) {
  // In the header region visually hide block titles.
  if ($variables['block']->region == 'header') {
    $variables['title_attributes_array']['class'][] = 'element-invisible';
  }	
}

/**
 * Implements theme_menu_tree().
 */
function ytheme_menu_tree($variables) {
  return '<ul class="menu clearfix">' . $variables['tree'] . '</ul>';
}

/**
 * Implements theme_field__field_type().
 */
function ytheme_field__taxonomy_term_reference($variables) {
  $output = '';

  // Render the label, if it's not hidden.
  if (!$variables['label_hidden']) {
    $output .= '<h3 class="field-label">' . $variables['label'] . ': </h3>';
  }

  // Render the items.
  $output .= ($variables['element']['#label_display'] == 'inline') ? '<ul class="links inline">' : '<ul class="links">';
  foreach ($variables['items'] as $delta => $item) {
    $output .= '<li class="taxonomy-term-reference-' . $delta . '"' . $variables['item_attributes'][$delta] . '>' . drupal_render($item) . '</li>';
  }
  $output .= '</ul>';

  // Render the top-level DIV.
  $output = '<div class="' . $variables['classes'] . (!in_array('clearfix', $variables['classes_array']) ? ' clearfix' : '') . '"' . $variables['attributes'] .'>' . $output . '</div>';

  return $output;
}

/**
 * Add a class to third tab
 */
function ytheme_menu_local_tasks_alter(&$data,$router_item, &$root_path) {
  if ($root_path == 'user/register' || $root_path == 'user' || $root_path == 'user/password') {
        //add classes to the tabs. I left out tab 0 which is the active tab
        //and styled differently. It comes with active as a class.
    $tab2 = &$data['tabs'][0]['output'][2];
    $tab2['#link']['localized_options']['attributes']['class'][] = 'fb_tab';
  }
}
/**
 * Rename the user/login page
 */
function ytheme_preprocess_page(&$vars){
  $path = $_GET['q'];
  if ($path == 'user/login') {
    drupal_set_title('User account');
  }
}
/**
 * 
 */
function ytheme_preprocess_views_view_table(&$vars) {
  $view = $vars['view'];
  $rows = $vars['rows'];
  if ($view->name == 'search') { 
    foreach ($rows as $id => $row) {
      $data = $view->result[$id];
      $paid = $data->field_data_field_paid_field_paid_value;
      if ($paid == 1) {
        $vars['row_classes'][$id][] = 'highlight';     
      }
    }
  }
}