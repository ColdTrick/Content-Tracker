<?php

	$object_guid = get_input('guid');
	$loggedin_userid = get_loggedin_userid();
	
	if($object_guid == 'all')
	{
		content_tracker_untrack_all();
	}
	elseif($object = get_entity($object_guid))
	{
		if(in_array($object->getSubtype(), content_tracker_get_supported_types()))
		{
			if($object->owner_guid != $loggedin_userid)
			{
				if(content_tracker_check_relationship($object_guid))
				{
					$object->removeRelationship($loggedin_userid, CONTENT_TRACKER_TRACKING_OBJECT);
				}
				
				system_message(elgg_echo('content_tracker:messages:untracking_item'));
			}
		}
	}
		
	forward(REFERER);