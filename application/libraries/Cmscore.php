<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Cmscore {

	private $page = FALSE;
	private $page_blocks = FALSE;
	private $page_fields = FALSE;
	private $global_blocks = array();
	private $admin_logged_in = false;

	function loadPage($alias_override = FALSE) {
		$CI = & get_instance();
		$CI->load->model('cms/Pagemodel');
		$CI->load->model('cms/Menumodel');
		$CI->load->helper('text');
		$CI->load->helper('url');

		//Language
		$lang = $CI->router->getLanguage();

		//Page Alias
		$alias = 'homepage';
		$segment_1 = $CI->uri->uri_string();
		if ($segment_1) {
			$alias = ltrim($segment_1, '/');
		}

		//Alias override if passed in as arguement
		if ($alias_override) {
			$alias = $alias_override;
		}

		//Get Page Details
		$page = $CI->Pagemodel->getCMSPage($alias, $lang);

		if (!$page) {
			return FALSE;
		}

		$this->setPage($page);
		return $page;
	}

	function getNode($content_type, $alias) {
		$CI = & get_instance();
		$CI->load->model('cms/Pagemodel');
		$CI->load->model('cms/Menumodel');
		$CI->load->helper('text');
		$CI->load->helper('url');

		//Language
		$lang = 'en';

		$lang_trigger = FALSE;
		$lang_uri = $CI->uri->uri_string();
		if ($lang_uri) {
			$lang_arr = explode('/', $lang_uri);
			if (count($lang_arr) > 1) {
				$lang_code = $lang_arr[0];
				$CI->db->where('language_code', $lang_code);
				$rs = $CI->db->get('language');
				if ($rs->num_rows() == 1) {
					$lang = $lang_code;
					$lang_trigger = TRUE;
				}
			}
		}

		//Get Page Details
		$page = $CI->Pagemodel->getNode($content_type, $alias, $lang);
		if (!$page) {
			return FALSE;
		}

		$this->setPage($page);

		return $page;
	}

	function getTextNode($alias) {
		return $this->getNode(2, $alias);
	}

	function getWYSIWYGNode($alias) {
		return $this->getNode(3, $alias);
	}

	function renderPage($page) {
		$CI = & get_instance();

		//Caching Flag
		switch ($page['enable_page_cache']) {
			case 1:
				$enable_caching = DWS_ENABLE_GLOBAL_CACHE;
				break;
			case 2:
				$enable_caching = TRUE;
				break;
			case 3:
				$enable_caching = false;
				break;
			default:
				$enable_caching = false;
		}
		if (!empty($_POST)) {
			$enable_caching = false;
		}

		if ($enable_caching && $generated_html = $CI->cache->file->get($page['page_i18n_id'])) {
			$CI->output->set_output($generated_html);
			$CI->output->_display();
			exit();
		}

		//Body class
		$CI->html->setBodyClass("page_" . str_replace('/', '_', $page['page_uri']));
		//Meta Tags
		$CI->meta->setTitle($page['browser_title']);
		if ($page['meta_description'] != '') {
			$CI->meta->addTag('description', $page['meta_description']);
		}
		if ($page['meta_keywords'] != '') {
			$CI->meta->addTag('keywords', $page['meta_keywords']);
		}

		//Assets
		$file_name = str_replace('/', '_', $page['page_uri']);



		//Template modules
		if ($page['front_modules']) {
			$modules = explode(',', $page['front_modules']);
			foreach ($modules as $template_module) {
				$CI->load->library("modules/template/$template_module");
				$CI->$template_module->init();
			}
		}


		$generated_html = '';
		$shell = array();
		//CMS Page specific template
		if (trim($page['template_path']) == '') {
			$generated_html = $CI->load->view("themes/" . THEME . "/templates/{$page['template_alias']}", $shell, true);
		} else {
			$generated_html = $CI->load->view("themes/" . THEME . "/templates/{$page['template_path']}/{$page['template_alias']}", $shell, true);
		}

		$generated_html = $this->tagsAndSnippets($generated_html);

		$CI->output->set_output($generated_html);
		$CI->output->_display();
		exit();
	}

	function field($alias) {
		if ($this->page_fields && isset($this->page_fields[$alias])) {
			return $this->page_fields[$alias];
		}
		return FALSE;
	}

	function getPageAlias() {
		if ($this->page) {
			return $this->page['page_uri'];
		}
	}

	function setPage($page) {
		$this->page = $page;
	}

	function getPage() {
		return $this->page;
	}

	function renderAllSections($page = FALSE) {
		$CI = & get_instance();
		$CI->load->model('cms/Pagemodel');

		if ($page) {
			$this->page = $page;
		}

		//Is logged in as admin
		$this->admin_logged_in = $this->checkAdminLogin();


		$output = '';
		$sections = $this->fetchPageSections($this->page['page_i18n_id']);

		if ($sections) {
			foreach ($sections as $section) {
				$output .= $this->renderSection($section);
			}
		}
		return $output;
	}

	function renderSectionByAlias($alias = FALSE) {
		$CI = & get_instance();
		$CI->load->model('cms/Pagemodel');

		if (!$alias) {
			return FALSE;
		}

		$section = $CI->Pagemodel->fetchSectionByAlias($this->page['page_i18n_id'], $alias);
		if (!$section) {
			return FALSE;
		}

		return $this->renderSection($section);
	}

	function renderSectionByID($section_id, $page_id) {
		$CI = & get_instance();
		$CI->load->model('cms/Pagemodel');

		if (!$section_id) {
			return FALSE;
		}

		//Fetch Section 
		$section = $CI->Pagemodel->fetchSectionById($page_id, $section_id);


		return $this->renderSection($section);
	}

	function renderGlobalSectionByAlias($alias = FALSE) {
		$CI = & get_instance();
		$CI->load->model('cms/Pagemodel');

		if (!$alias) {
			return FALSE;
		}

		$section = $this->fetchGlobalSectionByAlias($alias);
		if (!$section) {
			return FALSE;
		}

		return $this->renderGlobalSection($section);
	}

	function renderSection($section) {
		$output = '';

		$CI = & get_instance();

		/* $global_section = array();
		  if ($section['global_section_id'] != 0) {
		  $global_section = $this->fetchGlobalSectionById($section['global_section_id']);
		  } */
		$section['page_section_block_template'] = ($section['page_section_block_template']) ? $section['page_section_block_template'] : $section['section_block_template'];
		if ($section['global_section_id'] != 0) {
			$section['page_section_background'] = ($section['page_section_background']) ? $section['page_section_background'] : $section['section_background'];
			$section['page_section_name'] = ($section['page_section_name']) ? $section['page_section_name'] : $section['section_name'];
			$section['page_section_img_medium'] = ($section['page_section_img_medium']) ? $section['page_section_img_medium'] : $section['section_img_medium'];
			$section['page_section_img_small'] = ($section['page_section_img_small']) ? $section['page_section_img_small'] : $section['section_img_small'];
			$section['page_section_template'] = ($section['page_section_template']) ? $section['page_section_template'] : $section['section_template'];
			$section['page_section_block_template'] = ($section['page_section_block_template']) ? $section['page_section_block_template'] : $section['section_block_template'];
			$section['page_section_updated_on'] = ($section['section_updated_on'] > $section['page_section_updated_on']) ? $section['section_updated_on'] : $section['page_section_updated_on'];
		}

		if (!$section['page_section_img_medium']) {
			$section['page_section_img_medium'] = $section['page_section_background'];
		}
		if (!$section['page_section_img_small']) {
			$section['page_section_img_small'] = $section['page_section_background'];
		}

		//Fetch blocks		
		$blocks = array();
		$blocks_arr = array();
		if (isset($section['blocks'])) {
			$blocks = $section['blocks'];
		}
		if ($blocks) {
			foreach ($blocks as $block) {

				$block['page_section_updated_on'] = $section['global_section_id'] == 0 && $block['page_block_template'] != '' && $block['page_block_updated_on'] > $section['page_section_updated_on'] ? $block['page_block_updated_on'] : $section['page_section_updated_on'];
				$block['block_alias'] = $block['page_block_alias'] ? $block['page_block_alias'] : $block['block_alias'];

				if ($block['page_global_block_id'] == 0) {
					$block['block_template'] = $block['page_block_template'] ? $block['page_block_template'] : $section['page_section_block_template'];
				}
				if ($section['global_section_id'] != 0) {
					$block['block_template'] = $block['block_template'] != '' ? $block['block_template'] : $section['section_block_template'];
					$block['page_section_updated_on'] = $block['block_template'] != '' && $block['block_updated_on'] > $section['section_updated_on'] ? $block['block_updated_on'] : $section['section_updated_on'];
				}
				$block['additional_fields'] = $this->_additional_fields($block);

				$block['compiled'] = $this->_renderBlock($block);
				$blocks_arr[] = $this->_renderBlock($block, false, true);
			}
		}
		$section_data = array();
		$section_data['blocks'] = $blocks_arr;
		$section_data['page_section'] = $section;
		$section_data['is_admin'] = false;
		$section_data['page'] = $this->page;

		$section_data['page_blocks_content'] = $blocks_arr;

		$output .= $CI->load->view($this->_sectionTemplate($section), $section_data, TRUE);

		$output = $this->tagsAndSnippets($output);


		return str_ireplace(array('{PAGE_SECTION_CLASS}', '{INC-HEADER-MENU}'), array('section section_' . $section['page_section_id'] . ' section_' . $section['page_section_alias']), $output);
	}

	function renderGlobalSection($section) {
		$output = '';
		$CI = & get_instance();

		if (!$section['page_section_img_medium']) {
			$section['page_section_img_medium'] = $section['page_section_background'];
		}
		if (!$section['page_section_img_small']) {
			$section['page_section_img_small'] = $section['page_section_background'];
		}

		$section_data = array();
		$section_data['page_section'] = $section;
		$output = $CI->load->view($this->_globalsectionTemplate($section), $section_data, TRUE);

		$output = $this->tagsAndSnippets($output);


		return $output;
	}

	function getPages($node_type, $content_type_alias, $lang = 'en', $params = false) {
		$CI = & get_instance();
		$CI->db->from('page_i18n');
		$CI->db->join('page', 'page.page_id = page_i18n.page_id');
		$CI->db->join('page_template', 'page_template.page_template_id = page.page_template_id', 'LEFT');
		$CI->db->join('content_type', 'content_type.content_type_id = page.content_type_id');
		$CI->db->where('language_code', $lang);
		$CI->db->where('page_status', 'Publish');
		$CI->db->where('node_type', $node_type);
		$CI->db->where('content_type.content_type_alias', $content_type_alias);
		if (isset($params['limit'])) {
			$CI->db->limit($params['limit']);
		}
		if (isset($params['sort'])) {
			$CI->db->order_by('page_sort_order', $params['sort']);
		} else {
			$CI->db->order_by('page_sort_order', 'ASC');
		}
		$rs = $CI->db->get();
		if ($rs && $rs->num_rows() > 0) {
			return $rs->result_array();
		}
		return false;
	}

	function tagsAndSnippets($output) {
		$CI = & get_instance();

		//Shortcodes
		$matches = array();
		preg_match_all('/{cms:library:(.*?)}/i', $output, $matches);
		$modules_arr = $matches[1];
		foreach ($modules_arr as $module) {
			$parts = explode(':', $module);

			if (count($parts) < 2) {
				continue;
			}

			$mod_class_name = $parts[0];
			$mod_function = $parts[1];
			$mod_params = array();
			if (strpos($mod_function, '?')) {
				$query_str = str_replace('&amp;', '&', parse_url($mod_function, PHP_URL_QUERY));
				parse_str($query_str, $mod_params);
				//parse_str(parse_url($mod_function, PHP_URL_QUERY), $mod_params);
				$mod_function = parse_url($mod_function, PHP_URL_PATH);
			}

			//Run Function
			$mod_output = $CI->$mod_class_name->$mod_function($mod_params);
			$output = str_replace("{cms:library:$module}", $mod_output, $output);
		}

		return str_ireplace(array('{PAGE_TITLE}', '{PAGE_NAME}'), array($this->page['page_title'], $this->page['page_name']), $output);
	}

	function _sectionTemplate($section) {
		$CI = & get_instance();

		//No template, use default
		if (!$section['page_section_template']) {
			return "themes/" . THEME . "/sections/default";
		}

		$filename = "{$section['page_section_id']}.php";
		$filepath = APPPATH . "views/themes/" . THEME . "/sections/compiled/$filename";
		$themepath = "themes/" . THEME . "/sections/compiled/$filename";


		//Template exists in cache, return cache
		if (file_exists($filepath) && filemtime($filepath) >= $section['page_section_updated_on']) {
			return $themepath;
		}

		//Store template in cache
		file_put_contents($filepath, $section['page_section_template']);

		return $themepath;
	}

	function _globalsectionTemplate($section) {
		$CI = & get_instance();

		//No template, use default
		if (!$section['page_section_template']) {
			return "themes/" . THEME . "/global-section/default";
		}

		$filename = "{$section['global_section_id']}.php";
		$filepath = APPPATH . "views/themes/" . THEME . "/global-section/compiled/$filename";
		$themepath = "themes/" . THEME . "/global-section/compiled/$filename";

		//Template exists in cache, return cache
		if (file_exists($filepath) && filemtime($filepath) >= $section['page_section_updated_on']) {
			return $themepath;
		}

		//Store template in cache
		file_put_contents($filepath, $section['page_section_template']);

		return $themepath;
	}

	function renderBlock($alias, $template = false) {
		$CI = & get_instance();
		$CI->load->model('cms/Pagemodel');

		$block = $CI->Pagemodel->fetchBlockByAlias($this->page['page_i18n_id'], $alias);

		if (!$block) {
			return FALSE;
		}

		//Fetch Section 
		$section = $CI->Pagemodel->fetchSectionById($this->page['page_i18n_id'], $block['page_section_id']);

		$global_section = array();
		if ($section['global_section_id'] != 0) {
			$global_section = $this->fetchGlobalSectionById($section['global_section_id']);
		}

		if ($global_section) {
			$section['page_section_template'] = ($section['page_section_template']) ? $section['page_section_template'] : $global_section['page_section_template'];
			$section['section_block_template'] = ($section['section_block_template']) ? $section['section_block_template'] : $global_section['section_block_template'];
			$section['page_section_updated_on'] = ($global_section['page_section_updated_on'] > $section['page_section_updated_on']) ? $global_section['page_section_updated_on'] : $section['page_section_updated_on'];
		}

		if ($section['global_section_id'] != 0 && $section['section_block_template'] != '') {
			if ($block['page_block_template'] == '') {
				$block['page_block_template'] = $section['section_block_template'];
			}

			// Will be Used as a flag and block template update
			$block['page_section_updated_on'] = $section['page_section_updated_on'];
		}


		$output = $this->_renderBlock($block, $template);
		return $output;
	}

	function _additional_fields($block) {
		$CI = & get_instance();
		$type_addition_fields = array();


		if ($block['additional_fields']) {
			$block['additional_fields'] = json_decode($block['additional_fields'], TRUE);
		}

		if ($block['page_additional_fields']) {
			$page_additional_fields = json_decode($block['page_additional_fields'], TRUE);
			if ($page_additional_fields) {
				foreach ($page_additional_fields as $key => $val) {
					//if ((isset($block['additional_fields'][$key]) && $page_additional_fields[$key] != '')) {
					if (isset($block['additional_fields'][$key])) {
						if (strip_tags($page_additional_fields[$key]) != '{DEFAULT}') {
							$block['additional_fields'][$key] = $page_additional_fields[$key];
						}
					}
				}
			}
		}

		return $block['additional_fields'];
	}

	function _blockFieldVal($block, $page_var_name, $global_var_name) {
		if (!isset($block[$page_var_name])) {
			if (strip_tags($block[$page_var_name]) == '{DEFAULT}') {
				return $block[$global_var_name];
			}
		}
		return $block[$page_var_name];
	}

	function _renderBlock($block, $template = false, $is_block_arr = false) {

		$CI = & get_instance();
		$response = '';

		if ($block['page_global_block_id'] != 0) {
			//$block['block_title'] = ($block['page_block_title']) ? $block['page_block_title'] : $block['block_title'];
			$block['block_title'] = $this->_blockFieldVal($block, 'page_block_title', 'block_title');

			$block['block_content'] = $this->_blockFieldVal($block, 'page_block_content', 'block_content');
			//Images
			$block['block_image'] = ($block['page_block_image']) ? $block['page_block_image'] : $block['block_image'];
			$block['block_image_medium'] = ($block['page_block_image_medium']) ? $block['page_block_image_medium'] : $block['block_image_medium'];
			$block['block_image_small'] = ($block['page_block_image_small']) ? $block['page_block_image_small'] : $block['block_image_small'];

			$block['block_link'] = $this->_blockFieldVal($block, 'page_block_link', 'block_link');
			$block['link_text'] = $this->_blockFieldVal($block, 'page_block_link_text', 'link_text');
			$block['link_class'] = $this->_blockFieldVal($block, 'page_block_link_class', 'link_class');

			$block['block_link2'] = $this->_blockFieldVal($block, 'page_block_link2', 'link_2');
			$block['link_text2'] = $this->_blockFieldVal($block, 'page_block_link_text2', 'link_2_text');
			$block['link_class2'] = $this->_blockFieldVal($block, 'page_block_link_class2', 'link_2_class');

			$block['block_link3'] = $this->_blockFieldVal($block, 'page_block_link3', 'link_3');
			$block['link_text3'] = $this->_blockFieldVal($block, 'page_block_link_text3', 'link_3_text');
			$block['link_class3'] = $this->_blockFieldVal($block, 'page_block_link_class3', 'link_S_class');


			//Template
			//$block['block_template'] = ($block['page_block_template']) ? $block['page_block_template'] : $block['block_template'];
			//Layout
			$block['block_col_lg'] = ($block['page_block_col_lg']) ? $block['page_block_col_lg'] : $block['block_col_lg'];
			$block['block_col_md'] = ($block['page_block_col_md']) ? $block['page_block_col_md'] : $block['block_col_md'];
			$block['block_col_sm'] = ($block['page_block_col_sm']) ? $block['page_block_col_sm'] : $block['block_col_sm'];
			$block['block_col_xs'] = ($block['page_block_col_xs']) ? $block['page_block_col_xs'] : $block['block_col_xs'];

			$block['block_col_lg_padding'] = ($block['page_block_col_lg_padding']) ? $block['page_block_col_lg_padding'] : $block['block_col_lg_padding'];
			$block['block_col_md_padding'] = ($block['page_block_col_md_padding']) ? $block['page_block_col_md_padding'] : $block['block_col_md_padding'];
			$block['block_col_sm_padding'] = ($block['page_block_col_sm_padding']) ? $block['page_block_col_sm_padding'] : $block['block_col_sm_padding'];
			$block['block_col_xs_padding'] = ($block['page_block_col_xs_padding']) ? $block['page_block_col_xs_padding'] : $block['block_col_xs_padding'];

			$block['block_css_class'] = $this->_blockFieldVal($block, 'page_block_css_class', 'block_css_class');
			$block['block_css_style'] = $this->_blockFieldVal($block, 'page_block_css_style', 'block_css_style');

			$block['block_updated_on'] = ($block['block_updated_on'] > $block['page_block_updated_on']) ? $block['block_updated_on'] : $block['page_block_updated_on'];
		}
		if ($block['page_global_block_id'] == 0) {
			$block['block_title'] = $block['page_block_title'];
			$block['block_content'] = $block['page_block_content'];
			//Images
			$block['block_image'] = $block['page_block_image'];

			$block['block_image_medium'] = $block['page_block_image_medium'];
			$block['block_image_small'] = $block['page_block_image_small'];
			//Link
			$block['block_link'] = $block['page_block_link'];
			$block['link_text'] = $block['page_block_link_text'];
			$block['link_class'] = $block['page_block_link_class'];

			$block['block_link2'] = $block['page_block_link2'];
			$block['link_text2'] = $block['page_block_link_text2'];
			$block['link_class2'] = $block['page_block_link_class2'];

			$block['block_link3'] = $block['page_block_link3'];
			$block['link_text3'] = $block['page_block_link_text3'];
			$block['link_class3'] = $block['page_block_link_class3'];



			//Template
			//	$block['block_template'] = $block['page_block_template'];
			//Layout
			$block['block_col_lg'] = $block['page_block_col_lg'];
			$block['block_col_md'] = $block['page_block_col_md'];
			$block['block_col_sm'] = $block['page_block_col_sm'];
			$block['block_col_xs'] = $block['page_block_col_xs'];

			$block['block_col_lg_padding'] = $block['page_block_col_lg_padding'];
			$block['block_col_md_padding'] = $block['page_block_col_md_padding'];
			$block['block_col_sm_padding'] = $block['page_block_col_sm_padding'];
			$block['block_col_xs_padding'] = $block['page_block_col_xs_padding'];

			$block['block_css_class'] = $block['page_block_css_class'];
			$block['block_css_style'] = $block['page_block_css_style'];
			$block['block_updated_on'] = $block['page_block_updated_on'];
		}

		if (isset($block['page_section_updated_on'])) {
			$block['block_updated_on'] = ($block['page_section_updated_on'] > $block['page_block_updated_on']) ? $block['page_section_updated_on'] : $block['page_block_updated_on'];
		}

		$block['block_image_tag'] = '';
		if ($block['page_block_image']) {
			$block['block_image_tag'] = '<img src="' . $block['page_block_image'] . '" class="img-responsive block-img" />';
		}
		$search = array(
			'{BLOCK_IMAGE_TAG}', '{BLOCK_IMAGE_URL}', '{BLOCK_TITLE}', '{BLOCK_CONTENTS}', '{BLOCK_LINK}', '{BLOCK_LINK_TEXT}', '{BLOCK_LINK_CLASS}',
			'{BLOCK_LINK_2}', '{BLOCK_LINK_TEXT_2}', '{BLOCK_LINK_CLASS_2}', '{BLOCK_LINK_3}', '{BLOCK_LINK_TEXT_3}', '{BLOCK_LINK_CLASS_3}', '{BLOCK_ALIAS}',
			'{BLOCK_CLASS}', '{BLOCK_ID}', '{COL_LARGE}', '{COL_LARGE_PADDING}', '{COL_MED}', '{COL_MED_PADDING}', '{COL_SMALL}', '{COL_SMALL_PADDING}',
			'{COL_X_SMALL}', '{COL_X_SMALL_PADDING}'
		);
                
		$block['block_class'] = '';
		$block['block_id'] = $block['page_block_id'];

		/* if ($this->check_admin()) {
		  $class = ' block_is_admin';
		  } */

		$replace = array(
			$block['block_image_tag'], $block['block_image'], $block['block_title'], $block['block_content'], $block['block_link'], $block['link_text'],
			$block['link_class'], $block['block_link2'], $block['link_text2'], $block['link_class2'], $block['block_link3'], $block['link_text3'],
			$block['link_class3'], $block['page_block_alias'], 'block block_' . $block['page_block_id'] . ' block_' . $block['page_block_alias'] . $block['block_class'],
			$block['page_block_id'], 'col-lg-' . $block['block_col_lg'], 'col-lg-offset-' . $block['block_col_lg_padding'], 'col-md-' . $block['block_col_md'],
			'col-md-offset-' . $block['block_col_md_padding'], 'col-sm-' . $block['block_col_sm'], 'col-sm-offset-' . $block['block_col_sm_padding'],
			'col-xs-' . $block['block_col_xs'], 'col-xs-offset-' . $block['block_col_xs_padding']
		);
		if ($is_block_arr) {
			return $block;
		}

		$block_template = $block['block_template'];
		if (basename(base_url()) == 'admin') {
			$duplicate_link = '';
			$del_link = '';
			$edit_link = '<li><a href="javascript:void(0)" class="block-edit fancybox" data-fancybox-type="iframe" data-fancybox-width="100%" data-fancybox-height="100%" data-link="cms/block/edit/' . $block['page_block_id'] . '">Edit</a></li>';
			if (($block['page_global_block_id'] != 0 && $block['allow_duplicate'] == 1) || $block['page_global_block_id'] == 0) {
				$duplicate_link = '<li>' . anchor("cms/block/duplicate_block/{$block['page_block_id']}", 'Duplicate Block') . '</li>';
			}
			if ($block['page_global_block_id'] == 0 || $block['allow_duplicate'] == 1) {
				$del_link = '<li>' . anchor("cms/block/delete/{$block['page_block_id']}", 'Delete') . '</li>';
			}
			$link_btns = '<div style="display:none;" class="block_link_wrapper block-links-' . $block['page_block_id'] . '"><div style="position: absolute; top: 10px; left: 10px; " class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				 <span class="glyphicon glyphicon-cog"></span> <span class="caret"></span></button><ul class="dropdown-menu">' . $edit_link . '' . $duplicate_link . '' . $del_link . '</ul></div></div>';
			$block_template .= $link_btns;
		}

		//Hardcoded template

		if ($template) {
			$def_template = '';

			$def_template = $CI->load->view("themes/" . THEME . "/blocks/$template", $block, TRUE);


			$response = $def_template . '' . $block_template;
			return str_replace($search, $replace, $response);
		}

		//No template, use default
		if (!$block['block_template']) {
			$def_template = $CI->load->view("themes/" . THEME . "/blocks/default", $block, TRUE);
			$response = $def_template . '' . $block_template;
			return str_replace($search, $replace, $response);
		}

		$filename = "{$block['page_block_id']}.php";
		$filepath = APPPATH . "views/themes/" . THEME . "/blocks/compiled/$filename";

		//Template exists in cache, use cache
		if (file_exists($filepath) && filemtime($filepath) >= $block['block_updated_on']) {
			$response = $CI->load->view("themes/" . THEME . "/blocks/compiled/$filename", $block, TRUE);
		} else {
			//Store template in cache
			file_put_contents($filepath, $block_template);
			$response = $CI->load->view("themes/" . THEME . "/blocks/compiled/$filename", $block, TRUE);
		}

		return str_replace($search, $replace, $response);
	}

	function renderGlobalBlock($alias, $template = 'default') {
		$this->CI = & get_instance();

		$block = FALSE;

		if (array_key_exists($alias, $this->global_blocks)) {
			$block = $this->global_blocks[$alias];
		} else {
			$this->CI->db->where('block_alias', $alias);
			$rs = $this->CI->db->get('global_block');
			if ($rs && $rs->num_rows() == 1) {
				$block = $rs->row_array();
				$this->global_blocks[$alias] = $block;
			}
		}

		if (!$block) {
			return '';
		}

		$output = $this->_renderGlobalBlock($block, $template);
		return $output;
	}

	function renderSnippet($alias) {
		$this->CI = & get_instance();
		$this->CI->db->where('content_snippet_alias', $alias);
		$rs = $this->CI->db->get('content_snippet');
		if ($rs && $rs->num_rows() == 1) {
			$content_snippet = $rs->row_array();
			return $content_snippet['content_snippet'];
		}
		return '';
	}

	function _renderGlobalBlock($block) {
		$this->CI = & get_instance();

		//No template, use default			
		if (!$block['block_template']) {
			return $this->CI->load->view("themes/" . THEME . "/global_blocks/default", $block, TRUE);
		}

		$filename = "{$block['block_alias']}.php";
		$filepath = APPPATH . "views/themes/" . THEME . "/global_blocks/$filename";

		//Template exists in cache, return cache
		if (file_exists($filepath) && filemtime($filepath) >= $block['block_updated_on']) {
			return $this->CI->load->view("themes/" . THEME . "/global_blocks/$filename", $block, TRUE);
		}

		//Store template in cache
		file_put_contents($filepath, $block['block_template']);
		return $this->CI->load->view("themes/" . THEME . "/global_blocks/$filename", $block, TRUE);
	}

	function fetchPageSections($page_i18n_id) {
		$CI = & get_instance();



		$CI->db->from('page_section');
		$CI->db->join('global_section', 'global_section.global_section_id = page_section.global_section_id', 'LEFT');
		$CI->db->where('page_i18n_id', $page_i18n_id);


		$CI->db->where('page_section_is_active', 1);


		$CI->db->order_by('page_section_sort_order', 'ASC');
		$rs = $CI->db->get();

		if ($rs && $rs->num_rows() > 0) {
			$section_ids = array();
			$sections = array();
			$all_sections = array();
			foreach ($rs->result_array() as $row) {
				$section_ids[] = $row['page_section_id'];
				$sections[] = $row;
			}

			//Fetch All Blocks
			$section_blocks = array();
			$CI->db->from('page_block');
			$CI->db->join('global_block', 'global_block.global_block_id = page_block.page_global_block_id', 'LEFT');
			$CI->db->where_in('page_section_id', $section_ids);
			$CI->db->where('page_block_is_active', 1);
			$CI->db->order_by('page_block_sort_order', 'ASC');
			$blocks_rs = $CI->db->get();
			if ($blocks_rs && $blocks_rs->num_rows() > 0) {
				foreach ($blocks_rs->result_array() as $block) {
					$section_blocks[$block['page_section_id']][] = $block;
				}
			}

			if ($sections) {
				foreach ($sections as $row) {
					$tmp = $row;
					if (isset($section_blocks[$row['page_section_id']])) {
						$tmp['blocks'] = $section_blocks[$row['page_section_id']];
					}
					$all_sections[] = $tmp;
				}
			}
			return $all_sections;
		}
		return FALSE;
	}

	function fetchBlocksBySectionId($section_id) {
		$CI = & get_instance();

		$CI->db->from('page_block');
		$CI->db->join('global_block', 'global_block.global_block_id = page_block.page_global_block_id', 'LEFT');
		$CI->db->where('page_section_id', $section_id);
		$CI->db->where('page_block_is_active', 1);
		$CI->db->order_by('page_block_sort_order', 'ASC');
		$rs = $CI->db->get();

		return $rs->result_array();
	}

	function fetchGlobalSectionById($global_section_id) {
		$CI = & get_instance();

		$CI->db->where('global_section_id', $global_section_id);
		$rs = $CI->db->get('global_section');
		if ($rs && $rs->num_rows() == 1) {
			return $rs->row_array();
		}
		return FALSE;
	}

	function fetchGlobalBlockById($global_block_id) {
		$CI = & get_instance();

		$CI->db->where('global_block_id', $global_block_id);
		$rs = $CI->db->get('global_block');
		if ($rs && $rs->num_rows() == 1) {
			return $rs->row_array();
		}
		return FALSE;
	}

	function fetchGlobalSectionByAlias($global_section_alias) {
		$CI = & get_instance();

		$CI->db->where('page_section_alias', $global_section_alias);
		$rs = $CI->db->get('global_section');
		if ($rs->num_rows() == 1) {
			return $rs->row_array();
		}
		return false;
	}

	private function checkAdminLogin() {
		$CI = & get_instance();

		if (!isset($_COOKIE['rubyzsalonadmin'])) {
			return FALSE;
		}

		$sess_id = $_COOKIE['rubyzsalonadmin'];

		$CI->db->select('session.data');
		$CI->db->where('id', $sess_id);
		$rs = $CI->db->get('session');
		if (!$rs || $rs->num_rows() != 1) {
			return FALSE;
		}

		$data = $rs->row_array();
		if (!$data['data']) {
			return FALSE;
		}

		return True;
	}

	function check_admin() {
		return $this->admin_logged_in;
	}

}
