<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Meta {

	private $meta_resources = array();
	private $raw_tags = array();

	function __construct() {
		log_message('debug', "Meta Class Initialized");
	}

	function init() {
		$this->loadFromView("themes/" . THEME . "/meta/default");
	}

	function setTitle($title) {
		$this->meta_resources['title'] = str_replace('{SITE_NAME}', config_item('SITE_NAME'), $title);
	}

	function getTitle() {
		return $this->meta_resources['title'];
	}

	function renderTitle() {
		return "<title>{$this->getTitle()}</title>\r\n";
	}

	function setCharset($charset) {
		$this->meta_resources['charset'] = $charset;
	}

	function getCharset() {
		return $this->meta_resources['charset'];
	}

	function renderCharset() {
		return "<meta charset='{$this->getCharset()}'>\r\n";
	}

	function addTag($name, $content) {
		$this->meta_resources[$name] = $content;
	}

	function addRawTag($name, $tag) {
		$this->raw_tags[$name] = $tag;
	}

	function getTag($name) {
		if (array_key_exists($name, $this->meta_resources)) {
			return $this->meta_resources[$name];
		}

		return false;
	}

	function renderTag($name) {
		return '<meta name="' . $name . '" content="' . $this->getTag($name) . '" />' . "\r\n";
	}

	function render() {
		$output = '';
		foreach ($this->meta_resources as $name => $content) {
			$function_name = "render" . ucwords(strtolower($name));
			if (method_exists($this, $function_name)) {
				$output .= $this->$function_name($name);
			} else {
				$output .= $this->renderTag($name);
			}
		}
		foreach ($this->raw_tags as $name => $content) {
			$output .= $content;
		}
		return $output;
	}

}
