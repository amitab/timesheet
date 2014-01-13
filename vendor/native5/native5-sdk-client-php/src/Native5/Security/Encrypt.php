<?php
namespace Native5\Security;

class Encrypt {
	public static function encryptPassword($pass, $salt="Ens0L0g1c") {
		$hash_technique = 'sha256';
		$salt = hash($hash_technique, uniqid(mt_rand(), true).$salt);
		$hash = $salt.$pass;
		for ( $i = 0; $i < 100; $i ++ ) {
			$hash = hash($hash_technique, $hash);
		}
		$hash = $salt.$hash;
		return $hash;	
	}

	public static function checkPassword($pass, $encryptedString) {
		$encrypted_passwd = $encryptedString;
		$salt = substr($encrypted_passwd, 0, 64);
		$hash = $salt . $pass;
		for ( $i = 0; $i < 100; $i ++ ) {
			$hash = hash('sha256', $hash);
		}
		$hash = $salt . $hash;
		if ($hash == $encrypted_passwd) {
			return True;
		} else {
			return False;
		}       
	}
}
?> 
