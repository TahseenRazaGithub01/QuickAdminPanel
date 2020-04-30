var cachename = 'v1hddwwhd';
var CURRENT_CACHES = {
  prefetch: 'prefetch-cache-v' + cachename
};

self.addEventListener('install', function(event) {
  //console.log('Service Worker Install...');
  // pre cache a load of stuff:
  event.waitUntil(
    caches.open(CURRENT_CACHES.prefetch)
      .then(function(cache) {
      return cache.addAll([
        '/',
        '/build/js/all.js',
        '/build/css/main.css',
        '/sw.js'
      ])
      .then(function(){
        //console.log('Caches added');
      })
      .catch(function(error){
        console.error('Error on installing');
        console.error(error);
      });
    })
  )
});
self.addEventListener('fetch', function(event) {
// check if request is made by chrome extensions or web page
  // if request is made for web page url must contains http.
  if (!(event.request.url.indexOf('http') === 0)) return; // skip the request. if request is not made with http protocol
       if ( event.request.url.match( '^.*(\/admin\/).*$' ) ) {
  console.log('Service Worker Fetch...');
           console.log('admin1');
        return false;
    }
           if ( event.request.url.match( '^.*(\/admin).*$' ) ) {
  console.log('Service Worker Fetch...');
           console.log('admin1');
        return false;
    }
     // OR
    if ( event.request.url.indexOf( '/admin/' ) !== -1 ) {
        console.log('adminss1');
        return false;
    }
  event.respondWith(
    caches.match(event.request)
      .then(function(response) {
        if(response){
          //console.log('Serve from cache', response);
          return response;
        }
        return fetch(event.request)
            .then(response =>
              caches.open(CURRENT_CACHES.prefetch)
                .then((cache) => {
                  // cache response after making a request
                  cache.put(event.request, response.clone());
                // check cached items size
              limitCacheSize(CURRENT_CACHES.prefetch, 15);
                  // return original response
                  return response;
                })
            )
          
      }))});

self.addEventListener('activate', function(event) {
 // console.log('Service Worker Activate...');
  // Delete all caches that aren't named in CURRENT_CACHES.
  var expectedCacheNames = Object.keys(CURRENT_CACHES).map(function(key) {
    return CURRENT_CACHES[key];
  });

  event.waitUntil(
    caches.keys().then(function(cacheNames) {
      return Promise.all(
        cacheNames.map(function(cacheName) {
          if (expectedCacheNames.indexOf(cacheName) === -1) {
            // If this cache name isn't present in the array of "expected" cache names, then delete it.
           // console.log('Deleting out of date cache:', cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});
// cache size limit function
const limitCacheSize = (name, size) => {
  caches.open(name).then(cache => {
    cache.keys().then(keys => {
      if (keys.length > size) {
        cache.delete(keys[0]).then(limitCacheSize(name, size));
      }
    });
  });
};