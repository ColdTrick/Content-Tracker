<?php 

	function content_tracker_notify_from_object($event, $object_type, $entity)
	{
		global $trackers_notified;
		
		if(!$trackers_notified)
		{
			if(in_array($entity->getSubtype(), content_tracker_get_supported_types()))
			{
				content_tracker_notify_all_trackers_by_object($entity->getGUID(), $event);
			}
		}
	}
	
	function content_tracker_track_object_after_comment($event, $object_type, $entity)
	{
		global $trackers_notified;
		
		$user_guid = get_loggedin_userid();
		$object = get_entity($entity->entity_guid);
		
		if(in_array($object->getSubtype(), content_tracker_get_supported_types()))
		{
			if(!$trackers_notified)
			{
				content_tracker_notify_all_trackers_by_object($object->getGUID(), $event);
			}
			
			if($object->owner_guid != $user_guid)
			{
				if(($entity->name == 'generic_comment') || ($entity->name == 'group_topic_post'))
				{
					$usersettings_notify_on_comment = get_plugin_usersetting('content_tracker_notify_comment', get_loggedin_userid(), 'content_tracker');
					
					if($usersettings_notify_on_comment == 'yes')
					{
						$object->addRelationship($user_guid, CONTENT_TRACKER_TRACKING_OBJECT);
					}
				}
			}
		}
	}