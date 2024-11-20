const addResourcesToCache = async (resources) => {
    const cache = await caches.open("v1");
    await cache.addAll(resources);
};

self.addEventListener("install", (event) => {
    event.waitUntil(
        addResourcesToCache([
            "/",
            "/index.php",
            "/app.js",
            "/sw.js",
            "/manifest.json",
            "/favicon.ico",
            "apple-touch-icon.png",
            "favicon.ico",
            "favicon.svg",
            "favicon-96x96.png",
            "icon_citation.png",
            "site.webmanifest",
            "web-app-manifest-192x192.png",
            "web-app-manifest-512x512.png",
        ]),
    );
});