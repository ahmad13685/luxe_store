/**
 * Keeps <img data-product-id="..."> elements on the storefront in sync with
 * whatever an admin just changed in Filament, without the customer having
 * to refresh the page.
 *
 * How it works:
 *  - Every product <img> that should stay live is rendered with
 *    data-product-id="{id}" and data-image-version="{updated_at timestamp}".
 *  - Every POLL_INTERVAL ms, this script asks
 *    /api/products/image-status?ids=1,2,3 for the current image_url +
 *    version of every product id currently on the page.
 *  - If a product's version changed, its <img src> is swapped — the new
 *    URL already carries its own ?v= cache-busting query string from the
 *    server, so the browser is guaranteed to fetch the new file instead of
 *    serving a stale cached copy.
 *
 * No websockets/Pusher: plain polling keeps this portable and easy to
 * deploy on any ordinary PHP + MySQL host.
 */
(function () {
    var POLL_INTERVAL = 20000; // 20s

    function collectIds() {
        var ids = {};
        document.querySelectorAll('img[data-product-id]').forEach(function (img) {
            ids[img.getAttribute('data-product-id')] = true;
        });
        return Object.keys(ids);
    }

    function applyUpdate(id, info) {
        if (!info || !info.image_url) {
            return;
        }

        document.querySelectorAll('img[data-product-id="' + id + '"]').forEach(function (img) {
            var currentVersion = img.getAttribute('data-image-version') || '';

            if (String(info.version || '') !== currentVersion) {
                img.src = info.image_url;
                img.setAttribute('data-image-version', info.version || '');
            }
        });
    }

    function poll() {
        var ids = collectIds();

        if (!ids.length) {
            return;
        }

        fetch('/api/products/image-status?ids=' + ids.join(','), {
            headers: { Accept: 'application/json' },
        })
            .then(function (res) {
                return res.ok ? res.json() : null;
            })
            .then(function (data) {
                if (!data) {
                    return;
                }

                Object.keys(data).forEach(function (id) {
                    applyUpdate(id, data[id]);
                });
            })
            .catch(function () {
                // Silently ignore — a missed poll just means we try again
                // on the next interval. Never break the page over this.
            });
    }

    if (document.querySelector('img[data-product-id]')) {
        setInterval(poll, POLL_INTERVAL);
    }
})();
