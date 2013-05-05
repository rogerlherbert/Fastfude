<?xml version="1.0" encoding="utf-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">
	<title><?php echo $feed['title']; ?> | Fastfude</title>
	<subtitle>Discussion, banter and dissent from Northern Ireland's music scene.</subtitle>
	<link rel="alternate" type="text/html" href="<?php echo site_url('topics/tagged/'.$feed['tag']); ?>" />
	<link rel="self" type="application/atom+xml" href="<?php echo site_url('topics/feed/'.$feed['tag']); ?>" />
	<id>http://fastfude.org/topics/feed/<?php echo $feed['tag']; ?></id>
	<updated><?php echo $feed['lastmod']; ?></updated>
	<rights>Copyright © 1997, Roger Herbert</rights>
	<category term="<?php echo $feed['category']; ?>" />
	<?php if ($entries) { ?>
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
	<?php } ?>
</feed>