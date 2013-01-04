<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($sitemaps as $sitemap) { ?>
<?php echo "\t<sitemap><loc>".site_url('sitemap/year/'.$sitemap->loc)."</loc></sitemap>"; ?>

<?php } ?>
</sitemapindex>