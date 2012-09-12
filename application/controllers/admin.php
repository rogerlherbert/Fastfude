<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Admin extends CI_Controller
{
	private $users = array(
		array('username' => 'roger', 'password' => 'password', 'email' => 'admin@fastfude.org'),
		array('username' => 'annoyingly long-named user who trolls the layout restrictions, the bastard', 'password' => 'password', 'email' => 'loltroll@fastfude.org'),
		array('username' => 'Iñtërnâtiônàlizætiøn', 'password' => 'password', 'email' => 'utf8@fastfude.org'),
		array('username' => '<blink style="font-size: 400%; color: #f00;">ARSEHOLE</blink>', 'password' => 'password', 'email' => 'arsehole@fastfude.org'),
		array('username' => 'Robert\'); DROP TABLE users;', 'password' => 'password', 'email' => 'littlebobbytables@fastfude.org'),
	);
	
	private $topics = array(
		array('forum_id' => '1', 'title' => 'test', 'user_id' => '1', 'post_text' => 'this is a test'),
		array('forum_id' => '1', 'title' => 'Happy Birthday...(Sep.)', 'user_id' => '2', 'post_text' => '"Laurindo Almeida (2 September, 1917 - 26 July, 1995) was a Brazilian virtuoso guitarist and composer who made many recordings of enduring impact in classical, jazz and Latin genres. He is widely credited, with fellow artist Bud Shank, for creating the fusion of Latin and jazz which came to be known as [i]Jazz Samba[/i]."

- [i]Wikipedia[/i]

[img]http://img1.liveinternet.ru/images/attach/c/0//48/251/48251758_Laurindo_Almeida.gif[/img]

http://www.youtube.com/watch?v=W-9OrHd6QdM'),
		array('forum_id' => '1', 'title' => 'Guitarists for Codemaking', 'user_id' => '3', 'post_text' => 'Hi,

 Burning Codes (solo collaborative project of Belfast born singer/songwriter Paul Archer) still looking for guitar players, (also keys, brass and strings). Paul sang on Snow Patrol\'s multi-platinum album Eyes Open and has just recently returned from singing with Snow Patrol at both their V Festival appearances.

 Burning Codes has received BBC Radio One Evening Session, BBC6 Music and BBC Radio Ulster and Cambridgeshire airplay as well as stations in Europe and U.S.

 Any interested musicians please contact Paul Archer:

Email: pcarcheruk@yahoo.com

Thanks,

Paul Archer'),
		array('forum_id' => '1', 'title' => 'Marc Leach Photography', 'user_id' => '4', 'post_text' => 'Hey folks!

The name is Marc Leach and I am a music photographer from Lisburn! If there are any bands out there who need a photographer for a promo or to capture their performance at a concert, I\'m your man!

Many groups have been in front of my lens, from local groups such as:
Bandwagon
Last Known Addiction
Black Freeway
Exit
Redlight
Crave
PAY*OLA
and more!

Also a number of big name acts such as
Pat McManus (ex Mamas Boys)
Ricky Warwick (Thin Lizzy & ex The Almighty)
Glyder
The Undertones
G.M.T. (Guy, Mccoy & Terme)
and others.

Here are some samples:

Here are some samples:
[img]http://c1.ac-images.myspacecdn.com/images02/152/l_10bec8f434914f44a9c702dfd18e7b58.jpg[/img]
Phil Edgar - Bandwagon

[img]http://media.tumblr.com/tumblr_lemocgqUKV1qeb1lc.jpg[/img]
Eric Bell - ex Thin Lizzy

[img]http://c1.ac-images.myspacecdn.com/images02/148/l_9d0f132d0eff44e7b58be963da8b4608.jpg[/img]
Pat McManus - ex Mamas Boys

[img]http://sphotos.ak.fbcdn.net/hphotos-ak-snc3/hs386.snc3/23579_383424751244_311003386244_4380856_5782010_n.jpg[/img]
Ricky Warwick

[img]http://sphotos.ak.fbcdn.net/hphotos-ak-snc4/hs922.snc4/73567_443681186244_311003386244_5859915_1306737_n.jpg[/img]
Last Known Addiction

If you would like to see more of my work please visit;
Website: http://www.wix.com/ximperialx/marcleachphotography
Facebook: http://www.facebook.com/pages/Marc-Leach-Photography/311003386244

If you are intereted please drop me a bell.
I am looking forward to hearing from you!

Peace and blessings
Marc'),
	);
	
	private $extra_posts = array(
		array('topic_id' => '1', 'user_id' => '2', 'post_text' => 'Giga Training will be running an open day for music technology courses on Saturday 15th September. All workshops are free and places can be pre-booked online @ http://www.gigatraining.com/training/book-a-course.

We’ll be running 1hour workshops in Ableton Live Suite and Logic Pro, aimed at beginner level. The workshops will be a great opportunity to meet our trainers and get a taster of what our music technology courses are all about! Places are limited so please book early to avoid disappointment.

If you have any queries you can contact the office on 02895 811202 or via email info@gigatraining.com'),
		array('topic_id' => '1', 'user_id' => '3', 'post_text' => '[img]http://25.media.tumblr.com/tumblr_m99qruiE9S1rcl5ajo1_1280.jpg[/img]

COLLIDER NO.2 
PRESENTING 

GIRL BAND (DUBLIN)

[url=http://www.youtube.com/watch?v=axMrhFGj4uo]GIRL BAND IN MY HEAD[/url]
[url=http://www.youtube.com/watch?v=nWMQQLNhMLA]GIRL BAND CONDUCTOR[/url]
[url=http://www.youtube.com/watch?v=aK75RkcIPEs]GIRL BAND TWELVES[/url]

THE PENNY DREADFULS (BELFAST)
[url=http://www.youtube.com/watch?v=3g-MJbyUU_I]THE PENNY DREADFULS ZOMBIE LOVIN[/url]

& GUESTS TBA.

+ DJ\'S
SARGE & DOM SMALL.

VOODOO BELFAST
19TH SEPTEMBER 
£5

http://www.facebook.com/events/461861937177978/'),
		array('topic_id' => '1', 'user_id' => '1', 'post_text' => 'BUMP.'),
		array('topic_id' => '2', 'user_id' => '1', 'post_text' => '[quote]on the issue of studio "trickery", this has been wide spread since The Beatles etc experimented with multitracking[/quote]

Yeah, and that\'s cool. I do appreciate creative and imaginative studio wizardry. Though it\'s a whole different culture in the suit-driven, digitally produced pop music of today in comparison to the musician-led, analog experiments of yesteryear.

[quote][i]All[/i] of our favourite records have been manipulated in the studio to produce a great finished record[/quote]

Hmm, dunno about that one. Out of my top 100 albums I\'d say there\'s very little, if any. Mind you, my top 100 might not be typical of ff.

[quote]I think it\'s okay to comp vocal and drum takes, use beat detective or quantize - on the proviso that the band sound awesome when they play shows[/quote]

Aye, in most popular styles I can live with that, though in the likes of classical and jazz that just doesn\'t cut it.

[quote]I suppose it comes down to having a great band and using the tools to make a perfect recording, rather than a "pop tart" and using the tools to make them listenable?[/quote]

Yeah, that\'s it. \'Tis worth a discussion, apart from this hackneyed bollocks.

*cue new thread*'),
		array('topic_id' => '2', 'user_id' => '2', 'post_text' => 'who are you telling to fuck up im not talking about myself im talking about how fking warped the current music scene is although its actually a little better now your shite band has ceasesd so ps you fuck up colenso parade where the same yous supported the view in the mandella hall because you,s knew the right people end of..ya banger'),
		array('topic_id' => '3', 'user_id' => '4', 'post_text' => 'x'),
	);

	function __construct() 
	{
		parent::__construct();
	
		$this->output->enable_profiler(TRUE);
	}
	
	public function index()
	{
		$this->load->view('admin/index');
	}

	public function reset()
	{

		$this->db->query("DROP TABLE IF EXISTS `ci_sessions`;");
		$this->db->query("CREATE TABLE `ci_sessions` (
		  `session_id` varchar(40) NOT NULL DEFAULT '0',
		  `ip_address` varchar(45) NOT NULL DEFAULT '0',
		  `user_agent` varchar(120) NOT NULL,
		  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
		  `user_data` text NOT NULL,
		  PRIMARY KEY (`session_id`),
		  KEY `last_activity_idx` (`last_activity`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");


		$this->db->query("DROP TABLE IF EXISTS `posts`;");
		$this->db->query("CREATE TABLE `posts` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `topic_id` mediumint(8) unsigned NOT NULL,
		  `user_id` int(10) unsigned NOT NULL,
		  `user_ip` int(10) unsigned DEFAULT NULL,
		  `post_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `edit_time` datetime DEFAULT NULL,
		  `post_text` text NOT NULL,
		  PRIMARY KEY (`id`),
		  KEY `topic_id` (`topic_id`),
		  KEY `user_id` (`user_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");


		$this->db->query("DROP TABLE IF EXISTS `topics`;");
		$this->db->query("CREATE TABLE `topics` (
		  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
		  `forum_id` tinyint(3) unsigned NOT NULL,
		  `title` varchar(64) NOT NULL,
		  `is_locked` tinyint(1) unsigned NOT NULL DEFAULT '0',
		  `replies` int(10) unsigned NOT NULL DEFAULT '0',
		  `post_id_first` int(10) unsigned NOT NULL DEFAULT '0',
		  `post_time_first` datetime NOT NULL,
		  `user_id_first` int(10) unsigned NOT NULL DEFAULT '0',
		  `post_id_last` int(10) unsigned NOT NULL DEFAULT '0',
		  `post_time_last` datetime NOT NULL,
		  `user_id_last` int(10) unsigned NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`),
		  KEY `forum_id` (`forum_id`),
		  KEY `post_id_first` (`post_id_first`),
		  KEY `user_id_first` (`user_id_first`),
		  KEY `post_time_first` (`post_time_first`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");


		$this->db->query("DROP TABLE IF EXISTS `users`;");
		$this->db->query("CREATE TABLE `users` (
		  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `username` varchar(255) NOT NULL DEFAULT '',
		  `password` varchar(255) NOT NULL DEFAULT '',
		  `email` varchar(255) NOT NULL DEFAULT '',
		  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `username` (`username`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");


		$this->db->query("DROP TABLE IF EXISTS `users_pending`;");
		$this->db->query("CREATE TABLE `users_pending` (
		  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `email` varchar(255) NOT NULL DEFAULT '',
		  `auth_key` varchar(255) NOT NULL DEFAULT '',
		  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`),
		  KEY `auth_key` (`auth_key`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");


		$this->db->query("DROP TABLE IF EXISTS `users_muted`;");
		$this->db->query("CREATE TABLE `users_muted` (
		 `user_id` int(10) unsigned NOT NULL,
		 `muted_user_id` int(10) unsigned NOT NULL,
		 PRIMARY KEY (`user_id`,`muted_user_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");


		$this->db->query("DROP TABLE IF EXISTS `users_forgot_pw`;");
		$this->db->query("CREATE TABLE `users_forgot_pw` (
		 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		 `user_id` int(11) unsigned DEFAULT NULL,
		 `key` varchar(64) DEFAULT NULL,
		 `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
		 PRIMARY KEY (`id`),
		 UNIQUE KEY `key` (`key`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		
		
		$this->load->model('User_model');

		foreach ($this->users as $user) {
			$this->User_model->createUser($user);
		}


		$this->load->model('Topic_model');
		
		foreach ($this->topics as $topic) {
			$this->Topic_model->addTopic($topic['forum_id'], $topic['user_id'], $topic['title'], $topic['post_text']);
		}
		
		foreach ($this->extra_posts as $post) {
			$this->Topic_model->addPost($post['topic_id'], $post['user_id'], $post['post_text']);
		}
	}
}