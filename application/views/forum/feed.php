<?xml version="1.0" encoding="utf-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">
	<title><?php echo $feed['title']; ?> | Fastfude</title>
	<subtitle>Discussion, banter and dissent from Northern Ireland's music scene.</subtitle>
	<link rel="alternate" type="text/html" href="<?php echo site_url('forum/id/'.$feed['forum_id']); ?>" />
	<link rel="self" type="application/atom+xml" href="<?php echo site_url('forum/feed/'.$feed['forum_id']); ?>" />
	<id>http://fastfude.org/forum/feed/<?php echo $feed['forum_id']; ?></id>
	<updated><?php echo $feed['lastmod']; ?></updated>
	<rights>Copyright © 2013, John Gruber</rights>
	<category term="<?php echo $feed['category']; ?>" />
	<?php foreach($entries as $entry) { ?>
	<entry>
		<title><?php echo $entry->title; ?></title>
		<link rel="alternate" type="text/html" href="<?php echo site_url('topic/id/'.$entry->id); ?>" />
		<id><?php echo site_url('topic/id/'.$entry->id); ?></id>
		<published><?php echo $entry->post_time; ?></published>
		<updated><?php echo ($entry->post_edit_time != '') ? $entry->post_edit_time : $entry->post_time; ?></updated>
		<author>
			<name><?php echo $entry->username; ?></name>
			<uri><?php echo site_url('user/id/'.$entry->user_id); ?></uri>
		</author>
		<content type="html" xml:base="http://fastfude.org/" xml:lang="en">
			<![CDATA[<?php echo nl2br(html_escape($entry->post_text)); ?>]]>
		</content>
	</entry>
	<?php } ?>
</feed>