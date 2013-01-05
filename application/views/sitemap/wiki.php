<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($wiki as $page) { ?>
<?php echo "\t<url><loc>".site_url('wiki/page/'.$page->stub)."</loc><lastmod>".$page->lastmod."</lastmod></url>"; ?>

<?php } ?>
</urlset>