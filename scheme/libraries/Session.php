<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 * Fixed and Improved Session Library
 * Compatible with PHP 8.2+ and LavaLust 4.2.4
 * ------------------------------------------------------------------
 */

class Session {
	

    private $config;
    private $match_ip;
    private $match_fingerprint;
    private $userdata;

    public function __construct()
    {
        // Load config
        $this->config =& get_config();

        // IP and fingerprint settings
        $this->match_ip = $this->config['sess_match_ip'] ?? false;
        $this->match_fingerprint = $this->config['sess_match_fingerprint'] ?? true;

        // ------------------------------------------------------------
        // PREVENT OUTPUT BEFORE SESSION (avoid header warnings)
        // ------------------------------------------------------------
        if (ob_get_level() === 0) {
            @ob_start();
        }

        // ------------------------------------------------------------
        // COOKIE NAME SETUP
        // ------------------------------------------------------------
        if (!empty($this->config['cookie_prefix'])) {
            $this->config['cookie_name'] = $this->config['cookie_prefix'] . $this->config['sess_cookie_name'];
        } else {
            $this->config['cookie_name'] = $this->config['sess_cookie_name'] ?? ini_get('session.name');
        }

        if (!headers_sent()) {
            ini_set('session.name', $this->config['cookie_name']);
        }

        // ------------------------------------------------------------
        // SESSION EXPIRATION
        // ------------------------------------------------------------
        $this->config['sess_expiration'] = (int)($this->config['sess_expiration'] ?? ini_get('session.gc_maxlifetime'));
        if (!headers_sent()) {
            ini_set('session.gc_maxlifetime', $this->config['sess_expiration']);
        }

        $this->config['cookie_expiration'] = (int)($this->config['cookie_expiration'] ??
            ($this->config['sess_expire_on_close'] ? 0 : $this->config['sess_expiration']));

        // ------------------------------------------------------------
        // COOKIE PARAMETERS
        // ------------------------------------------------------------
        if (!headers_sent()) {
            session_set_cookie_params([
                'lifetime' => $this->config['cookie_expiration'],
                'path'     => $this->config['cookie_path'] ?? '/',
                'domain'   => $this->config['cookie_domain'] ?? '',
                'secure'   => $this->config['cookie_secure'] ?? false,
                'httponly' => true,
                'samesite' => $this->config['cookie_samesite'] ?? 'Lax'
            ]);

            ini_set('session.use_trans_sid', 0);
            ini_set('session.use_strict_mode', 1);
            ini_set('session.use_cookies', 1);
            ini_set('session.use_only_cookies', 1);
            ini_set('session.sid_length', $this->_get_sid_length());
        }

        // ------------------------------------------------------------
        // CUSTOM SESSION DRIVER HANDLER
        // ------------------------------------------------------------
        if (!empty($this->config['sess_driver']) && $this->config['sess_driver'] === 'file') {
            require_once 'Session/FileSessionHandler.php';
            $handler = new FileSessionHandler();
            if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
                session_set_save_handler($handler, true);
            }
        } elseif (!empty($this->config['sess_driver']) && $this->config['sess_driver'] === 'database') {
            // TODO: add DB handler if needed
        }

