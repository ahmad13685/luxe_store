/* =========================================================
   LUXE STORE - MAIN JAVASCRIPT
   Plain vanilla JS. No frameworks. Organized by feature
   with comments so it's easy to follow.
   ========================================================= */

document.addEventListener("DOMContentLoaded", function () {

  /* ---------------------------------------------------------
     1. DARK / LIGHT MODE TOGGLE (saved in localStorage)
     --------------------------------------------------------- */
  const themeToggleButtons = document.querySelectorAll(".theme-toggle-btn");
  const htmlEl = document.documentElement;

  // Load saved theme on page load
  const savedTheme = localStorage.getItem("luxe-theme");
  if (savedTheme === "dark") {
    htmlEl.setAttribute("data-theme", "dark");
    updateThemeIcons("dark");
  }

  function updateThemeIcons(theme) {
    themeToggleButtons.forEach(function (btn) {
      const icon = btn.querySelector("i");
      if (!icon) return;
      if (theme === "dark") {
        icon.classList.remove("bi-moon-stars");
        icon.classList.add("bi-sun");
      } else {
        icon.classList.remove("bi-sun");
        icon.classList.add("bi-moon-stars");
      }
    });
  }

  themeToggleButtons.forEach(function (btn) {
    btn.addEventListener("click", function () {
      const isDark = htmlEl.getAttribute("data-theme") === "dark";
      if (isDark) {
        htmlEl.removeAttribute("data-theme");
        localStorage.setItem("luxe-theme", "light");
        updateThemeIcons("light");
      } else {
        htmlEl.setAttribute("data-theme", "dark");
        localStorage.setItem("luxe-theme", "dark");
        updateThemeIcons("dark");
      }
    });
  });

  /* ---------------------------------------------------------
     2. HOME HERO
     The current Home page uses the static .hero-new section.
     Do not run the old rotating-hero code here; it expected
     #heroProductImage / .hero-slide-data, which are not part
     of the current Home markup.
     --------------------------------------------------------- */

  /* ---------------------------------------------------------
     3. SHOPPING CART (real data, shared across every page)
     Cart is an array of objects saved in localStorage:
     { id, name, brand, price, image, qty }
     Every page that includes this file gets the same cart,
     the same badge count, and (if the markup is present) the
     same working mini-cart sidebar.
     --------------------------------------------------------- */
  const CART_KEY = "luxe-cart";

  function getCart() {
    try {
      return JSON.parse(localStorage.getItem(CART_KEY)) || [];
    } catch (e) {
      return [];
    }
  }

  function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
  }

  // Reads product info straight from the card in the DOM so we don't
  // have to add extra data-attributes to every single product card.
  function readProductFromCard(card) {
    if (!card) return null;
    const nameEl = card.querySelector(".product-name");
    const priceEl = card.querySelector(".product-price");
    const catEl = card.querySelector(".product-category");
    const imgEl = card.querySelector(".product-img-wrap img");

    let priceText = "0";
    if (priceEl) {
      priceText = priceEl.childNodes[0] ? priceEl.childNodes[0].textContent : priceEl.textContent;
    }
    const price = parseFloat(priceText.replace(/[^0-9.]/g, "")) || 0;
    const name = nameEl ? nameEl.textContent.trim() : "Product";

    return {
      id: name + "-" + price,
      name: name,
      brand: catEl ? catEl.textContent.trim() : "Luxe",
      price: price,
      image: imgEl ? imgEl.getAttribute("src") : "pic/1.webp",
      qty: 1
    };
  }

  // Reads the main product being viewed on product-details.html
  function readProductDetailsPage() {
    const nameEl = document.querySelector(".pd-info h1");
    const priceEl = document.querySelector(".pd-price-row .price");
    const brandEl = document.querySelector(".pd-brand strong");
    const imgEl = document.getElementById("pdMainImage");
    const qtyInput = document.getElementById("qtyInput");

    if (!nameEl) return null;

    const price = priceEl ? parseFloat(priceEl.textContent.replace(/[^0-9.]/g, "")) : 0;
    const name = nameEl.textContent.trim();

    return {
      id: name + "-" + price,
      name: name,
      brand: brandEl ? brandEl.textContent.trim() : "Luxe",
      price: price,
      image: imgEl ? imgEl.getAttribute("src") : "pic/1.webp",
      qty: qtyInput ? (parseInt(qtyInput.value, 10) || 1) : 1
    };
  }

  function addToCart(product, qtyOverride) {
    if (!product) return;
    const cart = getCart();
    const existing = cart.find(function (item) { return item.id === product.id; });
    if (existing) {
      existing.qty += qtyOverride || product.qty || 1;
    } else {
      product.qty = qtyOverride || product.qty || 1;
      cart.push(product);
    }
    saveCart(cart);
    renderCartBadge();
    renderMiniCart();
  }

  function updateQty(id, delta) {
    const cart = getCart();
    const item = cart.find(function (i) { return i.id === id; });
    if (!item) return;
    item.qty += delta;
    if (item.qty < 1) item.qty = 1;
    saveCart(cart);
    renderCartBadge();
    renderMiniCart();
  }

  function removeFromCart(id) {
    let cart = getCart();
    cart = cart.filter(function (i) { return i.id !== id; });
    saveCart(cart);
    renderCartBadge();
    renderMiniCart();
  }

  // Sends the current localStorage cart to the server (stores it in
  // the PHP session under "cart") and then sends the browser to the
  // real checkout page. Used by both "Proceed to Checkout" (cart page)
  // and "Buy Now" (product cards / product-details page) so there is
  // only one place this logic needs to be correct.
  function syncCartAndGoToCheckout() {
    const cart = getCart();

    if (cart.length === 0) {
      window.location.href = "/shop";
      return;
    }

    const tokenEl = document.querySelector('meta[name="csrf-token"]');
    const token = tokenEl ? tokenEl.getAttribute("content") : "";

    fetch("/cart/sync", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": token,
        "Accept": "application/json",
      },
      body: JSON.stringify({ cart: cart }),
    })
      .then(function (res) {
        if (!res.ok) throw new Error("Sync failed");
        return res.json();
      })
      .then(function () {
        window.location.href = "/customer/checkout";
      })
      .catch(function () {
        alert("Something went wrong preparing your checkout. Please try again.");
      });
  }
  // Exposed on window so other inline scripts (e.g. the cart page's
  // "Proceed to Checkout" button) can call it - this function is
  // otherwise scoped inside this file's DOMContentLoaded closure.
  window.syncCartAndGoToCheckout = syncCartAndGoToCheckout;

  function cartTotals() {
    const cart = getCart();
    const subtotal = cart.reduce(function (sum, i) { return sum + (i.price * i.qty); }, 0);
    const shipping = cart.length === 0 ? 0 : (subtotal >= 80 ? 0 : 8);
    return { subtotal: subtotal, shipping: shipping, total: subtotal + shipping };
  }

  const cartCountEls = document.querySelectorAll(".cart-count:not(.wishlist-count)");

  function renderCartBadge() {
    const cart = getCart();
    const count = cart.reduce(function (sum, i) { return sum + i.qty; }, 0);
    cartCountEls.forEach(function (el) { el.textContent = count; });
  }
  renderCartBadge();

  function cartLineTemplate(item) {
    return `
    <div class="cart-line-item" data-id="${item.id}">
        <div class="cli-img">
            <img src="${item.image}" alt="${item.name}">
        </div>

        <div class="cli-info">
            <div class="cli-name">${item.name}</div>

            <span class="cli-brand">${item.brand}</span>

            <div class="cli-price">$${item.price.toFixed(2)}</div>

            <div class="cli-qty-row">

                <div class="cli-qty-box">
                    <button class="cli-qty-minus">−</button>

                    <span>${item.qty}</span>

                    <button class="cli-qty-plus">+</button>
                </div>

                <button class="cli-remove-btn">
                    <i class="bi bi-trash3"></i>
                </button>

            </div>

        </div>

    </div>
    `;
}

  // Renders the mini-cart sidebar AND the full cart page, since both
  // use the same container ids (#miniCartItems / #miniCartFooter etc).
  function renderMiniCart() {

    const wrap = document.getElementById("miniCartItems");
    const footer = document.getElementById("miniCartFooter");
    const emptyState = document.getElementById("miniCartEmpty");
    if (!wrap) return;

    const cart = getCart();

    if (cart.length === 0) {
      wrap.innerHTML = "";
      wrap.classList.add("d-none");
      if (footer) footer.classList.add("d-none");
      if (emptyState) emptyState.classList.remove("d-none");
    } else {
      wrap.classList.remove("d-none");
      if (footer) footer.classList.remove("d-none");
      if (emptyState) emptyState.classList.add("d-none");
      wrap.innerHTML = cart.map(cartLineTemplate).join("");
    }

    const totals = cartTotals();
    const subtotalEl = document.getElementById("miniCartSubtotal");
    const shippingEl = document.getElementById("miniCartShipping");
    const totalEl = document.getElementById("miniCartTotal");
    if (subtotalEl) subtotalEl.textContent = "$" + totals.subtotal.toFixed(2);
    if (shippingEl) shippingEl.textContent = totals.shipping === 0 ? "Free" : "$" + totals.shipping.toFixed(2);
    if (totalEl) totalEl.textContent = "$" + totals.total.toFixed(2);

    renderCartPage();
  }
  renderMiniCart();

  // Full cart page (cart.html) - separate containers, same cart data
  function cartPageRowTemplate(item) {
    const lineTotal = (item.price * item.qty).toFixed(2);
    return (
      '<div class="cart-page-row" data-id="' + item.id + '">' +
        '<div class="cpr-img"><img src="' + item.image + '" alt="' + item.name + '"></div>' +
        '<div class="cpr-info">' +
          '<div class="cpr-name">' + item.name + '</div>' +
          '<span class="cpr-brand">' + item.brand + '</span>' +
          '<div class="cpr-price">$' + item.price.toFixed(2) + '</div>' +
        '</div>' +
        '<div class="cli-qty-box">' +
          '<button type="button" class="cli-qty-minus">&minus;</button>' +
          '<span>' + item.qty + '</span>' +
          '<button type="button" class="cli-qty-plus">+</button>' +
        '</div>' +
        '<div class="cpr-subtotal">$' + lineTotal + '</div>' +
        '<button type="button" class="cpr-remove cli-remove-btn" title="Remove"><i class="bi bi-trash3"></i></button>' +
      '</div>'
    );
  }

  function renderCartPage() {
    const wrap = document.getElementById("cartPageRows");
    const emptyState = document.getElementById("cartPageEmpty");
    const filled = document.getElementById("cartPageFilled");
    if (!wrap) return;

    const cart = getCart();

    if (cart.length === 0) {
      if (filled) filled.classList.add("d-none");
      if (emptyState) emptyState.classList.remove("d-none");
      return;
    }
    if (filled) filled.classList.remove("d-none");
    if (emptyState) emptyState.classList.add("d-none");

    wrap.innerHTML = cart.map(cartPageRowTemplate).join("");

    const totals = cartTotals();
    const subtotalEl = document.getElementById("summarySubtotal");
    const shippingEl = document.getElementById("summaryShipping");
    const totalEl = document.getElementById("summaryTotal");
    const discountEl = document.getElementById("summaryDiscount");
    const discount = parseFloat(document.body.getAttribute("data-discount") || "0");

    if (subtotalEl) subtotalEl.textContent = "$" + totals.subtotal.toFixed(2);
    if (shippingEl) shippingEl.textContent = totals.shipping === 0 ? "Free" : "$" + totals.shipping.toFixed(2);
    if (discountEl) discountEl.textContent = "-$" + discount.toFixed(2);
    if (totalEl) totalEl.textContent = "$" + (totals.total - discount).toFixed(2);
  }

  // Delegate qty +/- and remove clicks inside mini-cart AND cart page
  document.addEventListener("click", function (e) {
    const line = e.target.closest(".cart-line-item, .cart-page-row");
    if (!line) return;
    const id = line.getAttribute("data-id");

    if (e.target.closest(".cli-qty-plus")) updateQty(id, 1);
    if (e.target.closest(".cli-qty-minus")) updateQty(id, -1);
    if (e.target.closest(".cli-remove-btn")) removeFromCart(id);
  });

  // Coupon code (front-end only demo: code "LUXE10" gives $10 off)
  const couponBtn = document.getElementById("applyCouponBtn");
  if (couponBtn) {
    const validCoupons = {
      "LUXE10": 10,
      "SAVE20": 20,
      "WELCOME": 15,
      "FREESHIP": 0
    };

    couponBtn.addEventListener("click", function () {
      const input = document.getElementById("couponInput");
      const msg = document.getElementById("couponMsg");
      if (!input) return;

      const code = input.value.trim().toUpperCase();

      if (validCoupons[code] !== undefined) {
        const discount = validCoupons[code];
        document.body.setAttribute("data-discount", discount);
        if (msg) {
          msg.textContent = discount === 0 ? "Free shipping applied! \ud83d\ude9a" : ("Coupon applied: $" + discount.toFixed(2) + " off \ud83c\udf89");
          msg.classList.remove("text-danger");
          msg.classList.add("text-accent");
        }
        showToast('Coupon "' + code + '" applied successfully!', "success");
      } else {
        document.body.setAttribute("data-discount", "0");
        if (msg) {
          msg.textContent = "Invalid or expired coupon code";
          msg.classList.remove("text-accent");
          msg.classList.add("text-danger");
        }
        showToast("Invalid coupon code. Try LUXE10, SAVE20, or WELCOME.", "error");
      }
      renderCartPage();
    });
  }

  // "Add To Cart" / "Buy Now" buttons anywhere on the site
 // Event Delegation - Works for all current and future product buttons
