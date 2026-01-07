document.addEventListener("DOMContentLoaded", function () {

    // =========================================================
    // 1. PRODUCT QUANTITY COUNTER (+ / - Buttons)
    //    Works on: Product Cards & Cart Page
    // =========================================================
    const productCards = document.querySelectorAll(".product-card, .cart-item"); // Supports both grid cards and cart items

    if (productCards.length > 0) {
        productCards.forEach(card => {
            const minusBtn = card.querySelector(".minus, .qty-btn[value='decrease']");
            const plusBtn  = card.querySelector(".plus, .qty-btn[value='increase']");
            
            // Matches the visible input
            const counterInput = card.querySelector(".counter-input, .qty-input"); 
            
            // Matches the hidden input (FIXED: changed .quantity-field to .quantity-input)
            const hiddenInput = card.querySelector(".quantity-input, input[name='quantity']"); 

            // Only run if this specific card has the buttons
            if (plusBtn && counterInput) {
                plusBtn.addEventListener("click", (e) => {
                    // If it's a submit button (like in cart), don't prevent default submission
                    if(plusBtn.type !== 'submit') {
                         let value = parseInt(counterInput.value);
                         value++;
                         counterInput.value = value;
                         if(hiddenInput) hiddenInput.value = value;
                    }
                });
            }

            if (minusBtn && counterInput) {
                minusBtn.addEventListener("click", (e) => {
                    // If it's a submit button (like in cart), don't prevent default submission
                    if(minusBtn.type !== 'submit') {
                        let value = parseInt(counterInput.value);
                        if (value > 1) value--;
                        counterInput.value = value;
                        if(hiddenInput) hiddenInput.value = value;
                    }
                });
            }
        });
    }

    // =========================================================
    // 2. NAVBAR SCROLL EFFECT
    //    Works on: All Pages
    // =========================================================
    const navbar = document.querySelector(".navbar");
    if (navbar) {
        window.addEventListener("scroll", function() {
            if (window.scrollY > 100) { 
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });
    }

    // =========================================================
    // 3. CAROUSEL SLIDER
    //    Works on: Home Page / Categories Page only
    // =========================================================
    const carouselWrapper = document.querySelector(".carousel-wrapper");
    const navBtns = document.querySelectorAll(".nav-btn");

    // Only run if wrapper AND buttons exist
    if (carouselWrapper && navBtns.length >= 2) {
        const prevBtn = navBtns[0];
        const nextBtn = navBtns[1];
        const scrollAmount = 270; 

        nextBtn.addEventListener("click", () => {
            carouselWrapper.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });

        prevBtn.addEventListener("click", () => {
            carouselWrapper.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        });
    }

    // =========================================================
    // 4. GRID / LIST VIEW TOGGLE
    //    Works on: Categories Page only
    // =========================================================
    const productGrid = document.getElementById("productGrid");
    const gridBtn = document.getElementById("gridView");
    const listBtn = document.getElementById("listView");

    if (productGrid && gridBtn && listBtn) {
        // Set Default View if not set
        if (!productGrid.classList.contains("grid-view") && !productGrid.classList.contains("list-view")) {
            productGrid.classList.add("grid-view");
        }

        function setActive(btn) {
            gridBtn.classList.remove("active-view");
            listBtn.classList.remove("active-view");
            btn.classList.add("active-view");
        }

        gridBtn.addEventListener("click", function () {
            productGrid.classList.add("grid-view");
            productGrid.classList.remove("list-view");
            setActive(gridBtn);
        });

        listBtn.addEventListener("click", function () {
            productGrid.classList.add("list-view");
            productGrid.classList.remove("grid-view");
            setActive(listBtn);
        });

        // Initialize button state
        setActive(productGrid.classList.contains("list-view") ? listBtn : gridBtn);
    }

    // =========================================================
    // 5. USER DROPDOWN MENU
    //    Works on: All Pages (assuming header is everywhere)
    // =========================================================
    const userBtn = document.querySelector(".user-btn");
    const dropdown = document.querySelector(".dropdown-menu");

    if (userBtn && dropdown) {
        userBtn.addEventListener("click", (e) => {
            e.stopPropagation(); // Stop click from bubbling to document
            dropdown.style.display = dropdown.style.display === "flex" ? "none" : "flex";
        });

        document.addEventListener("click", (e) => {
            if (!userBtn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = "none";
            }
        });
    }


    // 6. SEARCH BAR TOGGLE
    const searchForm = document.querySelector('.search-box');
    const searchBtn = document.querySelector('.search-btn');
    const searchInput = document.querySelector('.search-input');

    if (searchForm && searchBtn) {
        searchBtn.addEventListener('click', (e) => {
            // Check if the search bar is already open
            if (!searchForm.classList.contains('active')) {
                e.preventDefault(); // Stop form submission
                searchForm.classList.add('active'); // Expand the bar
                searchInput.focus(); // Put cursor inside
            } 
            // If open but empty, close it instead of submitting
            else if (searchInput.value.trim() === '') {
                e.preventDefault();
                searchForm.classList.remove('active');
            }
            // If open AND has text, let it submit normally (no code needed)
        });
    }


    const menuToggle = document.getElementById('menu-toggle');
    const navLinks = document.querySelector('.nav-links');

    menuToggle.addEventListener('click', () => {
    navLinks.classList.toggle('active');
    });
});