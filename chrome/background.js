chrome.tabs.onUpdated.addListener(function(tabId, changeInfo, tab) {
    getScore(tab);
});

chrome.tabs.onCreated.addListener(function(tab) {
   getScore(tab);
});

/*
chrome.tabs.onActivated.addListener(function(activeInfo) {
   chrome.tabs.getSelected(null,function(tab) {
      getScore(tab);
   });
});
*/
