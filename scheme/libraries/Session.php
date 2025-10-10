<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * LavaLust - Session library (fixed to avoid headers already sent warnings)
 */

class Session {


	private $config;


	private $match_ip;


	private $match_fingerprint;

	private $userdata;

	public function __construct()
	{
		// Load session config
		$this->config =& get_config();

		// IP and fingerprint settings
		$this->match_ip = isset($this->config['sess_match_ip']) ? $this->config['sess_match_ip'] : false;
		$this->match_fingerprint = isset($this->config['sess_match_fingerprint']) ? $this->config['sess_match_fingerprint'] : false;

		// --- COOKIE NAME SETUP ---
		if (!empty($this->config['cookie_prefix'])) {
			$this->config['cookie_name'] = !empty($this->config['sess_cookie_name'])
				? $this->config['cookie_prefix'] . $this->config['sess_cookie_name']
				: ini_get('session.name');
		} else {
			$this->config['cookie_name'] = !empty($this->config['sess_cookie_name'])
				? $this->config['sess_cookie_name']
				: ini_get('session.name');
		}

		// Set PHP session name safely (only if headers not sent)
		if (!headers_sent()) {
			@ini_set('session.name', $this->config['cookie_name']);
		}

		// --- SESSION EXPIRATION ---
		if (empty($this->config['sess_expiration'])) {
			$this->config['sess_expiration'] = (int) ini_get('session.gc_maxlifetime');
		} else {
			$this->config['sess_expiration'] = (int) $this->config['sess_expiration'];
			if (!headers_sent()) {
				@ini_set('session.gc_maxlifetime', $this->config['sess_expiration']);
			}
		}

		if (isset($this->config['cookie_expiration'])) {
			$this->config['cookie_expiration'] = (int) $this->config['cookie_expiration'];
		} else {
			$this->config['cookie_expiration'] = (!isset($this->config['sess_expiration']) && !empty($this->config['sess_expire_on_close'])) 
				? 0 : (int) $this->config['sess_expiration'];
		}

		// --- COOKIE PARAMETERS ---
		if (!headers_sent()) {
			// session_set_cookie_params signature for PHP 7.3+ accepts array
			if (PHP_VERSION_ID >= 70300) {
				session_set_cookie_params([
					'lifetime' => $this->config['cookie_expiration'],
					'path'     => $this->config['cookie_path'],
					'domain'   => $this->config['cookie_domain'],
					'secure'   => !empty($this->config['cookie_secure']),
					'httponly' => true,
					'samesite' => isset($this->config['cookie_samesite']) ? $this->config['cookie_samesite'] : 'Lax'
				]);
			} else {
				// Fallback for older PHP versions
				@session_set_cookie_params(
					$this->config['cookie_expiration'],
					$this->config['cookie_path'],
					$this->config['cookie_domain'],
					!empty($this->config['cookie_secure']),
					true
				);
			}

			@ini_set('session.use_trans_sid', 0);
			@ini_set('session.use_strict_mode', 1);
			@ini_set('session.use_cookies', 1);
			@ini_set('session.use_only_cookies', 1);
			@ini_set('session.sid_length', $this->_get_sid_length());
		}

		// --- SESSION DRIVER (file or database) ---
		if (!empty($this->config['sess_driver']) && $this->config['sess_driver'] === 'file') {
			require_once 'Session/FileSessionHandler.php';
			$handler = new FileSessionHandler();

			// Only set save handler if session not started and headers not sent
			if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
				session_set_save_handler($handler, true);
			}
		} elseif (!empty($this->config['sess_driver']) && $this->config['sess_driver'] === 'database') {
			// If you have a DB session handler, require it here and set similarly:
			// require_once 'Session/DatabaseSessionHandler.php';
			// $handler = new DatabaseSessionHandler(...);
			// if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
			//     session_set_save_handler($handler, true);
			// }
		}

		// --- START SESSION (only once) ---
		if (session_status() === PHP_SESSION_NONE) {
			@session_start();
		}

		// --- FINGERPRINT & IP CHECKS ---
		if (empty($_SESSION['fingerprint'])) {
			$_SESSION['fingerprint'] = $this->generate_fingerprint();
		} elseif ($this->match_fingerprint && $_SESSION['fingerprint'] !== $this->generate_fingerprint()) {
			// Fingerprint mismatch — destroy session and return false/stop
			$this->sess_destroy();
			return false;
		}

		if (isset($_SESSION['ip_address']) && $this->match_ip) {
			if ($_SESSION['ip_address'] !== ($_SERVER['REMOTE_ADDR'] ?? '')) {
				$this->sess_destroy();
				return false;
			}
		}

		// Set current IP
		$_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'] ?? '';

		// Validate cookie session id if present
		if (isset($_COOKIE[$this->config['cookie_name']])) {
			@preg_match('/(' . preg_quote(session_id(), '/') . ')/', $_COOKIE[$this->config['cookie_name']], $matches);
			if (empty($matches)) {
				unset($_COOKIE[$this->config['cookie_name']]);
			}
		}

