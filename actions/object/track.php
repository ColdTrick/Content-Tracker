<?php 

	$object_guid = get_input('guid');
	$loggedin_userid = get_loggedin_userid();
	
	if($object = get_entity($object_guid))
	{
		if(in_array($object->getSubtype(), content_tracker_get_supported_types()))
		{
			if($object->owner_guid != $loggedin_userid)
			{				
				$object->addRelationship($loggedin_userid, CONTENT_TRACKER_TRACKING_OBJECT);
				
				system_message(elgg_echo('content_tracker:messages:tracking_item'));
			}
		}
	}
		
	forward($object->getURL());