<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('component/header');
?>

<?php
$this->load->view($subview);
?>

<?php
$this->load->view('component/footer');
?>
