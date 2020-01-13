<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Location Controller FrontEnd
 *
 * @author Jaeeme
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Location extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('site', 'location');
    }

    // get state names
    public function index() {
        $data['page'] = 'Autocomplete';
        $data['title'] = 'Autocomplete | TechArise'; 
        $this->load->view('autocomplete/index', $data);
    }

    // get Country Autocomplete
    public function getCountryAutocomplete() {
        $json = array();
        $countryName = $this->input->post('query');
        $this->location->setCountryName($countryName);
        $geCountries = $this->location->getAllCountries();
        foreach ($geCountries as $key => $element) {
            $json[] = array(
                'country_id' => $element['country_id'], 
                'country_name' => $element['country_name'],
            );
        }
        $this->output->set_header('Content-Type: application/json');
        echo json_encode($json);
    }

}
?>