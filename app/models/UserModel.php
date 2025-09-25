<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Model: UserModel
 * 
 * Automatically generated via CLI.
 */
class UserModel extends Model {
    protected $table = 'users';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }

        // COUNT ALL RECORDS (for pagination library)
        public function count_all_records() {
            $count_sql = "SELECT COUNT(id) as total FROM {$this->table}";
            $count_result = $this->db->raw($count_sql);
            return $count_result ? $count_result->fetch(PDO::FETCH_ASSOC)['total'] : 0;
        }

        // GET RECORDS WITH PAGINATION (for pagination library)
        public function get_records_with_pagination($limit_clause) {
            $data_sql = "SELECT * FROM {$this->table} ORDER BY id DESC {$limit_clause}";
            $data_result = $this->db->raw($data_sql);
            return $data_result ? $data_result->fetchAll(PDO::FETCH_ASSOC) : [];
        }
}