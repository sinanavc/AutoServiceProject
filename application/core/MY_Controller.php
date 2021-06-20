<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model("my_model");
    $this->load->model("service_m");
    $this->method = $this->router->fetch_method();
  }
}
