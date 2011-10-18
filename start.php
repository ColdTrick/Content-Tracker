<?php
	global $CONFIG;

	define('CONTENT_TRACKER_BASEURL', 						$CONFIG->wwwroot . 'pg/content_tracker/');
	define('CONTENT_TRACKER_TRACKING_OBJECT', 				'user_tracking_content_object');
	define('CONTENT_TRACKER_UNTRACKING_OBJECT', 			'user_untracking_content_object');
	define('CONTENT_TRACKER_TRACKING_OBJECT_BY_COMMENT', 	'user_tracking_content_object_by_comment');

	include_once(dirname(__FILE__) . '/lib/functions.php');
	include_once(dirname(__FILE__) . '/lib/events.php');

	function content_tracker_init()
	{
		global $CONFIG;

		register_page_handler('content_tracker', 'content_tracker_page_handler');

		add_menu(elgg_echo("content_tracker:menu:title"), CONTENT_TRACKER_BASEURL);
		elgg_extend_view('profile/menu/linksownpage', 'content_tracker/profile_menu');

		register_elgg_event_handler('update', 'object', 	'content_tracker_notify_from_object');
		register_elgg_event_handler('create', 'annotation', 'content_tracker_track_object_after_comment');

		elgg_extend_view('css', 'content_tracker/css');
		
		add_widget_type('content_tracker', elgg_echo("content_tracker"), elgg_echo("content_tracker:widget:discription"));
	}

	function content_tracker_pagesetup()
	{
		$context = get_context();
		$page_owner = page_owner_entity();

		if($page_owner instanceof ElggGroup)
		{
			$page_owner = get_entity($page_owner->owner_guid);
		}

		if(in_array($context, content_tracker_get_supported_context()))
		{
			if($page_owner->getGUID() != get_loggedin_userid())
			{
				$objectview = content_tracker_get_objectview_by_context($context);
				elgg_extend_view($objectview, 'content_tracker/object_tracker');
			}
		}
	}

	function content_tracker_page_handler($page)
	{
		$include = "/pages/tracking/list.php";
		
		//if(!empty($page))
		{

		}
		//else
		{
			include(dirname(__FILE__) . $include);
		}
	}

	register_elgg_event_handler('init', 		'system', 	'content_tracker_init');
	register_elgg_event_handler('pagesetup', 	'system', 	'content_tracker_pagesetup');

	register_action('content_tracker/object/track', 	false, dirname(__FILE__) . '/actions/object/track.php');
	register_action('content_tracker/object/untrack', 	false, dirname(__FILE__) . '/actions/object/untrack.php');