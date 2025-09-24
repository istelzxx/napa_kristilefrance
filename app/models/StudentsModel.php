<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Model: StudentsModel
 * 
 * Automatically generated via CLI.
 */
class StudentsModel extends Model {
    protected $table = 'student';
    protected $primary_key = 'id';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function count_all_records($search = '') {
        try {
            if (!empty($search)) {
                $sql = "SELECT COUNT({$this->primary_key}) as total
                        FROM {$this->table}
                        WHERE first_name LIKE ?
                           OR last_name LIKE ?
                           OR email LIKE ?";
                $result = $this->db->raw($sql, ["%$search%", "%$search%", "%$search%"]);
            } else {
                $sql = "SELECT COUNT({$this->primary_key}) as total FROM {$this->table}";
                $result = $this->db->raw($sql);
            }
            
            if ($result) {
                $row = $result->fetch(PDO::FETCH_ASSOC);
                return (int)($row['total'] ?? 0);
            }
            return 0;
        } catch (Exception $e) {
            error_log("Error counting records: " . $e->getMessage());
            return 0;
        }
    }

    public function get_records_with_pagination($limit_clause, $search = '') {
        try {
            if (!empty($search)) {
                $sql = "SELECT * FROM {$this->table}
                        WHERE first_name LIKE ?
                           OR last_name LIKE ?
                           OR email LIKE ?
                        ORDER BY {$this->primary_key} DESC {$limit_clause}";
                $result = $this->db->raw($sql, ["%$search%", "%$search%", "%$search%"]);
            } else {
                $sql = "SELECT * FROM {$this->table}
                        ORDER BY {$this->primary_key} DESC {$limit_clause}";
                $result = $this->db->raw($sql);
            }
            
            return $result ? $result->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (Exception $e) {
            error_log("Error fetching paginated records: " . $e->getMessage());
            return [];
        }
    }

    public function get_records_with_offset_limit($offset, $limit, $search = '') {
        try {
            if (!empty($search)) {
                $sql = "SELECT * FROM {$this->table}
                        WHERE first_name LIKE ?
                           OR last_name LIKE ?
                           OR email LIKE ?
                        ORDER BY {$this->primary_key} DESC
                        LIMIT ? OFFSET ?";
                $result = $this->db->raw($sql, ["%$search%", "%$search%", "%$search%", $limit, $offset]);
            } else {
                $sql = "SELECT * FROM {$this->table}
                        ORDER BY {$this->primary_key} DESC
                        LIMIT ? OFFSET ?";
                $result = $this->db->raw($sql, [$limit, $offset]);
            }
            
            return $result ? $result->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (Exception $e) {
            error_log("Error fetching records with offset/limit: " . $e->getMessage());
            return [];
        }
    }
}