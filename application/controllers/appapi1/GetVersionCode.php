<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetVersionCode extends CI_Controller {
	
	
	
	function __construct()
    {
        parent:: __construct();
        $this->clear_cache();
    }
	
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
	public function index() 
	{
	    echo "1.7";
	}
	
}