		// --- SESSION REGENERATION ---
		$regenerate_time = isset($this->config['sess_time_to_update']) ? (int) $this->config['sess_time_to_update'] : 0;
		if (
			(empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
			&& $regenerate_time > 0
		) {
			if (!isset($_SESSION['last_session_regenerate'])) {
				$_SESSION['last_session_regenerate'] = time();
			} elseif ($_SESSION['last_session_regenerate'] < (time() - $regenerate_time)) {
				$this->sess_regenerate(!empty($this->config['sess_regenerate_destroy']));
			}
		} elseif (isset($_COOKIE[$this->config['cookie_name']]) && $_COOKIE[$this->config['cookie_name']] === $this->session_id()) {
			// If cookie matches our generated session id, update cookie expiry if needed
			$expiration = empty($this->config['cookie_expiration']) ? 0 : time() + $this->config['cookie_expiration'];
			if (!headers_sent()) {
				if (PHP_VERSION_ID >= 70300) {
					setcookie(
						$this->config['cookie_name'],
						$this->session_id(),
						[
							'expires'  => $expiration,
							'path'     => $this->config['cookie_path'],
							'domain'   => $this->config['cookie_domain'],
							'secure'   => !empty($this->config['cookie_secure']),
							'httponly' => !empty($this->config['cookie_httponly']),
							'samesite' => isset($this->config['cookie_samesite']) ? $this->config['cookie_samesite'] : 'Lax'
						]
					);
				} else {
					setcookie(
						$this->config['cookie_name'],
						$this->session_id(),
						$expiration,
						$this->config['cookie_path'],
						$this->config['cookie_domain'],
						!empty($this->config['cookie_secure']),
						!empty($this->config['cookie_httponly'])
					);
				}
			}
		}

		$this->_lava_init_vars();
	}

	/**
	 * Generates key as protection against Session Hijacking & Fixation.
	 * @return string
	 */
	public function generate_fingerprint()
	{
		$key = [];
		foreach (array('ACCEPT_CHARSET', 'ACCEPT_ENCODING', 'ACCEPT_LANGUAGE', 'USER_AGENT') as $name) {
			$key[] = !empty($_SERVER['HTTP_' . $name]) ? $_SERVER['HTTP_' . $name] : '';
		}

		return md5(implode("\0", $key));
	}


	protected function _lava_init_vars()
	{
		if (!empty($_SESSION['__lava_vars'])) {
			$current_time = time();
			foreach ($_SESSION['__lava_vars'] as $k => &$v) {
				if ($v === 'new') {
					$_SESSION['__lava_vars'][$k] = 'old';
				} elseif ($v === 'old' || $v < $current_time) {
					unset($_SESSION[$k], $_SESSION['__lava_vars'][$k]);
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


	public function mark_as_flash($key)
	{
		if (is_array($key)) {
			foreach ($key as $k) {
				if (!isset($_SESSION[$k])) return false;
			}

			$new = array_fill_keys($key, 'new');
			$_SESSION['__lava_vars'] = isset($_SESSION['__lava_vars']) ? array_merge($_SESSION['__lava_vars'], $new) : $new;
			return true;
		}
		if (!isset($_SESSION[$key])) return false;
		$_SESSION['__lava_vars'][$key] = 'new';
		return true;
	}

	public function keep_flashdata($key) { $this->mark_as_flash($key); }


	public function session_id()
	{
		$seed = str_split('abcdefghijklmnopqrstuvwxyz0123456789');
		shuffle($seed);
		$id = '';
		foreach (array_rand($seed, 32) as $k) $id .= $seed[$k];
		return $id;
	}


	public function has_userdata($key = null)
	{
		if (!is_null($key)) {
			return isset($_SESSION[$key]);
		}
		return false;
	}

	public function set_userdata($keys, $value = null)
	{
		if (is_array($keys)) {
			foreach ($keys as $k => $v) $_SESSION[$k] = $v;
			return;
		}
		$_SESSION[$keys] = $value;
	}

	public function unset_userdata($keys)
	{
		if (is_array($keys)) {
			foreach ($keys as $k) {
				if (isset($_SESSION[$k])) unset($_SESSION[$k]);
			}
			return;
		}
		if (isset($_SESSION[$keys])) unset($_SESSION[$keys]);
	}

	public function get_flash_keys()
	{
		if (!isset($_SESSION['__lava_vars'])) return array();
		$keys = array();
		foreach (array_keys($_SESSION['__lava_vars']) as $k) {
			if (!is_int($_SESSION['__lava_vars'][$k])) $keys[] = $k;
		}

		return $keys;
	}


	public function unmark_flash($key)
	{
		if (empty($_SESSION['__lava_vars'])) return;
		is_array($key) OR $key = array($key);
		foreach ($key as $k) {
			if (isset($_SESSION['__lava_vars'][$k]) && !is_int($_SESSION['__lava_vars'][$k])) {
				unset($_SESSION['__lava_vars'][$k]);
			}
		}
		if (empty($_SESSION['__lava_vars'])) unset($_SESSION['__lava_vars']);
	}

	public function userdata($key = NULL)
	{
		if (isset($key)) {
			return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
		} elseif (empty($_SESSION)) {
			return array();
		}
		$userdata = array();
		$_exclude = array_merge(array('__lava_vars'), $this->get_flash_keys());
		foreach (array_keys($_SESSION) as $k) {
			if (!in_array($k, $_exclude, TRUE)) $userdata[$k] = $_SESSION[$k];
		}

		return $userdata;
	}


	public function sess_destroy()
	{
		session_destroy();
	}


	public function flashdata($key = NULL)
	{
		if (isset($key)) {
			return (isset($_SESSION['__lava_vars'], $_SESSION['__lava_vars'][$key], $_SESSION[$key]) && !is_int($_SESSION['__lava_vars'][$key]))
				? $_SESSION[$key]
				: NULL;
		}

		$flashdata = array();
		if (!empty($_SESSION['__lava_vars'])) {
			foreach ($_SESSION['__lava_vars'] as $k => $v) {
				if (!is_int($v)) $flashdata[$k] = $_SESSION[$k];
			}
		}

		return $flashdata;
	}

	
	public function set_flashdata($data, $value = NULL)
	{
		$this->set_userdata($data, $value);
		$this->mark_as_flash(is_array($data) ? array_keys($data) : $data);
	}
}

