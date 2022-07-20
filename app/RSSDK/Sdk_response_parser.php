<?php

namespace App\RSSDK;

define('SDK_SEPARATOR','|');
define('SDK_NEWLINE',';');
class Sdk_response_parser {
	var $cursor;
	var $response;
	var $isok;
	var $errcode;
	var $errmsg;

	function Sdk_response_parser($response) {
		$this->response = $response;
		$this->cursor = 0;
		print_r($response);
		if (strlen($response) >= 2) {
			$code = $this->next_string();
			if ('OK' == $code) {
				$this->isok = true;
			}
			if ('KO' == $code) {
				$this->isok = false;
				$this->errcode = $this->next_int();
				$this->errmsg = $this->next_string();
			}
		}
	}

	function next_string() {
		$nstr = '';
//		echo 'cursor:|'.$this->cursor.'|';
//		echo 'nstr:|'.$nstr.'|';
		while (($this->response[$this->cursor] != SDK_SEPARATOR) &&
			($this->response[$this->cursor] != SDK_NEWLINE)) {
//		echo 'Cnstr:|'.$nstr.'|';
			$nstr = $nstr.$this->response[$this->cursor++];
			if ($this->cursor >= strlen($this->response))
				break;
		}
//		echo 'Enstr:|'.$nstr.'|';
		if ($this->cursor < strlen($this->response) && $this->response[$this->cursor] != SDK_NEWLINE) {
			$this->cursor++;
		}
		return urldecode($nstr);
	}
	function next_int() {
		return (int)$this->next_string();
	}
	function next_long() {
		return (float)$this->next_string();
	}

	function go_next_line() {
		while ($this->response[$this->cursor++] != SDK_NEWLINE) {
			if ($this->cursor > strlen($this->response)) {
				return false;
			}
		}
		return strlen($this->response) != $this->cursor;
	}

	function get_result_array() {
		return array('ok' => $this->isok, 'errcode' => $this->errcode, 'errmsg' => $this->errmsg);
	}
}

?>