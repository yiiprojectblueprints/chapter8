<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<?php foreach ($content as $v): ?>
		<url>
			<loc><?php echo $url .'/'. htmlspecialchars(str_replace('/', '', $v['slug']), ENT_QUOTES, "utf-8"); ?></loc>
			<lastmod><?php echo date('c', strtotime($v['updated']));?></lastmod>
			<changefreq>weekly</changefreq>
			<priority>1</priority>
		</url>
	<?php endforeach; ?>
	<?php foreach ($categories as $v): ?>
		<url>
			<loc><?php echo $url .'/'. htmlspecialchars(str_replace('/', '', $v['slug']), ENT_QUOTES, "utf-8"); ?></loc>
			<lastmod><?php echo date('c', strtotime($v['updated']));?></lastmod>
			<changefreq>weekly</changefreq>
			<priority>0.7</priority>
		</url>
	<?php endforeach; ?>
</urlset>