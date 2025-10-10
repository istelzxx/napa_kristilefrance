<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------
 * LavaLust - Session Library (Final Fixed Version)
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
        $this->config =& get_config();
        $this->match_ip = $this->config['sess_match_ip'] ?? false;
        $this->match_fingerprint = $this->config['sess_match_fingerprint'] ?? true;

        // Start output buffering if not already
        if (ob_get_level() === 0) {
            @ob_start();
        }

        // Setup session name safely
        $this->config['cookie_name'] = !empty($this->config['cookie_prefix'])
            ? $this->config['cookie_prefix'] . ($this->config['sess_cookie_name'] ?? 'LLSession')
            : ($this->config['sess_cookie_name'] ?? 'LLSession');

        if (!headers_sent()) {
            ini_set('session.name', $this->config['cookie_name']);
            ini_set('session.use_strict_mode', 1);
            ini_set('session.use_only_cookies', 1);
            ini_set('session.use_cookies', 1);
        }

        // Expiration setup
        $this->config['sess_expiration'] = (int)($this->config['sess_expiration'] ?? ini_get('session.gc_maxlifetime'));
        if (!headers_sent()) {
            ini_set('session.gc_maxlifetime', $this->config['sess_expiration']);
        }

        $cookie_exp = $this->config['cookie_expiration'] ??
            ($this->config['sess_expire_on_close'] ? 0 : $this->config['sess_expiration']);

        if (!headers_sent()) {
            session_set_cookie_params([
                'lifetime' => $cookie_exp,
                'path'     => $this->config['cookie_path'] ?? '/',
                'domain'   => $this->config['cookie_domain'] ?? '',
                'secure'   => $this->config['cookie_secure'] ?? false,
                'httponly' => true,
                'samesite' => $this->config['cookie_samesite'] ?? 'Lax'
            ]);
        }

        // Safe start
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            @session_start();
        }

        // Initialize fingerprint
        if (empty($_SESSION['fingerprint'])) {
            $_SESSION['fingerprint'] = $this->generate_fingerprint();
        } elseif ($this->match_fingerprint && $_SESSION['fingerprint'] !== $this->generate_fingerprint()) {
            $this->sess_regenerate(true);
        }

        // IP validation
        $client_ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        if (isset($_SESSION['ip_address']) && $this->match_ip && $_SESSION['ip_address'] !== $client_ip) {
            $this->sess_regenerate(true);
        }
        $_SESSION['ip_address'] = $client_ip;

        // Regeneration interval
        $regenerate_time = (int)($this->config['sess_time_to_update'] ?? 300);
        if ($regenerate_time > 0 && (!isset($_SESSION['last_session_regenerate']) ||
            $_SESSION['last_session_regenerate'] < (time() - $regenerate_time))) {
            $this->sess_regenerate((bool)($this->config['sess_regenerate_destroy'] ?? false));
        }

        // Refresh cookie
        if (isset($_COOKIE[$this->config['cookie_name']]) &&
            $_COOKIE[$this->config['cookie_name']] === session_id()) {

            $expiration = empty($cookie_exp) ? 0 : time() + $cookie_exp;
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

    // --- Utility: Generate fingerprint
    public function generate_fingerprint()
    {
        $key = [];
        foreach (['ACCEPT_CHARSET', 'ACCEPT_ENCODING', 'ACCEPT_LANGUAGE', 'USER_AGENT'] as $h) {
            $key[] = $_SERVER['HTTP_' . $h] ?? '';
        }
        return md5(implode('|', $key));
    }

    // --- Initialize flashdata, etc.
    protected function _lava_init_vars()
    {
        if (!empty($_SESSION['__lava_vars'])) {
            $time = time();
            foreach ($_SESSION['__lava_vars'] as $key => &$value) {
                if ($value === 'new') {
                    $_SESSION['__lava_vars'][$key] = 'old';
                } elseif ($value === 'old' || $value < $time) {
                    unset($_SESSION[$key], $_SESSION['__lava_vars'][$key]);
                }
            }
            if (empty($_SESSION['__lava_vars'])) unset($_SESSION['__lava_vars']);
        }
        $this->userdata =& $_SESSION;
    }

    // --- FIXED: Safe session regeneration
    public function sess_regenerate($destroy = false)
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION['last_session_regenerate'] = time();
            @session_regenerate_id($destroy);
        } else {
            // If session was lost, restart it safely
            @session_start();
        }
    }

    // --- Session Data Accessors
    public function has_userdata($key = null)
    {
        return $key !== null && isset($_SESSION[$key]);
    }

    public function set_userdata($keys, $value = null)
    {
        if (is_array($keys)) {
            foreach ($keys as $k => $v) $_SESSION[$k] = $v;
        } else {
            $_SESSION[$keys] = $value;
        }
    }

    public function unset_userdata($keys)
    {
        foreach ((array)$keys as $k) unset($_SESSION[$k]);
    }

    public function userdata($key = null)
    {
        return $key ? ($_SESSION[$key] ?? null) : $_SESSION;
    }

    public function sess_destroy()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }

    // --- Flashdata Support
    public function set_flashdata($data, $value = null)
    {
        $this->set_userdata($data, $value);
        $this->mark_as_flash(is_array($data) ? array_keys($data) : $data);
    }

    public function flashdata($key = null)
    {
        return $key ? ($_SESSION[$key] ?? null) : ($_SESSION['__lava_vars'] ?? []);
    }

    public function mark_as_flash($key)
    {
        foreach ((array)$key as $k) $_SESSION['__lava_vars'][$k] = 'new';
    }

    public function keep_flashdata($key)
    {
        $this->mark_as_flash($key);
    }
	
}
