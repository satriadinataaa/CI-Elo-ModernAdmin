<?php
	$this->load->view($module . '/includes/header', ['title' => $title]);
	
	$this->load->view($module . '/includes/navbar');
	$this->load->view($module . '/includes/sidebar');
	
	$this->load->view($module . '/' . $content);
	$this->load->view($module . '/includes/footer');