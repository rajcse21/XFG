<?php

class Menumodel extends CI_Model {

    //Function show menu details
    function fetchByID($id) {
        $this->db->where('menu_id', $id);
        $rs = $this->db->get('menu');
        if ($rs && $rs->num_rows() == 1) {
            $menu = $rs->row_array();
            $menu_items = $this->listAllItems($menu['menu_id']);
            $menu['menu_items'] = $menu_items;
            return $menu;
        }

        return false;
    }
    

    function fetchByAlias($alias) {
        $this->db->where('menu_alias', $alias);
        $rs = $this->db->get('menu');
        if ($rs->num_rows() == 1) {
            $menu = $rs->row_array();
            $menu_items = $this->listAllItems($menu['menu_id']);
            $menu['menu_items'] = $menu_items;
            return $menu;
        }

        return false;
    }

    function getByAlias($alias) {
        $this->db->where('menu_alias', $alias);
        $rs = $this->db->get('menu');
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return false;
    }

    //List all items
    function listAllItems($menu_id) {
        $this->db->from('menu_item');
        $this->db->join('menu', 'menu_item.menu_id = menu.menu_id');
        $this->db->join('page_i18n', "page_i18n.page_id = menu_item.content_id AND " . $this->db->dbprefix . "page_i18n.page_status='publish'", 'LEFT OUTER');
        $this->db->join('page', 'page.page_id = page_i18n.page_id', 'LEFT OUTER');
        $this->db->order_by('menu_sort_order', 'ASC');
        $this->db->where('menu_item.menu_id', intval($menu_id));
        $rs = $this->db->get();
        return $rs->result_array();
    }

    function getMenuItemURI($row) {
        if ($row['is_placeholder'] == 1) {
            return 'javascript:void(0)';
        } elseif ($row['url'] != '') {
            return $row['url'];
        } else {
            return $row['page_uri'];
        }
        return false;
    }

    function getMenuByAlias($alias) {
        $this->db->from('menu');
        $this->db->join('menu_item', 'menu_item.menu_id = menu.menu_id');
        $this->db->join('page', 'page.page_id = menu_item.page_id', 'LEFT OUTER');
        $this->db->order_by('menu_sort_order', 'ASC');
        $this->db->where('menu_alias', $alias);
        $rs = $this->db->get();
        return $rs->result_array();
    }

    function menu($params) {
        if (!isset($params['menu_alias']))
            return false;

        $menu = $this->fetchByAlias($params['menu_alias']);
        if (!$menu)
            return false;

        $params['menu_id'] = $menu['menu_id'];

        //Fetch root menu items
        $this->db->from('menu_item');
        $this->db->join('page', 'page.page_id = menu_item.content_id', 'LEFT OUTER');
        $this->db->where('menu_item.parent_id', 0);
        $this->db->where('menu_item.menu_id', $params['menu_id']);
        $this->db->order_by('menu_sort_order', 'ASC');
        $rs = $this->db->get();
        if ($rs->num_rows() == 0)
            return false;
        $rows = $rs->result_array();

        $params['first_menu_id'] = $rows[0]['menu_item_id'];
        $tmp = array_pop($rows);
        $params['last_menu_id'] = $tmp['menu_item_id'];

        $output = '';

        if (isset($params['menu_link']) && $params['menu_link'] == 1) {
            if ($menu['menu_link'] != '') {
                $output .= '<h4><a href="' . $menu['menu_link'] . '">' . $menu['menu_title'] . '</a></h4>';
            } else {
                $output .= '<h4>' . $menu['menu_title'] . '</h4>';
            }
        }

        $output .= $this->_menu($params);

        $output = str_replace('{MENU}', $output, $params['ul_format']);
        $output = str_replace('{MENU_TITLE}', $menu['menu_title'] . "&nbsp;", $output);
        return $output;
    }

