<?php

class Prefills extends CI_Model {

  public function getPrefills($user_id)
  {
    $data['reviews'] = $this->db->from('prefills')->where('user_id', $user_id)->get()->row(0);

    $data['software'] = $this->db->from('prefills')
      ->join('softwares_to_prefills', 'prefills.prefill_id = softwares_to_prefills.prefill_id')
      ->join('softwares', 'softwares_to_prefills.software_id = softwares.software_id')
      ->where('prefills.user_id', $user_id)
      ->get()
      ->result();

    return $data;
  }

  public function updateSoftware($software_id, $user_id, $value)
  {
    $prefill = $this->db->select('prefill_id')->get_where('prefills', ['user_id' => $user_id])->row(0);

    $this->db
      ->set(['value' => $value, 'has_changed' => 1])
      ->where(['prefill_id' => $prefill->prefill_id, 'software_id' => $software_id])
      ->update('softwares_to_prefills');
  }

  public function updatePrefill($type, $user_id, $value)
  {
    $field = 'number_of_reviews';

    if ($type === 'papers') {
      $field = 'number_of_papers';
    }

    $this->db
      ->set([$field => $value, 'has_changed' => 1])
      ->where('user_id', $user_id)
      ->update('prefills');
  }

}