<?include("function.inc.php");function upload_image(){	$conn = conn_DB();	$image_url = $_POST['image_url'];	$title = mysql_real_escape_string($_POST['title']);	//print_r($_POST);	$query_sql  = 'INSERT INTO  `images` (`image_url` ,`thumb_url` ,`title`)VALUES ("'.$image_url.'", "", "'.$title.'" )';	//echo $query_sql;	$ret = mysql_query($query_sql,$conn);	if($ret)	{		//echo json_encode(array('ret'=>1,'msg' =>'OK'));		header("location:/upload.php?ret=1");	} else {		header("location:/upload.php?ret=-1");	}}upload_image();?>