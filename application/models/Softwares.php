<?php

class Softwares extends CI_Model {

  public function getSoftware()
  {
    return $this->db->select('*')->from('softwares')->get()->result();
  }

}