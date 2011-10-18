<?php
	
	include_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/lib/functions.php');

	$num = $vars['entity']->num_display;
	
	if (!$num)
	{
		$num = 4;
	}
	
	$content = content_tracker_list_tracked_items_by_user(get_loggedin_userid(), $num);
	
	echo $content;
	
	if ($content)
	{
		echo '<div class="widget_more_wrapper"><a href="'.CONTENT_TRACKER_BASEURL.'">'.elgg_echo('content_tracker:widget:view:more_tracked_content').'</a></div>';
	}