    function _menu($params, $parent_id = 0, $output = '') {

        $this->db->from('menu_item');
        $this->db->join('menu', 'menu_item.menu_id = menu.menu_id');
        $this->db->join('page_i18n', "page_i18n.page_id = menu_item.content_id AND page_status='publish'", 'LEFT OUTER');
        $this->db->where('menu_item.parent_id', $parent_id);
        $this->db->where('menu_item.menu_id', $params['menu_id']);
        $this->db->order_by('menu_sort_order', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            if ($parent_id == 0) {
                //$output = "<ul class='reset'>\r\n";
            } else {
                $output .= "<ul>\r\n";
            }

            foreach ($query->result_array() as $row) {
                $href = '';
                $li_class = '';
                $additional_attr = '';
                if ($row['is_placeholder'] == 1) {
                    $href = 'javascript:void(0)';
                } elseif ($row['url'] != '') {
                    $href = $row['url'];
                    if ($row['new_window'] == 1) {
                        $additional_attr = ' target="_blank"';
                    }
                    $url_tags = array('{SERVICES}');
                    if (in_array($row['url'], $url_tags)) {
                        $href = 'javascript:void(0)';
                    }
                    if ($row['url'] == '{SERVICES}') {
                        $href = 'services';
                    }

                    $href = str_replace(array('{BASE_URL}', '{BASE_URL_SSL}', '{BASE_URL_NOSSL}'), array($this->http->baseURL(), $this->http->baseURLSSL(), $this->http->baseURLNoSSL()), $href);
                } else {
                    $href .= $row['page_uri'];
                }
                if ($row['menu_item_class'] == 'megamenu_trigger') {
                    $href = 'javascript:void(0)';
                    $li_class = 'menudrop';
                }

                $class_arr = array();
                $current_class = '';
                $base_url = str_ireplace(array('http://', 'https://', 'http://www', 'https://www'), '', $this->http->baseURL());
                $current_url = str_ireplace(array('http://', 'https://', 'http://www', 'https://www'), '', current_url());
                $current_url = str_ireplace($base_url, '', $current_url);
                $href_url = str_ireplace(array('http://', 'https://', 'http://www', 'https://www'), '', $href);
                if (strcasecmp($current_url, $href_url) === 0) {
                    $class_arr[] = 'current';
                    //$current_class = 'btn_default active current';
                    $current_class = 'active';
                }
				
                $current_class .= $li_class;
                //echo "$current_url :: $href_url :: $current_class<br />";

                if ($row['menu_item_class'] != '') {
                    $class_arr[] = $row['menu_item_class'];
                }

                if (count($class_arr) > 0) {
                    $additional_attr = ' class="' . implode(" ", $class_arr) . '"';
                }

                if (in_array('megamenu_trigger', $class_arr)) {
                    $menualias = str_replace(' ', '_', strtolower($row['menu_item_name']));
                    $additional_attr .= ' data-menu="menu_' . $menualias . '"';
                }
                /* if (in_array('menu_index_trigger', $class_arr)) {
                  $menualias = str_replace(' ', '_', strtolower($row['menu_item_name']));
                  $additional_attr .= ' data-index="menu_' . $menualias . '"';
                  } */


                if ($parent_id == 0) {
                    $link = $params['level_1_format'];
                } else {
                    $link = $params['level_2_format'];
                }
                $match = array('{HREF}', '{LINK_NAME}', '{ATTRIBUTES}');
                $replace = array($href, $row['menu_item_name'], $additional_attr);

                $output .= '<li class="' . $current_class . '">';
                $output .= str_replace($match, $replace, $link);
                $output .= "\r\n";

                if ($row['url'] == '{SERVICES}') {
                    $output .= '<ul>';
                    $output .= $this->servicesMenu($row);
                    $output .= '</ul>';
                }
                $output = $this->_menu($params, $row['menu_item_id'], $output);

                $output .= "</li>\r\n";
            }
            if ($parent_id > 0) {
                $output .= "</ul>\r\n";
            }
        }
        return $output;
    }

    function servicesMenu($menu) {
        // $this->load->model('cms/Pagemodel');
        $services = $this->cmscore->getPages(1, 'services');

        $inner = array();
        $inner['services'] = $services;

        $filename = "{$menu['menu_alias']}.php";
        $filepath = APPPATH . "views/themes/" . THEME . "/layout/menu/services/$filename";
        $themepath = "themes/" . THEME . "/layout/menu/services/$filename";

        //Template exists in cache, return cache
        if (file_exists($filepath)) {
            return $this->load->view('themes/' . THEME . '/layout/menu/services/' . $filename, $inner, TRUE);
        }
        return $this->load->view('themes/' . THEME . '/layout/menu/services/default', $inner, TRUE);
    }

