<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	public function index()
	{
		$data["cars"] 		 = $this->my_model->get("cars",null,"result");
		$data["repairTypes"] = $this->my_model->get("repairtype",null,"result");
		$data["subview"]  	 = "home/home";
    	$this->load->view("main_layout",$data);
	}
}
