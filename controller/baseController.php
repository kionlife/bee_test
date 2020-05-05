<?php 
class BaseController 
{
    public function __construct() {   
    
	}
    
	public function loadView($main, $data = null) {
        include($main);
    }
}