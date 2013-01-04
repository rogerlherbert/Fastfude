<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($topics as $topic) { ?>
<?php echo "\t<url><loc>".site_url('topic/id/'.$topic->id)."</loc><lastmod>".$topic->lastmod."</lastmod></url>"; ?>

<?php } ?>
</urlset>