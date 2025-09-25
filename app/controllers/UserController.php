<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: UserController
 * 
 * Automatically generated via CLI.
 */
class UserController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $this->call->model('UserModel');
        $this->call->library('pagination');
        // Set custom theme and CSS classes
        $this->pagination->set_theme('custom');
        $this->pagination->set_custom_classes([
            'nav'    => 'pagination-nav',
            'ul'     => 'pagination-list',
            'li'     => 'pagination-item',
            'a'      => 'pagination-link',
            'active' => 'active'
        ]);
    }
    public function index($page = 1)
    {
        try {
            // Get items per page from query parameter or use default
            $per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
            $allowed_per_page = [10, 25, 50, 100];
            if (!in_array($per_page, $allowed_per_page)) {
                $per_page = 10;
            }
            // Get total count for pagination
            $total_rows = $this->UserModel->count_all_records();
            // Initialize pagination
            $pagination_data = $this->pagination->initialize(
                $total_rows,        // Total number of rows
                $per_page,          // Rows per page
                $page,              // Current page number
                'user/index',       // Base URL (route)
                5                   // Number of page links to show
            );
            // Get records for current page
            $data['users'] = $this->UserModel->get_records_with_pagination($pagination_data['limit']);
            $data['total_records'] = $total_rows;
            $data['pagination_data'] = $pagination_data;
            $data['pagination_links'] = $this->pagination->paginate();
            $this->call->view('user/view', $data);
        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Failed to load records: ' . $e->getMessage());
            redirect('user/index');
        }
    }
    public function create()
    {
        if($this->io->method() == 'post')
        {
            $username = $this->io->post('username');
            $email = $this->io->post('email');

            $data = [
                'username' => $username,
                'email' => $email
            ];
            $this->UserModel->insert($data);
            redirect('/');
        
            
        }
        else
        {
           $this->call->view('user/create'); 
        }
        
    }
    public function update($id)
    {
        $data['user'] = $this->UserModel->find($id);
        if($this->io->method() == 'post'){
            $data = [
                'username' => $this->io->post('username'),
                'email' => $this->io->post('email')
            ];
            $this->UserModel->update($id, $data);
            redirect('/');
            
        }
        else{
        $this->call->view('user/update', $data);
        }
    }
    public function delete($id){
        $this->UserModel->delete($id);
        redirect('/');
    }
}