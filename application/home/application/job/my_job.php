<?php
namespace home\application\job;

class my_job
{
	public function handle($arrArgs)
	{
		//sleep(4);
		//print_r();
		//fwrite(STDOUT, $arrArgs['hello']."\n\r");
		fwrite(STDOUT, 'hello my job!'."\n\r");
	}
}
