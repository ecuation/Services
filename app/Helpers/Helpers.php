<?php

function get_permalink($slug = null)
{
	return Language::getPermalink($slug);
}

function getNamedLocaleRoute($slug = null)
{
	return Language::getRoute($slug);
}

function flash($title = null, $message = null)
{
	$flash = app('App\Services\Flash');
	if(func_num_args() == 0)
		return $flash;

	return $flash->message($title, $message);
}