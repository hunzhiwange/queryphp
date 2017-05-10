<?php
class PHP_Job
{
	public function perform()
	{
		sleep(10);
		fwrite(STDOUT, 'Hello!');
	}
}
?>