document.addEventListener("click", function (e) {

    // Add to Cart Button
    const cartBtn = e.target.closest(".btn-cart");
    if (cartBtn) {

        e.preventDefault();

        const card = cartBtn.closest(".product-card");
        // If the button isn't inside a .product-card (e.g. the main
        // "Add To Cart" button on product-details.html), fall back to
        // reading the product straight off that page instead of bailing.
        const product = card ? readProductFromCard(card) : readProductDetailsPage();
        if (!product) return;

        addToCart(product);

        return;
    }

    // Buy Now Button
    const buyBtn = e.target.closest(".btn-buy-now");
    if (buyBtn) {

        e.preventDefault();

        const card = buyBtn.closest(".product-card");
        const product = card ? readProductFromCard(card) : readProductDetailsPage();
        if (!product) return;

        addToCart(product);

        // Was hard-coded to "checkout.html" (a page that doesn't exist
        // in this Laravel app) - now goes through the same sync-then-
        // redirect flow as "Proceed to Checkout" on the cart page.
        syncCartAndGoToCheckout();
    }

});

  /* ---------------------------------------------------------
     3b. WISHLIST (real, database-backed - no page reload)
     The old version of this block kept a second, fake wishlist in
     localStorage and called e.preventDefault() on every wishlist-btn
     click - which silently blocked the real <form class="wishlist-form">
     from ever submitting to the server. That's why "Add to Wishlist"
     never actually saved anything to the database. This version talks
     to the existing customer.wishlist.store / customer.wishlist.destroy
     routes via fetch() instead, so nothing gets added/removed except
     through the real backend.
     --------------------------------------------------------- */
  function csrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute("content") : "";
  }

  function showWishlistToast(message, isError) {
    // Reuses whatever toast/alert mechanism the page already has.
    if (typeof showToast === "function") {
      showToast(message, isError ? "error" : "success");
      return;
    }
    // No toast helper on this page - fail silently rather than alert().
  }

  // Use event delegation so wishlist forms still work when the Shop page
  // replaces product-card HTML dynamically. This also avoids duplicate
  // listeners if a product grid is rendered again.
  document.addEventListener("submit", function (e) {
    const form = e.target.closest(".wishlist-form");
    if (!form) return;

    e.preventDefault();

    const btn = form.querySelector(".wishlist-btn, .pd-wishlist-btn");
    const icon = btn ? btn.querySelector("i") : null;
    if (!btn || btn.disabled) return;

    const isActive = btn.classList.contains("is-wishlisted");
    const wishlistId = form.getAttribute("data-wishlist-id");
    btn.disabled = true;

    const headers = {
      "X-CSRF-TOKEN": csrfToken(),
      "Accept": "application/json",
      "X-Requested-With": "XMLHttpRequest"
    };

    function parseJsonResponse(res) {
      if (!res.ok) {
        throw new Error("Request failed: " + res.status);
      }
      return res.json();
    }

    if (isActive && wishlistId) {
      fetch(form.action + "/" + encodeURIComponent(wishlistId), {
        method: "DELETE",
        headers: headers
      })
        .then(parseJsonResponse)
        .then(function (data) {
          btn.classList.remove("is-wishlisted");
          if (icon) {
            icon.classList.remove("bi-heart-fill");
            icon.classList.add("bi-heart");
          }
          form.removeAttribute("data-wishlist-id");
          showWishlistToast(data.message || "Removed from wishlist.");
        })
        .catch(function (error) {
          console.error("Wishlist remove error:", error);
          showWishlistToast("Something went wrong. Please try again.", true);
        })
        .finally(function () {
          btn.disabled = false;
        });
    } else {
      fetch(form.action, {
        method: "POST",
        headers: headers,
        body: new FormData(form)
      })
        .then(parseJsonResponse)
        .then(function (data) {
          if (data.status === "added" || data.status === "exists") {
            btn.classList.add("is-wishlisted");
            if (icon) {
              icon.classList.remove("bi-heart");
              icon.classList.add("bi-heart-fill");
            }
            if (data.id) {
              form.setAttribute("data-wishlist-id", data.id);
            }
          }
          showWishlistToast(data.message || "Added to wishlist.");
        })
        .catch(function (error) {
          console.error("Wishlist add error:", error);
          showWishlistToast("Something went wrong. Please try again.", true);
        })
        .finally(function () {
          btn.disabled = false;
        });
    }
  });

  /* ---------------------------------------------------------
     4. PRODUCT DETAILS PAGE - THUMBNAIL GALLERY
     --------------------------------------------------------- */
  const mainProductImage = document.getElementById("pdMainImage");
  const thumbnails = document.querySelectorAll(".pd-thumbnails img");

  thumbnails.forEach(function (thumb) {
    thumb.addEventListener("click", function () {
      if (!mainProductImage) return;
      mainProductImage.src = thumb.src;
      thumbnails.forEach(function (t) { t.classList.remove("active"); });
      thumb.classList.add("active");
    });
  });

  /* ---------------------------------------------------------
     5. PRODUCT DETAILS PAGE - QUANTITY SELECTOR
     --------------------------------------------------------- */
  const qtyMinusBtn = document.getElementById("qtyMinus");
  const qtyPlusBtn = document.getElementById("qtyPlus");
  const qtyInput = document.getElementById("qtyInput");

  if (qtyMinusBtn && qtyPlusBtn && qtyInput) {
    qtyMinusBtn.addEventListener("click", function () {
      let value = parseInt(qtyInput.value, 10) || 1;
      if (value > 1) value -= 1;
      qtyInput.value = value;
    });

    qtyPlusBtn.addEventListener("click", function () {
      let value = parseInt(qtyInput.value, 10) || 1;
      value += 1;
      qtyInput.value = value;
    });
  }

  /* ---------------------------------------------------------
     6. SHOP PAGE - PRICE RANGE SLIDER DISPLAY
     --------------------------------------------------------- */
  const priceRangeInput = document.getElementById("priceRange");
  const priceRangeOutput = document.getElementById("priceRangeValue");

  if (priceRangeInput && priceRangeOutput) {
    priceRangeInput.addEventListener("input", function () {
      priceRangeOutput.textContent = "$" + priceRangeInput.value;
    });
  }

  /* ---------------------------------------------------------
     7. BACK TO TOP BUTTON
     --------------------------------------------------------- */
  const backToTopBtn = document.getElementById("backToTop");

  if (backToTopBtn) {
    window.addEventListener("scroll", function () {
      if (window.scrollY > 400) {
        backToTopBtn.classList.add("show");
      } else {
        backToTopBtn.classList.remove("show");
      }
    });

    backToTopBtn.addEventListener("click", function () {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }

  /* ---------------------------------------------------------
     8. (removed) - wishlist add/remove is now handled entirely by the
     "3b. WISHLIST" block above via the real form submit, so there's no
     separate click handler here anymore. Keeping this numbered comment
     so the section numbers below still make sense against the rest of
     the file.
     --------------------------------------------------------- */

  /* ---------------------------------------------------------
     10. QUICK VIEW
     Injects a "Quick View" button onto every product card
     (so we don't need to hand-edit dozens of card blocks) and
     opens a shared Bootstrap modal populated from that card.
     --------------------------------------------------------- */
  document.querySelectorAll(".product-card .product-img-wrap").forEach(function (wrap) {
    if (wrap.querySelector(".quick-view-btn")) return;
    const qvBtn = document.createElement("button");
    qvBtn.type = "button";
    qvBtn.className = "quick-view-btn";
    qvBtn.title = "Quick View";
    qvBtn.innerHTML = '<i class="bi bi-eye"></i>';
    wrap.appendChild(qvBtn);
  });

  const quickViewModalEl = document.getElementById("quickViewModal");
  let quickViewModal = null;
  if (quickViewModalEl && window.bootstrap) {
    quickViewModal = new bootstrap.Modal(quickViewModalEl);
  }

  document.addEventListener("click", function (e) {
    const qvBtn = e.target.closest(".quick-view-btn");
    if (!qvBtn || !quickViewModal) return;

    const card = qvBtn.closest(".product-card");
    const product = readProductFromCard(card);
    const badgeEl = card.querySelector(".product-badge");
    const ratingEl = card.querySelector(".product-rating");
    const oldPriceEl = card.querySelector(".old-price");

    document.getElementById("qvImage").setAttribute("src", product.image);
    document.getElementById("qvImage").setAttribute("alt", product.name);
    document.getElementById("qvCategory").textContent = product.brand;
    document.getElementById("qvName").textContent = product.name;
    document.getElementById("qvRating").innerHTML = ratingEl ? ratingEl.innerHTML : "";
    document.getElementById("qvPrice").textContent = "$" + product.price.toFixed(2);
    document.getElementById("qvOldPrice").textContent = oldPriceEl ? oldPriceEl.textContent : "";
    document.getElementById("qvBadge").textContent = badgeEl ? badgeEl.textContent : "";
    document.getElementById("qvBadge").classList.toggle("d-none", !badgeEl);

    const qvAddBtn = document.getElementById("qvAddToCart");
    qvAddBtn.onclick = function () {
      addToCart(product, 1);
      qvAddBtn.textContent = "Added ✓";
      setTimeout(function () { qvAddBtn.textContent = "Add To Cart"; }, 1200);
    };

    const qvViewLink = document.getElementById("qvViewDetails");
    if (qvViewLink) qvViewLink.href = "product-details.html";

    quickViewModal.show();
  });

  /* ---------------------------------------------------------
     SEARCH OFFCANVAS — form/input references
     Declared here (before the shop filters below) since
     applyShopFilters() reads searchInput as soon as the page
     loads.
     --------------------------------------------------------- */
  const searchForm = document.getElementById("siteSearchForm");
  const searchInput = document.getElementById("siteSearchInput");

  /* ---------------------------------------------------------
     11. SHOP PAGE — FILTERING, SORTING & SEARCH
     Reads category / price / stock / rating straight off each
     .product-card's existing markup (no extra data needed) and
     combines them with the sidebar filters, the sort dropdown
     and the search box into one live result set.
     --------------------------------------------------------- */
  const shopGrid = document.getElementById("shopProductGrid");

  if (shopGrid) {
    const allCards = Array.from(shopGrid.querySelectorAll(".product-card"));
    const originalOrder = allCards.slice(); // remembered for "Featured" sort

    // Pulls the filterable facts straight out of a card's own markup
    function readCardFacts(card) {
      const catEl = card.querySelector(".product-category");
      const nameEl = card.querySelector(".product-name");
      const priceEl = card.querySelector(".product-price");
      const stockEl = card.querySelector(".stock-badge");
      const ratingEl = card.querySelector(".product-rating");

      const price = priceEl ? parseFloat(priceEl.childNodes[0].textContent.replace(/[^0-9.]/g, "")) || 0 : 0;
      const stars = ratingEl ? (ratingEl.textContent.match(/★/g) || []).length : 0;

      return {
        category: catEl ? catEl.textContent.trim() : "",
        name: nameEl ? nameEl.textContent.trim().toLowerCase() : "",
        price: price,
        stock: stockEl ? stockEl.textContent.trim() : "In Stock",
        rating: stars
      };
    }

    function activeValues(selector, attr) {
      return Array.from(document.querySelectorAll(selector + ":checked")).map(function (el) {
        return el.dataset[attr];
      });
    }

    // Applies every active filter + the search term, hides non-matches,
    // and updates the result count / search label
    function applyShopFilters() {
      const activeCats = activeValues(".filter-category", "category");
      const activeStock = activeValues(".filter-availability", "stock");
      const priceRangeEl = document.getElementById("priceRange");
      const maxPrice = priceRangeEl ? parseFloat(priceRangeEl.value) : Infinity;
      const term = searchInput ? searchInput.value.trim().toLowerCase() : "";

      let visibleCount = 0;

      shopGrid.querySelectorAll(".product-card").forEach(function (card) {
        const facts = readCardFacts(card);
        const matchesCategory = activeCats.length === 0 || activeCats.indexOf(facts.category) !== -1;
        const matchesStock = activeStock.length === 0 || activeStock.indexOf(facts.stock) !== -1;
        const matchesPrice = facts.price <= maxPrice;
        const matchesSearch = !term || facts.name.indexOf(term) !== -1 || facts.category.toLowerCase().indexOf(term) !== -1;
        const show = matchesCategory && matchesStock && matchesPrice && matchesSearch;

        card.classList.toggle("d-none", !show);
        if (show) visibleCount++;
      });
      const resultLabel = document.querySelector(".shop-toolbar .result-count");
      if (resultLabel) {
        const total = allCards.length;
        resultLabel.textContent = "Showing " + visibleCount + " of " + total + " result" + (total === 1 ? "" : "s");
      }
      const searchLabel = document.getElementById("shopSearchLabel");
      if (searchLabel) {
        searchLabel.textContent = term ? 'Search results for "' + term + '"' : "";
      }
    }

    // Reorders the cards already in the DOM — doesn't touch visibility
    function applyShopSort(sortValue) {
      let sorted;
      if (sortValue === "price-low") {
        sorted = allCards.slice().sort(function (a, b) { return readCardFacts(a).price - readCardFacts(b).price; });
      } else if (sortValue === "price-high") {
        sorted = allCards.slice().sort(function (a, b) { return readCardFacts(b).price - readCardFacts(a).price; });
      } else if (sortValue === "newest") {
        sorted = allCards.slice().reverse();
      } else if (sortValue === "rating") {
        sorted = allCards.slice().sort(function (a, b) { return readCardFacts(b).rating - readCardFacts(a).rating; });
      } else {
        sorted = originalOrder;
      }
      sorted.forEach(function (card) { shopGrid.appendChild(card); });
    }

    // Category + availability checkboxes filter live as soon as they're clicked
    document.querySelectorAll(".filter-category, .filter-availability").forEach(function (checkbox) {
      checkbox.addEventListener("change", applyShopFilters);
    });

    // Price slider filters live while dragging
    const priceRangeEl = document.getElementById("priceRange");
    if (priceRangeEl) {
      priceRangeEl.addEventListener("input", applyShopFilters);
    }

    // "Apply Filters" re-runs the same filter (handy after adjusting several at once)
    const applyFiltersBtn = document.getElementById("applyFiltersBtn");
    if (applyFiltersBtn) {
      applyFiltersBtn.addEventListener("click", applyShopFilters);
    }

    // "Reset" clears every filter back to "show everything"
    const resetFiltersBtn = document.getElementById("resetFiltersBtn");
    if (resetFiltersBtn) {
      resetFiltersBtn.addEventListener("click", function () {
        document.querySelectorAll(".filter-category, .filter-availability").forEach(function (checkbox) {
          checkbox.checked = false;
        });
        if (priceRangeEl) {
          priceRangeEl.value = priceRangeEl.max;
          const priceOutput = document.getElementById("priceRangeValue");
          if (priceOutput) priceOutput.textContent = "$" + priceRangeEl.max;
        }
        if (searchInput) searchInput.value = "";
        applyShopFilters();
      });
    }

    // Sort dropdown reorders the grid, then re-applies whatever filters are active
    const sortSelect = document.getElementById("shopSortSelect");
    if (sortSelect) {
      sortSelect.addEventListener("change", function () {
        applyShopSort(sortSelect.value);
        applyShopFilters();
      });
    }

    // Run once on load so the result count reflects the real card total
    applyShopFilters();

    // Auto-run the filter if the shop page was opened with ?q=...
    (function runSearchFromUrl() {
      const params = new URLSearchParams(window.location.search);
      const term = params.get("q");
      if (term && searchInput) {
        searchInput.value = term;
        applyShopFilters();
      }
    })();

    // Expose so the search form (below) can trigger it on this page
    window.__applyShopFilters = applyShopFilters;
  }

  /* ---------------------------------------------------------
     SEARCH OFFCANVAS — wiring
     On the shop page it filters the product grid live via
     applyShopFilters() above. On every other page it redirects
     to shop.html?q=... on submit.
     --------------------------------------------------------- */
  if (searchForm && searchInput) {
    searchForm.addEventListener("submit", function (e) {
      e.preventDefault();
      const term = searchInput.value.trim();
      if (typeof window.__applyShopFilters === "function") {
        window.__applyShopFilters();
      } else {
        window.location.href = "/shop" + (term ? "?q=" + encodeURIComponent(term) : "");
      }
    });

    document.querySelectorAll(".search-suggest-tags a").forEach(function (tag) {
      tag.addEventListener("click", function (e) {
        e.preventDefault();
        searchInput.value = tag.textContent.trim();
        searchForm.dispatchEvent(new Event("submit"));
      });
    });
  }

  /* ---------------------------------------------------------
     12. AUTH MODAL (Login / Register / Forgot Password)
     Front-end only: shows a success state after submit since
     there is no backend wired up yet.
     --------------------------------------------------------- */
  document.querySelectorAll(".auth-form").forEach(function (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      const formEl = form.querySelector(".auth-form-fields");
      const successEl = form.querySelector(".auth-form-success");
      if (formEl) formEl.style.display = "none";
      if (successEl) successEl.style.display = "block";
    });
  });

  /* ---------------------------------------------------------
     13. CHECKOUT MODAL (BUYING DETAILS)
     Opens from the "Proceed to Checkout" button on cart.html.
     Front-end only: collects shipping/payment info, shows an
     order summary pulled from the real cart, and on submit
     clears the cart and shows a confirmation screen.
     --------------------------------------------------------- */
  const checkoutModalEl = document.getElementById("checkoutModal");

  if (checkoutModalEl) {

    // Builds one compact row per cart item for the order summary
    function checkoutItemTemplate(item) {
      return (
        '<div class="checkout-item-row">' +
          '<div class="cir-img"><img src="' + item.image + '" alt="' + item.name + '"></div>' +
          '<div class="cir-info">' +
            '<div class="cir-name">' + item.name + '</div>' +
            '<span class="cir-qty">Qty: ' + item.qty + '</span>' +
          '</div>' +
          '<div class="cir-price">$' + (item.price * item.qty).toFixed(2) + '</div>' +
        '</div>'
      );
    }

    // Fills in the order summary list + totals from the real cart
    function renderCheckoutSummary() {
      const listWrap = document.getElementById("checkoutItemsList");
      const cart = getCart();
      if (listWrap) listWrap.innerHTML = cart.map(checkoutItemTemplate).join("");

      const totals = cartTotals();
      const subtotalEl = document.getElementById("checkoutSubtotal");
      const shippingEl = document.getElementById("checkoutShipping");
      const totalEl = document.getElementById("checkoutTotal");
      if (subtotalEl) subtotalEl.textContent = "$" + totals.subtotal.toFixed(2);
      if (shippingEl) shippingEl.textContent = totals.shipping === 0 ? "Free" : "$" + totals.shipping.toFixed(2);
      if (totalEl) totalEl.textContent = "$" + totals.total.toFixed(2);
    }

    // Populate the summary every time the modal is about to open
    checkoutModalEl.addEventListener("show.bs.modal", renderCheckoutSummary);

    // Card fields only need to be filled in (and required) when
    // "Credit / Debit Card" is the selected payment method
    const cardFieldsWrap = document.getElementById("checkoutCardFields");
    const cardInputs = cardFieldsWrap ? cardFieldsWrap.querySelectorAll("input") : [];

    function toggleCardFields() {
      const isCard = document.getElementById("ckPayCard").checked;
      if (cardFieldsWrap) cardFieldsWrap.classList.toggle("d-none", !isCard);
      cardInputs.forEach(function (input) {
        if (isCard) {
          input.setAttribute("required", "required");
        } else {
          input.removeAttribute("required");
        }
      });
    }

    document.querySelectorAll('input[name="ckPayment"]').forEach(function (radio) {
      radio.addEventListener("change", toggleCardFields);
    });
    toggleCardFields();

    // Reset back to the form (instead of the success screen) once
    // the modal has finished closing, ready for next time
    checkoutModalEl.addEventListener("hidden.bs.modal", function () {
      const formFields = checkoutModalEl.querySelector(".checkout-form-fields");
      const successEl = document.getElementById("checkoutSuccess");
      const form = document.getElementById("checkoutForm");
      if (formFields) formFields.style.display = "block";
      if (successEl) successEl.style.display = "none";
      if (form) form.reset();
      toggleCardFields();
    });

    // "Place Order" - front-end only, no real payment is taken
    const checkoutForm = document.getElementById("checkoutForm");
    if (checkoutForm) {
      checkoutForm.addEventListener("submit", function (e) {
        e.preventDefault();

        // Validate required fields, highlighting anything left blank
        const required = this.querySelectorAll("[required]");
        let valid = true;
        required.forEach(function (field) {
          if (!field.value.trim()) {
            field.style.borderColor = "#B5533C";
            valid = false;
          } else {
            field.style.borderColor = "";
          }
        });

        if (!valid) {
          showToast("Please fill in all required fields.", "error");
          return;
        }

        // Generate a friendly order number for the confirmation screen
        const orderNumber = "#LX" + Math.floor(10000 + Math.random() * 89999);
        const orderNumberEl = document.getElementById("checkoutOrderNumber");
        if (orderNumberEl) orderNumberEl.textContent = orderNumber;

        // Order is "placed": empty the cart everywhere on the site
        saveCart([]);
        renderCartBadge();
        renderMiniCart();

        // Swap the form out for the confirmation screen
        const formFields = checkoutModalEl.querySelector(".checkout-form-fields");
        const successEl = document.getElementById("checkoutSuccess");
        if (formFields) formFields.style.display = "none";
        if (successEl) successEl.style.display = "block";

        showToast("Order " + orderNumber + " placed successfully! \ud83c\udf89", "success");
      });
    }
  }

});
/* =========================================================
   ===== IMPROVEMENTS - YEH CODE script.js ke END MEIN DAALEIN =====
   ========================================================= */

