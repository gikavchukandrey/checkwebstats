{
  "manifest_version": 2,

  "name": "<?php echo config_item("chrome_name_plugin"); ?>",
  "short_name": "<?php echo config_item("chrome_sname_plugin"); ?>",
  "description": "<?php echo config_item("chrome_description"); ?>",
  "version": "<?php echo config_item("chrome_version"); ?>",

  "browser_action": {
    "default_icon": "icon.png",
    "default_popup": "popup.html"
  },
  "permissions": [
    "activeTab","webNavigation","tabs"
  ],
  "icons": {
    "16": "icon.png",
    "48": "icon48.png",
    "128": "icon128.png"
  },
  "background":
  {
    "scripts":["jquery.min.js","app.js","background.js"]
  }
}
