<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @package Autocomplete Search with Dynamic Data using CodeIgniter and Bootstrap Typeahead
 *
 * @author TechArise Team
 *
 * @email  info@techarise.com
 *   
 * Description of Site Controller
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class site extends CI_Model {
    private $_countryID;
    private $_countryName;

    // set country id
    public function setCountryID($countryID) {
        return $this->_countryID = $countryID;
    }
    // set country Name
    public function setCountryName($countryName) {
        return $this->_countryName = $countryName;
    }
    // get All Countries
    public function getAllCountries() {
        $this->db->select(array('c.id as country_id', 'c.name as country_name'));
        $this->db->from('DESIGN as c');
        $this->db->like('c.name', $this->_countryName, 'both');
        $query = $this->db->get();
        return $query->result_array();
    }

}

?>