    function menu_attributes($row) {
        $href = '';
        $li_class = '';
        $additional_attr = '';
        if ($row['is_placeholder'] == 1) {
            $href = 'javascript:void(0)';
        } elseif ($row['url'] != '') {
            $href = $row['url'];
            if ($row['new_window'] == 1) {
                $additional_attr = ' target="_blank"';
            }
            $url_tags = array('{SERVICES}');
            if (in_array($row['url'], $url_tags)) {
                $href = 'javascript:void(0)';
            }
            $href = str_replace(array('{BASE_URL}', '{BASE_URL_SSL}', '{BASE_URL_NOSSL}'), array($this->http->baseURL(), $this->http->baseURLSSL(), $this->http->baseURLNoSSL()), $href);
        } else {
            $href .= $row['page_uri'];
        }
        if ($row['menu_item_class'] == 'megamenu_trigger') {
            $href = 'javascript:void(0)';
            $li_class = 'menudrop';
        }

        $class_arr = array();
        $current_class = '';
        $base_url = str_ireplace(array('http://', 'https://', 'http://www', 'https://www'), '', $this->http->baseURL());
        $current_url = str_ireplace(array('http://', 'https://', 'http://www', 'https://www'), '', current_url());
        $current_url = str_ireplace($base_url, '', $current_url);
        $href_url = str_ireplace(array('http://', 'https://', 'http://www', 'https://www'), '', $href);
        if (strcasecmp($current_url, $href_url) === 0) {
            $class_arr[] = 'current';
            //$current_class = 'btn_default active current';
            $current_class = 'active';
        }

        $current_class .= $li_class;
        //echo "$current_url :: $href_url :: $current_class<br />";

        if ($row['menu_item_class'] != '') {
            $class_arr[] = $row['menu_item_class'];
        }

        if (count($class_arr) > 0) {
            $additional_attr = ' class="' . implode(" ", $class_arr) . '"';
        }

        if (in_array('megamenu_trigger', $class_arr)) {
            $menualias = str_replace(' ', '_', strtolower($row['menu_item_name']));
            $additional_attr .= ' data-menu="menu_' . $menualias . '"';
        }
        $link = '<a href="{HREF}"{ATTRIBUTES}>{LINK_NAME}</a>';
        $match = array('{HREF}', '{LINK_NAME}', '{ATTRIBUTES}');
        $replace = array($href, $row['menu_item_name'], $additional_attr);
        return ['current_class' => $current_class, 'match' => $match, 'replace' => $replace, 'link' => $link];
    }

    function parentmenu($params) {
        if (!isset($params['menu_alias'])) {
            return false;
        }

        $menu = $this->getByAlias($params['menu_alias']);
        if (!$menu) {
            return false;
        }

        $params['menu_id'] = $menu['menu_id'];
        $this->db->from('menu_item');
        $this->db->join('menu', 'menu_item.menu_id = menu.menu_id');
        $this->db->join('page_i18n', "page_i18n.page_id = menu_item.content_id AND page_status='publish'", 'LEFT OUTER');
        $this->db->where('menu_item.parent_id', 0);
        $this->db->where('menu_item.menu_id', $params['menu_id']);
        $this->db->order_by('menu_sort_order', 'ASC');
        $rs = $this->db->get();
        if ($rs->num_rows() == 0) {
            return false;
        }
        $parent_menu_rs = $rs->result_array();

        //Children
        $children = array();
        $this->db->from('menu_item');
        $this->db->join('menu', 'menu_item.menu_id = menu.menu_id');
        $this->db->join('page_i18n', "page_i18n.page_id = menu_item.content_id AND page_status='publish'", 'LEFT OUTER');
        $this->db->where('menu_item.parent_id >', 0);
        $this->db->where('menu_item.menu_id', $params['menu_id']);
        $this->db->order_by('menu_sort_order', 'ASC');
        $child_rs = $this->db->get();

        foreach ($child_rs->result_array() as $child) {
            $children[$child['parent_id']][] = $child;
        }

        foreach ($parent_menu_rs as $row) {
            $parent_tmp = $row;
            if (isset($children[$row['menu_item_id']])) {
                $parent_tmp['children'] = $children[$row['menu_item_id']];
            }
            $parent_menu[] = $parent_tmp;
        }
        return $parent_menu;
    }

    function childmenu($menu) {
        $child_menu = array();
        $this->db->from('menu_item');
        $this->db->join('page_i18n', "page_i18n.page_id = menu_item.content_id AND page_status='publish'", 'LEFT OUTER');
        $this->db->where('parent_id', $menu['menu_item_id']);
        $this->db->order_by('menu_sort_order', 'ASC');
        $rs = $this->db->get();
        if ($rs && $rs->num_rows() > 0) {
            foreach ($rs->result_array() as $row) {
                $child_menu[$row['parent_id']][] = $row;
            }
        }

        return $child_menu;
    }

}

?>
