<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php if (!$page): ?>
    <h2<?php print $title_attributes; ?>>
      <a href="<?php print $node_url; ?>"><?php print $title; ?></a>
    </h2>
  <?php endif; ?>
  <?php print render($title_suffix); ?>
  
        <form id="form1" name="form1" method="post" action="">
            <p>
                <label for="username">Search:</label>
                <input type="text" name="searchtext" id="searchtext" value="<?php if(isset($_POST['searchtext'])) {echo htmlentities($_POST['searchtext']);} ?>" />
                <input name="search" type="submit" id="search" value="Go" />
            </p>
        </form>  

<?php

if (!$page) { print l($node->title, "node/17") ; }

/*$result = db_query('SELECT n.title FROM {node} n');
 
foreach($result as $item) {
  print $item->title;
  echo "**\n";
}
*/
//$result2 = db_query('SELECT t.tid AS tid FROM taxonomy_term_data t INNER JOIN taxonomy_term_hierarchy h ON h.parent = t.tid WHERE (h.tid = :db_condition_placeholder_0) ORDER BY t.weight ASC, t.name ASC');
$result2 = db_query('SELECT nid, title FROM {node} WHERE type = :type', array(':type' => 'business',));
foreach($result2 as $item) {
print $item->title;
print $item->nid;
echo "**\n";
} 

echo "*************************\n";
$result5 = db_query('SELECT r.entity_id, r.field_rating_rating, c.nid FROM {field_data_field_rating} r INNER JOIN {comment} c ON c.cid = r.entity_id WHERE r.bundle = :bundle', array(':bundle' => 'comment_node_business'));
foreach($result5 as $item) {
print $item->entity_id;
echo "*\n";
print $item->field_rating_rating;
echo "**\n";
print $item->nid;
echo "***\n";
} 
echo "*************************\n";
$nid = 13;
$result5 = db_query('SELECT r.entity_id, r.field_rating_rating, c.nid FROM {field_data_field_rating} r INNER JOIN {comment} c ON c.cid = r.entity_id WHERE c.nid = :nid', array(':nid' => $nid));
$average = 0;
$count = 0;
foreach($result5 as $item) {
	print $item->entity_id;
	echo "*\n";
	print $item->field_rating_rating;
	echo "**\n";
	print $item->nid;
	echo "***\n";
	$count++;
	print $count;
	echo "*\n";
  $average = $average + $item->field_rating_rating;
  print $average;
  echo "*\n";
}
echo "****\n";
if ($average != 0) {print $average/$count; }
else {print '0';}
echo "*\n";
print $count;
echo "*************************\n";
$vid = 4;
$result3 = db_query('SELECT n.name, n.tid, n.vid FROM {taxonomy_term_data} n WHERE n.vid = :vid', array(':vid' => $vid ));
foreach($result3 as $item) {
print $item->name;
print $item->tid;
print $item->vid;
echo "**\n";
} 
echo "*************************\n";
$vids = array(2, 4);
$result3 = db_query('SELECT n.name, n.tid, n.vid FROM {taxonomy_term_data} n WHERE n.vid IN (:vids)', array(':vids' => $vids));
//$record = $result3->fetchObject();
//print_r($record);
while ($row = $result3->fetchAssoc()) {
print_r($row);
//echo ($row[name]);
//echo ($row[vid]);
//echo ($row[tid]);
}
//SELECT taxonomy_term_data.name AS taxonomy_term_data_name, taxonomy_term_data.vid AS taxonomy_term_data_vid, taxonomy_term_data.tid AS tid, taxonomy_vocabulary.machine_name AS taxonomy_vocabulary_machine_name FROM taxonomy_term_data taxonomy_term_data LEFT JOIN taxonomy_vocabulary taxonomy_vocabulary ON taxonomy_term_data.vid = taxonomy_vocabulary.vid WHERE (( (taxonomy_term_data.vid IN (:db_condition_placeholder_0, :db_condition_placeholder_1)) ))

?>

<?php
/*
//if($_POST['search']) {
if (array_key_exists('search', $_POST)) {
//session_start();
$searchtext = trim($_POST['searchtext']);
$query = "SELECT id, sku, name, price, imgtype FROM products2 WHERE name LIKE '%$searchtext%' ORDER BY price";
$q = $conn->query($query);
}
*/
?>             
        
</div>
