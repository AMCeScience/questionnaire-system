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

  public function userType($user_id)
  {
    if ($this->isUsing($user_id)) {
      return 'using';
    }

    if ($this->isConsideringUse($user_id)) {
      return 'considering';
    }

    return 'no_use';
  }

  public function isUsing($user_id)
  {
    $prefill = $this->db->select('prefill_id')->get_where('prefills', ['user_id' => $user_id])->row(0);

    return $this->db->from('softwares_to_prefills')->where('prefill_id', $prefill->prefill_id)->where_in('value', ['2', '3'])->count_all_results() > 0;
  }

  public function isConsideringUse($user_id)
  {
    $prefill = $this->db->select('prefill_id')->get_where('prefills', ['user_id' => $user_id])->row(0);

    $is_using = $this->isUsing($user_id);
    $is_considering = $this->db->from('softwares_to_prefills')->where(['user_id' => $prefill_prefill_id, 'value' => '1'])->count_all_results() > 0;

    return (!$is_using && $is_considering);
  }

}