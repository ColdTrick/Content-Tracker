<?php

	$english = array(

		'content_tracker' => 'Content Tracker',

		//Menu items
		'content_tracker:menu:title'			=> 'Content Tracker',
		'content_tracker:menu:track_object' 	=> 'Track this item',
		'content_tracker:menu:untrack_object' 	=> 'Untrack this item',
		'content_tracker:menu:untrack' 			=> 'Untrack',

		//Pages
		'content_tracker:page:list:title' 				=> 'Content tracking list',
		'content_tracker:page:list:no_objects_found' 	=> 'You are currently not tracking any content',
		'content_tracker:page:list:untrack_all_items' 	=> 'Untrack all',

		//Messages
		'content_tracker:messages:tracking_item' 	=> 'You are now tracking this item',
		'content_tracker:messages:untracking_item' 	=> 'You are no longer tracking this item',

		//Notifications
		'content_tracker:notifications:updated_object:subject' => 'There is updated content on %s',
		'content_tracker:notifications:updated_object:message' => 'There is updated content on %s',

		'content_tracker:notifications:comment:subject' => 'There is a new comment on "%s"',
		'content_tracker:notifications:comment:message' => 'There is a new comment on "%s" (%s)',

		'content_tracker:notifications:topicpost:subject' => 'There is a new post on "%s"',
		'content_tracker:notifications:topicpost:message' => 'There is a new post on "%s" (%s)',

		//Usersettings
		'content_tracker:usersettings:notify_comment' => 'Automatically keep track of items I commented on',
	);

	add_translation('en', $english);