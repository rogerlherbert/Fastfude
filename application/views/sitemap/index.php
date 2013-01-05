<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<sitemap><loc><?php echo site_url('sitemap/wiki'); ?></loc></sitemap>
<?php foreach ($sitemaps as $sitemap) { ?>
<?php echo "\t<sitemap><loc>".site_url('sitemap/topics/'.$sitemap->loc)."</loc></sitemap>"; ?>

<?php } ?>
</sitemapindex>