/* ---------------------------------------------------------
   14. TOAST NOTIFICATION SYSTEM
   --------------------------------------------------------- */
function showToast(message, type = 'success') {
  // Remove existing toast
  const existing = document.querySelector('.toast-notification');
  if (existing) existing.remove();

  const toast = document.createElement('div');
  toast.className = `toast-notification ${type}`;
  const icon = type === 'success' ? 'bi-check-circle' : 'bi-exclamation-circle';
  toast.innerHTML = `
    <i class="bi ${icon}"></i>
    <span>${message}</span>
  `;
  document.body.appendChild(toast);

  // Trigger show animation
  requestAnimationFrame(() => {
    toast.classList.add('show');
  });

  // Auto hide after 3.5 seconds
  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 500);
  }, 3500);
}

/* ---------------------------------------------------------
   15. RIPPLE EFFECT ON BUTTONS
   --------------------------------------------------------- */
document.addEventListener('click', function(e) {
  const btn = e.target.closest('.btn-primary-custom, .btn-accent-custom, .btn-cart, .btn-view, .ripple');
  if (!btn) return;

  const rect = btn.getBoundingClientRect();
  const ripple = document.createElement('span');
  ripple.className = 'ripple-effect';
  const size = Math.max(rect.width, rect.height);
  ripple.style.width = ripple.style.height = size + 'px';
  ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
  ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
  btn.appendChild(ripple);
  setTimeout(() => ripple.remove(), 600);
});

