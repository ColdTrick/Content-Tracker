<?php
	global $CONFIG;
	
	$graphics_folder = $vars["url"] . "mod/content_tracker/_graphics/";
	$tracking_object = $vars["entity"];
	
	$subtype = $tracking_object->getSubtype();
	if($subtype == 'page_top')
	{
		$subtype = 'page';
	}
	
	$relationship = content_tracker_check_relationship($tracking_object->getGUID());
	
	$untrack_link = elgg_view('output/confirmlink', array('text' => elgg_echo('content_tracker:menu:untrack'), 'href' => $CONFIG->wwwroot . "action/content_tracker/object/untrack?guid=" . $tracking_object->getGUID()));
?>
	<div class="content_tracker_tracking_object">
	
		<!-- <img title="<?php echo ucfirst($tracking_object->getSubtype()); ?>" alt="<?php echo ucfirst($tracking_object->getSubtype());?>: " src="<?php echo $graphics_folder; ?>icons/object/<?php echo $tracking_object->getSubtype(); ?>.png" />-->
		
		<div class="content_tracker_tracking_object_subtype"><?php echo ucfirst($subtype); ?></div>
		
		<!--  <div class="content_tracker_tracking_object_since"><?php echo elgg_view('output/friendlytime', array('time' => $relationship->time_created)); ?></div> -->
		
		<div class="content_tracker_tracking_object_title"><a href="<?php echo $tracking_object->getURL();?>"><?php echo $tracking_object->title; ?></a></div>		
		
		<div class="content_tracker_tracking_object_untrack">
			<?php echo $untrack_link; ?>
		</div>
		
	</div>