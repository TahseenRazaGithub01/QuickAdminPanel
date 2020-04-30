var SLOW_TIME = 3000;
var cachename = 'v1';
var cacheFiles = [
    '/',
    '/build/css/main.css',
    '/all.js'
]

this.addEventListener( 'install', function (e) {
  console.log('Installed service worker');
    e.waitUntil(
    caches.open(cachename).then(function(cache){
        console.log("[serviceWorker]");
        return cache.addAll(cacheFiles);
    })
    )
} );
//this.addEventListener( 'activate', function (e) {
//  console.log('activated service worker');
//    e.waitUntil(
//    caches.keys().then(function(cachename){
//       // console.log("[serviceWorker]");
//        return Promise.all(cachename.map(function(thisCacheName){
//            if(thisCacheName !== cachename){
//                console.log("[service worker]",thisCacheName);
//                return caches.delete(thisCacheName);
//            }
//        }));
//    })
//    )
//} );

this.addEventListener( 'fetch', function(event) {
  var url = event.request.url;
    event.respondWith(
    caches.match(event.request).then(function(response){
        alert('ss');
        if(response){
            console.log('already cache',url);
            return response;
        }
        return fetch(event.request);
    })
    )

  if ( url.indexOf( 'blocking' ) === -1) {
  return;
  }

  var promise = Promise.race( [
    new Promise( ( resolve, reject) => setTimeout(
      () => reject( new Response( 'Request killed!' ) ),
      SLOW_TIME
    ) ),
    fetch( event.request ),
  ] );

  event.respondWith( promise );
} );