<?php 
function getCounter()
{
	$counter = file_get_contents(__DIR__.'/../counter');
	return intval($counter);
}
function updateCounter($count)
{
	file_put_contents(__DIR__.'/../counter', $count);
}