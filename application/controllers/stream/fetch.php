<?php
$url = $_GET['url'];
$url = checkValues($url);
function checkValues($value)
{
	$value = trim($value);
	if (get_magic_quotes_gpc()) 
	{
		$value = stripslashes($value);
	}
	$value = strtr($value, array_flip(get_html_translation_table(HTML_ENTITIES)));
	$value = strip_tags($value);
	$value = htmlspecialchars($value);
	return $value;
}	
function fetch_record($path)
{
	$file = fopen($path, "r"); 
	if (!$file)
	{
		return FALSE;
	} 
	$data = '';
	while (!feof($file))
	{
		$data .= fgets($file, 1024);
	}
	return $data;
}

$string = fetch_record($url);
if($string == FALSE)
{
	echo FALSE;
	return;
}

/// fecth title
$title_regex = "/<title>(.+)<\/title>/i";
preg_match_all($title_regex, $string, $title, PREG_PATTERN_ORDER);
$url_title = $title[1];

/// fecth decription
$tags = get_meta_tags($url);

// fetch images
$image_regex = '/<img[^>]*'.'src=[\"|\'](.*)[\"|\']/Ui';
preg_match_all($image_regex, $string, $img, PREG_PATTERN_ORDER);
$images_array = $img[1];

$data = array();
$pimg = FALSE;

if(@$images_array[0])
{
	$pimg = @$images_array[0];	
}
$data = array('title'=>@$url_title[0],'url'=>substr($url,0,35),'desc'=>@$tags['description'],'img'=>$pimg);
echo $data;

	