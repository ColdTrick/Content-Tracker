<?php 

	if($entity = $vars['entity'])
	{		
		if($vars['full'] || $entity->getSubtype() == 'groupforumtopic')
		{
			if(in_array($entity->getSubtype(), content_tracker_get_supported_types()))
			{
				global $CONFIG, $object_guid;
				
				$object_guid = $entity->getGUID();
				
				if(content_tracker_check_relationship($object_guid))
				{
					add_submenu_item(elgg_echo('content_tracker:menu:untrack_object'),													//Added 0_ for ordering 
						elgg_add_action_tokens_to_url($CONFIG->wwwroot . "action/content_tracker/object/untrack?guid=" 	. $object_guid), '0_content_tracker');
				}
				else
				{
					add_submenu_item(elgg_echo('content_tracker:menu:track_object'),													//Added 0_ for ordering
						elgg_add_action_tokens_to_url($CONFIG->wwwroot . "action/content_tracker/object/track?guid=" 	. $object_guid), '0_content_tracker');
				}
			}
		}
	}