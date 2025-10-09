<?php
class Auth
{
    protected $_lava;
    protected $db;
    protected $session;


    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->database();   // Initializes the database
        $this->_lava->call->library('session');  // Loads the session library

        // Assign the session and db objects to the class properties
        $this->db = $this->_lava->db;
        $this->session = $this->_lava->session;  // Assign session to $this->session
    }

    /**
     * Register a new user
     */
    public function register($first_name, $last_name, $password, $role = 'student')
    
    {
        
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $this->db->table('student')->insert([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'password' => $hash,
            'role' => $role
        ]);
    }
    /**
     * Login user
     */
    public function login($first_name, $last_name, $password)
    {
        
    $password = $password;

    // Allow login via username
    $user = $this->db->table('student')
                       ->where('first_name', $first_name)
                       ->where('last_name', $last_name)
                       ->get();

    

    if ($user && isset($user['password']) && password_verify($password, $user['password'])) {
        $this->session->set_userdata([
            'user_id'   => $user['id'],
            'first_name'  => $user['first_name'],
            'last_name'  => $user['last_name'],
            'role'      => ($user['role'] ?? 'user'),
            'logged_in' => true
        ]);
        return true;
    }
    return false;
    }


    /**
     * Check if user is logged in
     */
    public function is_logged_in()
    {
        return (bool) $this->session->userdata('logged_in');
    }

    /**
     * Check user role
     */
    public function has_role($role)
    {
        return $this->session->userdata('role') === $role;
    }

    /**
     * Logout user
     */
    public function logout()
    {
        $this->session->unset_userdata(['user_id','first_name', 'last_name','role','logged_in']);
    }
}

?>