        // ------------------------------------------------------------
        // START SESSION SAFELY
        // ------------------------------------------------------------
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            @session_start();
        }

        // ------------------------------------------------------------
        // SECURITY: FINGERPRINT & IP VALIDATION
        // ------------------------------------------------------------
        if (empty($_SESSION['fingerprint'])) {
            $_SESSION['fingerprint'] = $this->generate_fingerprint();
        } elseif ($this->match_fingerprint && $_SESSION['fingerprint'] !== $this->generate_fingerprint()) {
            session_regenerate_id(true);
        }

        if (isset($_SESSION['ip_address']) && $this->match_ip) {
            if ($_SESSION['ip_address'] !== ($_SERVER['REMOTE_ADDR'] ?? '')) {
                session_regenerate_id(true);
            }
        }
        $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

        // ------------------------------------------------------------
        // SESSION REGENERATION TIMER
        // ------------------------------------------------------------
        $regenerate_time = (int)($this->config['sess_time_to_update'] ?? 300);
        if ($regenerate_time > 0 && (!isset($_SESSION['last_session_regenerate']) ||
            $_SESSION['last_session_regenerate'] < (time() - $regenerate_time))) {
            $this->sess_regenerate((bool)($this->config['sess_regenerate_destroy'] ?? false));
        }

        // ------------------------------------------------------------
        // REFRESH SESSION COOKIE
        // ------------------------------------------------------------
        if (isset($_COOKIE[$this->config['cookie_name']]) &&
            $_COOKIE[$this->config['cookie_name']] === session_id()) {

            $expiration = empty($this->config['cookie_expiration']) ? 0 : time() + $this->config['cookie_expiration'];

            setcookie(
                $this->config['cookie_name'],
                session_id(),
                [
                    'expires'  => $expiration,
                    'path'     => $this->config['cookie_path'] ?? '/',
                    'domain'   => $this->config['cookie_domain'] ?? '',
                    'secure'   => $this->config['cookie_secure'] ?? false,
                    'httponly' => true,
                    'samesite' => $this->config['cookie_samesite'] ?? 'Lax'
                ]
            );
        }

        $this->_lava_init_vars();
    }

    // ------------------------------------------------------------
    // Utility: fingerprint generator
    // ------------------------------------------------------------
    public function generate_fingerprint()
    {
        $key = [];
        foreach (['ACCEPT_CHARSET', 'ACCEPT_ENCODING', 'ACCEPT_LANGUAGE', 'USER_AGENT'] as $name) {
            $key[] = $_SERVER['HTTP_' . $name] ?? '';
        }
        return md5(implode("\0", $key));
    }

    protected function _lava_init_vars()
    {
        if (!empty($_SESSION['__lava_vars'])) {
            $current_time = time();

            foreach ($_SESSION['__lava_vars'] as $key => &$value) {
                if ($value === 'new') {
                    $_SESSION['__lava_vars'][$key] = 'old';
                } elseif ($value === 'old' || $value < $current_time) {
                    unset($_SESSION[$key], $_SESSION['__lava_vars'][$key]);
                }
            }

            if (empty($_SESSION['__lava_vars'])) {
                unset($_SESSION['__lava_vars']);
            }
        }

        $this->userdata =& $_SESSION;
    }

    private function _get_sid_length()
    {
        $bits_per_character = (int) ini_get('session.sid_bits_per_character');
        $sid_length = (int) ini_get('session.sid_length');
        if (($bits = $sid_length * $bits_per_character) < 160) {
            $sid_length += (int) ceil((160 % $bits) / $bits_per_character);
        }
        return $sid_length;
    }

    public function sess_regenerate($destroy = false)
    {
        $_SESSION['last_session_regenerate'] = time();
        session_regenerate_id($destroy);
    }

    public function has_userdata($key = null)
    {
        return $key !== null && isset($_SESSION[$key]);
    }

    public function set_userdata($keys, $value = null)
    {
        if (is_array($keys)) {
            foreach ($keys as $key => $val) {
                $_SESSION[$key] = $val;
            }
        } else {
            $_SESSION[$keys] = $value;
        }
    }

    public function unset_userdata($keys)
    {
        if (is_array($keys)) {
            foreach ($keys as $key) {
                unset($_SESSION[$key]);
            }
        } else {
            unset($_SESSION[$keys]);
        }
    }

    public function userdata($key = null)
    {
        if ($key !== null) {
            return $_SESSION[$key] ?? null;
        }
        return $_SESSION ?? [];
    }

    public function sess_destroy()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }

    // Flashdata helpers
    public function set_flashdata($data, $value = null)
    {
        $this->set_userdata($data, $value);
        $this->mark_as_flash(is_array($data) ? array_keys($data) : $data);
    }

    public function flashdata($key = null)
    {
        if ($key !== null) {
            return $_SESSION[$key] ?? null;
        }
        return $_SESSION['__lava_vars'] ?? [];
    }

    public function mark_as_flash($key)
    {
        if (is_array($key)) {
            foreach ($key as $k) {
                $_SESSION['__lava_vars'][$k] = 'new';
            }
        } else {
            $_SESSION['__lava_vars'][$key] = 'new';
        }
    }

    public function keep_flashdata($key)
    {
        $this->mark_as_flash($key);
    }

}
