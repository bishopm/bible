var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    '/',
    '/offline',
    '/bible/images/icons/icon-72x72.png',
    '/bible/images/icons/icon-96x96.png',
    '/bible/images/icons/icon-128x128.png',
    '/bible/images/icons/icon-144x144.png',
    '/bible/images/icons/icon-152x152.png',
    '/bible/images/icons/icon-192x192.png',
    '/bible/images/icons/icon-384x384.png',
    '/bible/images/icons/icon-512x512.png',
    '/bible/images/aerial.png',
    '/bible/images/blacklogo.png',
    '/bible/images/blog.png',
    '/bible/images/bwidelogo.png',
    '/bible/images/calendar.png',
    '/bible/images/bible.png',
    '/bible/images/circle.png',
    '/bible/images/growslide.png',
    '/bible/images/knowslide.png',
    '/bible/images/showslide.png',
    '/bible/images/welcomeslide.png'
];

// Cache on install
self.addEventListener("install", event => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                cache.add('/').catch(error => {
                    console.error('Failed to cache root route:', error);
                });
                return cache.addAll(filesToCache);
            })
    )
});

// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("pwa-")))
                    .filter(cacheName => (cacheName !== staticCacheName))
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener('fetch', (event) => {
    event.respondWith(caches.open(staticCacheName).then((cache) => {
      return cache.match(event.request).then((cachedResponse) => {
          const fetchedResponse = fetch(event.request).then((networkResponse) => {
              cache.put(event.request, networkResponse.clone());
      
              return networkResponse;
          });
      
          return cachedResponse || fetchedResponse;
        });
    }));
});