<?php

class Migration_Fill_users extends CI_Migration {

  public function up() {
    $file_location = 'data/prefill.csv';

    $file_handle = fopen($file_location, 'r');

    $users_arr = [];

    while (($data = fgetcsv($file_handle)) !== false) {
      $data = array_map("utf8_encode", $data);

      if (preg_grep('/per year/i', $data)) {
        $users_arr[] = $data[count($data) - 1];
      }
    }

    foreach ($users_arr as $emailaddress) {
      $data = [
        'emailaddress' => $emailaddress,
        'login_hash' => hash('sha256', random_bytes(100))
      ];
      
      $this->db->insert('users', $data);
    }
  }

  public function down() {
    $this->db->empty_table('users');
  }

}