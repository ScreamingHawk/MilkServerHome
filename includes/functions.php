<?php
include_once $_SERVER['DOCUMENT_ROOT'].'includes/db_connect.php';

function login($email, $password, $mysqli) {
	if ($stmt = $mysqli->prepare("SELECT id, username, password, salt FROM user WHERE email = ? LIMIT 1")) {
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->store_result();
		
		$stmt->bind_result($user_id, $username, $db_password, $salt);
		$stmt->fetch();
		
		if ($stmt->num_rows == 0) {
			// Not found. Test username
			if ($stmt = $mysqli->prepare("SELECT id, username, password, salt FROM user WHERE username = ? LIMIT 1")) {
				$stmt->bind_param('s', $email);
				$stmt->execute();
				$stmt->store_result();
				
				$stmt->bind_result($user_id, $username, $db_password, $salt);
				$stmt->fetch();
			}
		}
		
		if ($stmt->num_rows == 1) {
			if (checkbrute($user_id, $mysqli) == true) {
				// Is locked out
				return false;
			} else {
				$password = hash('sha512', $password . $salt);
				
				if ($db_password == $password){
					$user_browser = $_SERVER['HTTP_USER_AGENT'];
					// XSS protection
					$user_id = preg_replace("/[^0-9]+/", "", $user_id);
					$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
					$_SESSION['user_id'] = $user_id;
					$_SESSION['username'] = $username;
					$_SESSION['login_string'] = hash('sha512', $password . $user_browser);
					
					return true;
				} else {
					// Incorrect password
					$now = time();
					$mysqli->query("INSERT INTO login_attempts(user_id, time) VALUES ('$user_id', '$now')");
					return false;
				}
			}
		} else {
			// No user
			return false;
		}
	}
}
function checkbrute($user_id, $mysqli) {
	$now = time();
	// Test in a 1 hour window
	$valid_attempts = $now - (60 * 60);
	
	if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) {
		$stmt->bind_param('i', $user_id);
		$stmt->execute();
		$stmt->store_result();
		
		if ($stmt->num_rows > 5) {
			return true;
		}
		return false;
	}
}
function login_check($mysqli) {
	if (isset($_SESSION['user_id'], 
			$_SESSION['username'],
			$_SESSION['login_string'])) {
		$user_id = $_SESSION['user_id'];
		$username = $_SESSION['username'];
		$login_string = $_SESSION['login_string'];
		
		$user_browser = $_SERVER['HTTP_USER_AGENT'];
		
		if ($stmt = $mysqli->prepare("SELECT password FROM user WHERE id = ? LIMIT 1")) {
			$stmt->bind_param('i', $user_id);
			$stmt->execute();
			$stmt->store_result();
			
			if ($stmt->num_rows == 1) {
				$stmt->bind_result($password);
				$stmt->fetch();
				$login_check = hash('sha512', $password . $user_browser);
				
				if ($login_check == $login_string) {
					return true;
				}
			}
		}
	}
	return false;
}
function esc_url($url) {
	if ('' == $url) {
		return $url;
	}
	
	$url = preg_repace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
	
	$strip = array('%0d', '%0a', '%0D', '%0A');
	$url = (string) $url;
	$count = 1;
	while ($count) {
		$url = str_replace($strip, '', $url, $count);
	}
	
	$url = str_replace(';//', '://', $url);
	$url = htmlentities($url);
	$url = str_replace('&amp;', '&#038;', $url);
	$url = str_replace("'", '&#039;', $url);
	
	if ($url[0] !== '/') {
		return '';
	}
	return $url;
}
function list_users($mysqli) {
	if ($stmt = $mysqli->prepare("SELECT username FROM user ORDER BY username")) {
		$stmt->execute();
		$stmt->store_result();
		
		$stmt->bind_result($uname);
		$usernames = array();
		while ($stmt->fetch()) {
			$usernames[] = $uname;
		}
		
		return $usernames;
	}
}

// Formatting
function human_filesize($bytes, $decimals = 2) {
	$sz = ' KMGTP';
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor] . 'B';
}
function number_suffixed($num, $dp = 0) {
	$sz = ' KMBTQ';
	$base = log($num) / log(1000);
	if ($base < 0) {
		return number_format($num, $dp);
	}
	return number_format(pow(1000, $base - floor($base)), $dp) . @$sz[floor($base)];
}
function timeAgo($old, $new=null) {
	if (is_null($new)) {
		$new = time();
	}
	$timeCalc = $new - $old;
	if ($timeCalc > (60*60*24)) {
		return round($timeCalc/60/60/24) . " days ago";
	} else if ($timeCalc > (60*60)) {
		return round($timeCalc/60/60) . " hours ago";
	} else if ($timeCalc > 60) {
		return round($timeCalc/60) . " minutes ago";
	}
	return $timeCalc . " seconds ago";
}

// Helper
function non_zero_array($arr) {
	return isset($arr) && !is_null($arr) && is_array($arr) && count($arr) > 0;
}
function non_empty_string($str) {
	return isset($str) && !is_null($str) && is_string($str) && empty($str);
}