<?php
require_once('Encrypt.php');

function testPasswordEncryption($oldPass, $newPass) {
	$encrypted_passwd = Encrypt::encryptPassword($oldPass);
	$salt = substr($encrypted_passwd, 0, 64);
	$hash = $salt . $newPass;
	for ( $i = 0; $i < 100; $i ++ ) {
		$hash = hash('sha256', $hash);
	}
	$hash = $salt . $hash;
	if ($hash == $encrypted_passwd) {
		echo strlen($encrypted_passwd);
		echo "You're in! : ".$encrypted_passwd;
	} else {
		echo "Retry Sonny Boy!";
	}
	echo "\n";
	echo Encrypt::checkPassword('Pass1234', $encrypted_passwd);
	echo "\n";
}

testPasswordEncryption("Pass1234", "Pass1234");
?>
