<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Install extends CI_Controller
{
	private $schema;

	function __construct()
	{
		parent::__construct();
		
		if (ENVIRONMENT != 'development')
		{
			show_error('For use in development environments only.');
		}
		
		$this->output->enable_profiler(TRUE);
		
		$this->schema = array(
			'ci_sessions' => "`session_id` varchar(40) NOT NULL DEFAULT '0', `ip_address` varchar(45) NOT NULL DEFAULT '0', `user_agent` varchar(120) NOT NULL, `last_activity` int(10) unsigned NOT NULL DEFAULT '0', `user_data` text NOT NULL, PRIMARY KEY (`session_id`), KEY `last_activity_idx` (`last_activity`)",
			'gigs' => "`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT, `topic_id` mediumint(8) unsigned DEFAULT NULL, `start_time` datetime DEFAULT NULL, `gig_title` varchar(255) DEFAULT NULL, `location` varchar(255) DEFAULT NULL, `reference_token` varchar(255) DEFAULT NULL, `lineup` text, PRIMARY KEY (`id`), KEY `topic_id` (`topic_id`)",
			'messages' => "`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT, `post_text` text NOT NULL, `post_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, `from_id` int(10) unsigned NOT NULL DEFAULT '0', `to_id` int(10) unsigned NOT NULL DEFAULT '0', `bin_state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 = none, 1 = sender binned, 2 = receiver binned, 3 = both binned', `is_read` tinyint(1) NOT NULL DEFAULT '0', PRIMARY KEY (`id`), KEY `from_id` (`from_id`,`to_id`), KEY `bin_state` (`bin_state`)",
			'posts' => "`id` int(10) unsigned NOT NULL AUTO_INCREMENT, `topic_id` mediumint(8) unsigned NOT NULL, `user_id` int(10) unsigned NOT NULL, `user_ip` int(10) unsigned DEFAULT NULL, `post_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, `edit_time` datetime DEFAULT NULL, `post_text` text NOT NULL, PRIMARY KEY (`id`), KEY `topic_id` (`topic_id`), KEY `user_id` (`user_id`)",
			'topics' => "`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT, `forum_id` tinyint(3) unsigned NOT NULL, `title` varchar(64) NOT NULL, `is_locked` tinyint(1) unsigned NOT NULL DEFAULT '0', `replies` int(10) unsigned NOT NULL DEFAULT '0', `post_id_first` int(10) unsigned NOT NULL DEFAULT '0', `post_time_first` datetime NOT NULL, `user_id_first` int(10) unsigned NOT NULL DEFAULT '0', `post_id_last` int(10) unsigned NOT NULL DEFAULT '0', `post_time_last` datetime NOT NULL, `user_id_last` int(10) unsigned NOT NULL DEFAULT '0', PRIMARY KEY (`id`), KEY `forum_id` (`forum_id`), KEY `post_id_first` (`post_id_first`), KEY `user_id_first` (`user_id_first`), KEY `post_time_first` (`post_time_first`)",
			'users' => "`id` int(10) unsigned NOT NULL AUTO_INCREMENT, `username` varchar(255) NOT NULL DEFAULT '', `password` varchar(255) NOT NULL DEFAULT '', `email` varchar(255) NOT NULL DEFAULT '', `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`), UNIQUE KEY `username` (`username`)",
			'users_actions' => "`id` int(10) unsigned NOT NULL AUTO_INCREMENT, `user_id` int(10) unsigned DEFAULT NULL, `action` varchar(32) DEFAULT NULL, `object_id` int(10) unsigned DEFAULT NULL, `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`), UNIQUE KEY `user_id` (`user_id`,`action`,`object_id`)",
			'users_forgot_pw' => "`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `user_id` int(10) unsigned DEFAULT NULL, `key` varchar(64) DEFAULT NULL, `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`), UNIQUE KEY `key` (`key`)",
			'users_muted' => "`user_id` int(10) unsigned NOT NULL, `muted_user_id` int(10) unsigned NOT NULL, PRIMARY KEY (`user_id`,`muted_user_id`)",
			'users_pending' => "`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `email` varchar(255) NOT NULL DEFAULT '', `auth_key` varchar(255) NOT NULL DEFAULT '', `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`), KEY `auth_key` (`auth_key`)",
			'users_settings' => "`id` int(10) unsigned NOT NULL AUTO_INCREMENT, `user_id` int(10) unsigned NOT NULL DEFAULT '0', `key` varchar(32) NOT NULL DEFAULT '', `value` varchar(255) DEFAULT NULL, PRIMARY KEY (`id`), KEY `user_id` (`user_id`,`key`)",
			'wiki_history' => "`id` int(10) unsigned NOT NULL AUTO_INCREMENT, `page_id` int(10) unsigned NOT NULL, `user_id` int(10) unsigned NOT NULL, `page_text` text, `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`), KEY `page_id` (`page_id`)",
			'wiki_pages' => "`id` int(10) unsigned NOT NULL AUTO_INCREMENT, `stub` varchar(255) NOT NULL DEFAULT '', `title` varchar(255) NOT NULL DEFAULT '', PRIMARY KEY (`id`), UNIQUE KEY `stub` (`stub`)"
		);
	}
	
	public function index()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('submit', 'Install', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('install/index');
		}
		else
		{
			foreach ($this->schema as $table => $sql) {
				$drop_str = "DROP TABLE IF EXISTS `".$table."`;\n";
				$table_str = "CREATE TABLE `".$table."` (". $sql .") ENGINE=InnoDB DEFAULT CHARSET=utf8;\n\n";

				$this->db->query($drop_str);
				$this->db->query($table_str);
			}

			redirect('/');
		}
	}
}

/* End of file install.php */
/* Location: ./application/controllers/install.php */