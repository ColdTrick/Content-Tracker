<?php 

	function content_tracker_get_supported_types()
	{
		return array('blog', 'page', 'page_top', 'file', 'groupforumtopic');
	}
	
	function content_tracker_get_supported_context()
	{
		return array('blog', 'pages', 'file', 'groups');
	}
	
	function content_tracker_get_objectview_by_context($context)
	{
		$objectviews = array(
			'blog' 		=> 'object/blog',
			'pages' 	=> 'pages/pageprofile',
			'file'		=> 'object/file',
			'groups'	=> 'forum/viewposts',
		); 
		
		return $objectviews[$context];
	}
	
	function content_tracker_check_relationship($object_guid, $relationship = CONTENT_TRACKER_TRACKING_OBJECT, $user_guid = null)
	{
		if(!$user_guid)
		{
			$user_guid = get_loggedin_userid();
		}
		
		return check_entity_relationship($object_guid, $relationship, $user_guid);
	}
	
	function content_tracker_get_tracked_items_by_user($user_guid = null)
	{
		if(!$user_guid)
		{
			$user_guid = get_loggedin_userid();
		}
		
		$tracking_entities = elgg_get_entities_from_relationship(array(
																	'relationship' 			=> CONTENT_TRACKER_TRACKING_OBJECT, 
																	'relationship_guid' 	=> $user_guid,
																	'inverse_relationship' 	=> true,
		 															'order_by'				=> 'subtype',
																	'limit'					=> false,
																));
		
		return $tracking_entities;
	}
	
	function content_tracker_list_tracked_items_by_user($user_guid = null)
	{
		if(!$user_guid)
		{
			$user_guid = get_loggedin_userid();
		}
		
		$tracking_entities = content_tracker_get_tracked_items_by_user($user_guid);
		
		$result = '';
		
		foreach($tracking_entities as $entity)
		{
			$result .= elgg_view('content_tracker/tracking_object', array('entity' => $entity));
		}
		
		return $result;
	}
	
	function content_tracker_untrack_all($user_guid = null)
	{
		if(!$user_guid)
		{
			$user_guid = get_loggedin_userid();
		}
		
		$tracked_items = content_tracker_get_tracked_items_by_user($user_guid);
		
		foreach($tracked_items as $object)
		{
			$object->removeRelationship($user_guid, CONTENT_TRACKER_TRACKING_OBJECT);
		}
	}
	
	function content_tracker_get_trackers_by_object($object_guid)
	{
		global $trackers_notified;
		
		$result = false;
		
		if($object = get_entity($object_guid))
		{
			$trackers = elgg_get_entities_from_relationship(array(	
																	'type'					=> 'user',
																	'relationship' 			=> CONTENT_TRACKER_TRACKING_OBJECT, 
																	'relationship_guid' 	=> $object_guid,
																	'limit'					=> false,
																));
			$result = $trackers;
		}
		
		$trackers_notified = true;
		
		return $result;
	}
	
	function content_tracker_notify_all_trackers_by_object($object_guid, $event_type)
	{
		global $CONFIG, $ENTITY_CACHE, $DB_PROFILE;
		
		$entity_cache_backup = $ENTITY_CACHE;
		
		set_time_limit(0);		
				
		$object = get_entity($object_guid);
			
		if($trackers = content_tracker_get_trackers_by_object($object_guid))
		{			
			if($event_type == 'update')
			{
				$subject = sprintf(elgg_echo('content_tracker:notifications:updated_object:subject'), $CONFIG->sitename);
				$message = sprintf(elgg_echo('content_tracker:notifications:updated_object:message'), $object->getURL());
			}
			elseif($event_type == 'create')
			{
				$subtype = $object->getSubtype();
				
				if($subtype == 'groupforumtopic')
				{
					$subject = sprintf(elgg_echo('content_tracker:notifications:topicpost:subject'), $object->title);
					$message = sprintf(elgg_echo('content_tracker:notifications:topicpost:message'), $object->title, $object->getURL());
				}
				else
				{
					$subject = sprintf(elgg_echo('content_tracker:notifications:comment:subject'), $object->title);
					$message = sprintf(elgg_echo('content_tracker:notifications:comment:message'), $object->title, $object->getURL());
				}
			}
					
			foreach($trackers as $user)
			{
				if($user->getGUID() != get_loggedin_userid())
				{
					notify_user($user->getGUID(), $object_guid, $subject, $message);
				}
			}
		}
		
		invalidate_cache_for_entity($object->getGUID());
		
		$ENTITY_CACHE = $entity_cache_backup;
		$DB_PROFILE = null;
	}