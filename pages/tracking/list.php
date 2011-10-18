<?php

	gatekeeper();
	
	set_page_owner(get_loggedin_userid());

	$title_text = elgg_echo("content_tracker:page:list:title");
	$title = elgg_view_title($title_text);
	
	if($list_tracked_objects = content_tracker_list_tracked_items_by_user())
	{
		$content  = elgg_view('page_elements/contentwrapper', array('subclass' => 'content_tracker_confirm_untrackall', 
																	'body' => elgg_view('output/confirmlink', array('text' => elgg_echo('content_tracker:page:list:untrack_all_items'), 
																													'href' => '/action/content_tracker/object/untrack?guid=all'))));
		$content .= $list_tracked_objects;
	}
	else
	{
		$content = elgg_view('page_elements/contentwrapper', array('body' => elgg_echo('content_tracker:page:list:no_objects_found')));
	}
		
	$page_data = $title . $content;
	
	$body = elgg_view_layout('two_column_left_sidebar', '', $page_data);
	
	page_draw($title_text, $body);