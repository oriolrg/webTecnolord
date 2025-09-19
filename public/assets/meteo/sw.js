// /meteo/sw.js
self.addEventListener('install', (event) => {
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(clients.claim());
});

// Un fetch handler senzill perquè Chrome consideri la PWA instal·lable
self.addEventListener('fetch', () => {
  // No cal fer res especial; només existència del handler
});

