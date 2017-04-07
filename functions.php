<?php

session_start();

//Class for Github Authorization via CURL
class Main {

	public $username;
	private $password;

	public function __construct ($username, $password) {
		$this->username = $username;
		$this->password = $password;
	}

	public function githubAuth () {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201');
		curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/user');
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, "$this->username:$this->password");

		$result = json_decode(curl_exec($ch), true);

		curl_close($ch);

		return in_array($this->username, $result, true) ? true : false;
	}

}

//Set value into SESSION and return result
$auth = new Main($_POST['login'], $_POST['pass']);

if ($auth->githubAuth() == true) { 
	$_SESSION['login'] = $auth->username;
	echo true;
} else {
	echo false;
}
