<?php
namespace home\application\job;

class job
{
	public function perform()
	{
		sleep(10);
		fwrite(STDOUT, 'Hello!');
	}
}
