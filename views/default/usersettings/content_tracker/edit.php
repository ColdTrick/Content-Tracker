<?php 

	$plugin = $vars["entity"];
	
	$noyes_options = array(
		"no" => elgg_echo("option:no"),
		"yes" => elgg_echo("option:yes")
	);
	
	echo "<div>";
	echo elgg_echo("content_tracker:usersettings:notify_comment");
	echo "&nbsp;" . elgg_view("input/pulldown", array("internalname" => "params[content_tracker_notify_comment]", "options_values" => $noyes_options, "value" => $plugin->content_tracker_notify_comment));
	echo "</div>";
