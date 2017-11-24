<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'  ?>

<!-- NOTE: Use the url <?php echo base_url(); ?>sitemap.xml to send sitemap to search engine -->
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
   <url>
         <loc><?php echo base_url(); ?></loc>          
         <changefreq>daily</changefreq>      
      </url>
  <!-- Sites <?php echo number_format($sites->num_rows()); ?> -->
   <?php foreach ($sites->result() as $row) {
      ?>
      <url>
         <loc><?php echo base_url(); ?><?php echo (str_ireplace(array("http://","https://"), "",$row->url)); ?></loc>          
         <changefreq>monthly</changefreq>      
      </url>
      <?php
   }
   ?>
   <!-- Pages -->
<?php foreach ($pages->result() as $row) {
      ?>
      <url>
         <loc><?php echo base_url(); ?><?php echo config_item("slug_pages"); ?>/<?php echo urlencode($row->slug); ?></loc>          
         <changefreq>monthly</changefreq>      
      </url>
      <?php
   }
   ?>
</urlset> 
