<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php if (!$page): ?>
    <h2<?php print $title_attributes; ?>>
      <a href="<?php print $node_url; ?>"><?php print $title; ?></a>
    </h2>
  <?php endif; ?>
  <?php print render($title_suffix); ?>
          
</div>
<?php

if (!$page) { print l($node->title, "node/11") ; }

$result = db_query('SELECT n.title FROM {node} n');
 
foreach($result as $item) {
  print $item->title;
  echo "**\n";
}
?>

<p>*************So pretty much the same expect <strong>curly brackets</strong> are used around the table <span style="color:rgb(178, 34, 34)"><strong>{</strong></span> table<span style="color:rgb(178, 34, 34)"><strong> }</strong></span> .</p>

<?php
$result2 = db_query_range('SELECT n.title FROM {node} n',0, 11);
 
foreach($result2 as $item) {
  print $item->title;
  echo "**\n";
}
?>

<p>*************So pretty much the same expect <strong>curly brackets</strong> are used around the table <span style="color:rgb(178, 34, 34)"><strong>{</strong></span> table<span style="color:rgb(178, 34, 34)"><strong> }</strong></span> .</p>
<?php
$result3 = db_query_range('SELECT n.title, n.uid FROM {node} n WHERE n.uid = :uid', 0, 15,
                          array(':uid' => $uid));
foreach($result3 as $item) {
  print $item->title;
  echo "-uid:\n";
  print $item->uid;
  echo "**\n";
}
?>
<p>*************So pretty much the same expect <strong>curly brackets</strong> are used around the table <span style="color:rgb(178, 34, 34)"><strong>{</strong></span> table<span style="color:rgb(178, 34, 34)"><strong> }</strong></span> .</p>
<?php
$result4 = db_query_range('SELECT n.title, n.uid FROM {node} n WHERE n.uid = :uid', 0, 15,
                          array(':uid' => $uid))->fetchField();

  print $result4;
  
echo "\n*******************************\n"; 
$result5 = db_select('node','n')
          ->fields('n',array('title','uid'))
          ->range(0,5)
          ->condition('n.uid',$uid,'=')
          ->execute();
		  foreach($result5 as $item) {
  print $item->title;
  echo "-uid:\n";
  print $item->uid;
  echo "**\n";      
}

$result6 = db_query_range('SELECT n.title, n.uid FROM {node} n WHERE n.uid = :uid', 3, 15,
                          array(':uid' => $uid))->fetchField();
  print $result6;
?>