/* ---------------------------------------------------------
   16. SCROLL ANIMATIONS (Intersection Observer)
   --------------------------------------------------------- */
const animObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('animate-in');
    }
  });
}, {
  threshold: 0.1,
  rootMargin: '0px 0px -50px 0px'
});

// Observe product cards
document.querySelectorAll('.product-card, .category-card, .feature-card, .testimonial-card').forEach(el => {
  el.classList.add('animate-on-scroll');
  animObserver.observe(el);
});

/* ---------------------------------------------------------
   17. SKELETON LOADING (for shop page)
   --------------------------------------------------------- */
function showSkeletons(count = 8) {
  const grid = document.getElementById('shopProductGrid');
  if (!grid) return;

  // Save original content
  const originalHTML = grid.innerHTML;

  // Show skeletons
  let skeletons = '';
  for (let i = 0; i < count; i++) {
    skeletons += `
      <div class="skeleton-card">
        <div class="skeleton-img"></div>
        <div class="skeleton-text"></div>
        <div class="skeleton-text short"></div>
        <div class="skeleton-text medium"></div>
      </div>
    `;
  }
  grid.innerHTML = skeletons;

  // After 1.5 seconds, show real content
  setTimeout(() => {
    grid.innerHTML = originalHTML;
    // Re-observe new cards
    document.querySelectorAll('.product-card, .category-card').forEach(el => {
      el.classList.add('animate-on-scroll');
      animObserver.observe(el);
    });
  }, 1500);
}

