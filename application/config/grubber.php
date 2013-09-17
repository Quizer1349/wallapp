<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Config data for grubber
 */

/**
 * Wallbase data
 */

$config['wallbase']['links_regex']		            = '//*[@class="thumb"]/a["href"]';
$config['wallbase']['image_regex']		            = '//div[@id="bigwall"]/img["src"]';
$config['wallbase']['filename_string']			    = '/wallpaper/';
$config['wallbase']['name']		                    = 'wallbase';
$config['wallbase']['url']                          = 'http://wallbase.cc/toplist/';
$config['wallbase']['login_url']                    = 'http://wallbase.cc/user/login';
$config['wallbase']['login_post_url']               = 'http://wallbase.cc/user/do_login';
$config['wallbase']['username']                     = 'quizer';
$config['wallbase']['password']                     = 'sklyarenko';
$config['wallbase']['is_protected_form']            = true;
$config['wallbase']['protected_field_name']         = 'csrf';



/* End of file grubber.php */
/* Location: ./application/config/grubber.php */