// Do not replace the server-rendered shop grid with skeleton HTML.
// The shop page can arrive with an active ?q=... search, so replacing
// the grid after load would restore the unfiltered cards and force the
// customer to search a second time.

/* ---------------------------------------------------------
   18. IMAGE LAZY LOADING WITH FALLBACK
   --------------------------------------------------------- */
document.querySelectorAll('.product-img-wrap img, .category-card img, .pd-main-image img, .wishlist-product-image img').forEach(img => {
  // If image has src, mark as loaded
  if (img.src) {
    img.classList.add('loaded');
  }

  // If image fails to load, show placeholder
  img.addEventListener('error', function() {
    this.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="400" height="500" viewBox="0 0 400 500"%3E%3Crect width="400" height="500" fill="%23EDE7DE"/%3E%3Ctext x="200" y="250" font-family="Arial" font-size="16" fill="%23999" text-anchor="middle"%3ENo Image%3C/text%3E%3C/svg%3E';
    this.classList.add('loaded');
  });
});


/* ---------------------------------------------------------
   20. KEYBOARD NAVIGATION FOR MODALS
   --------------------------------------------------------- */
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    const openModal = document.querySelector('.modal.show');
    if (openModal) {
      const closeBtn = openModal.querySelector('.btn-close, [data-bs-dismiss="modal"]');
      if (closeBtn) closeBtn.click();
    }
  }
});

/* ---------------------------------------------------------
   21. CONSOLE WELCOME MESSAGE (for developers)
   --------------------------------------------------------- */
console.log('%c✨ Luxe Store ✨', 'font-size: 24px; font-weight: bold; color: #A68A64;');
console.log('%cBuilt with ❤️ for everyday luxury.', 'font-size: 14px; color: #6B6B6B;');

 document.addEventListener('DOMContentLoaded', function() {

            // ---------- Scroll Reveal ----------
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });

            document.querySelectorAll('.reveal').forEach(function(el) {
                observer.observe(el);
            });

            // ---------- Stats Counter Animation ----------
            const statNumbers = document.querySelectorAll('.stat-number[data-count]');

            if (statNumbers.length > 0) {
                const statObserver = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            const el = entry.target;
                            const target = parseFloat(el.getAttribute('data-count'));
                            const isDecimal = target % 1 !== 0;
                            let current = 0;
                            const increment = target / 50;
                            const stepTime = 1500 / 50;

                            const timer = setInterval(function() {
                                current += increment;
                                if (current >= target) {
                                    current = target;
                                    clearInterval(timer);
                                }
                                el.textContent = isDecimal ? current.toFixed(1) : Math.round(current);
                            }, stepTime);

                            statObserver.unobserve(el);
                        }
                    });
                }, { threshold: 0.3 });

                statNumbers.forEach(function(el) {
                    statObserver.observe(el);
                });
            }

            // ---------- Toast ----------
            const toastEl = document.getElementById('toast');

            function showToast(msg) {
                if (!toastEl) return;
                toastEl.textContent = "✓ " + msg;
                toastEl.classList.add('show');
                clearTimeout(showToast._timer);
                showToast._timer = setTimeout(function() {
                    toastEl.classList.remove('show');
                }, 2200);
            }

        });
        // ==================Contact Page Specific JS ================

        document.addEventListener('DOMContentLoaded', function() {

            // ---------- Scroll Reveal ----------
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });

            document.querySelectorAll('.reveal').forEach(function(el) {
                observer.observe(el);
            });

            // ---------- Contact Form ----------
            const form = document.getElementById('contactForm');
            const success = document.getElementById('formSuccess');

            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Simple validation
                    const name = document.getElementById('contactName');
                    const email = document.getElementById('contactEmail');
                    const message = document.getElementById('contactMessage');
                    const consent = document.getElementById('contactConsent');

                    let valid = true;

                    if (!name.value.trim()) {
                        name.style.borderColor = '#dc3545';
                        valid = false;
                    } else {
                        name.style.borderColor = '';
                    }

                    if (!email.value.trim() || !email.value.includes('@')) {
                        email.style.borderColor = '#dc3545';
                        valid = false;
                    } else {
                        email.style.borderColor = '';
                    }

                    if (!message.value.trim()) {
                        message.style.borderColor = '#dc3545';
                        valid = false;
                    } else {
                        message.style.borderColor = '';
                    }

                    if (!consent.checked) {
                        consent.style.outline = '2px solid #dc3545';
                        valid = false;
                    } else {
                        consent.style.outline = '';
                    }

                    if (!valid) {
                        showToast('Please fill in all required fields.');
                        return;
                    }

                    // Success
                    form.style.display = 'none';
                    success.style.display = 'block';
                    showToast('Your message has been sent successfully! 🎉');
                });
            }

            // ---------- Reset Form ----------
            window.resetForm = function() {
                const form = document.getElementById('contactForm');
                const success = document.getElementById('formSuccess');
                if (form) {
                    form.reset();
                    form.style.display = 'block';
                }
                if (success) {
                    success.style.display = 'none';
                }
                document.querySelectorAll('.form-control').forEach(function(el) {
                    el.style.borderColor = '';
                });
                document.getElementById('contactConsent').style.outline = '';
            };

            // ---------- Toast ----------
            const toastEl = document.getElementById('toast');

            function showToast(msg) {
                if (!toastEl) return;
                toastEl.textContent = "✓ " + msg;
                toastEl.classList.add('show');
                clearTimeout(showToast._timer);
                showToast._timer = setTimeout(function() {
                    toastEl.classList.remove('show');
                }, 3000);
            }

            // ---------- Back to Top ----------
            const backToTop = document.getElementById('backToTop');
            if (backToTop) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 400) {
                        backToTop.classList.add('show');
                    } else {
                        backToTop.classList.remove('show');
                    }
                });

                backToTop.addEventListener('click', function() {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }

        });
