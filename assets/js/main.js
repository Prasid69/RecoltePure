document.addEventListener("DOMContentLoaded", function () {

    const productCards = document.querySelectorAll(".product-card, .cart-item"); // Supports both grid cards and cart items

    if (productCards.length > 0) {
        productCards.forEach(card => {
            const minusBtn = card.querySelector(".minus, .qty-btn[value='decrease']");
            const plusBtn  = card.querySelector(".plus, .qty-btn[value='increase']");
            
            const counterInput = card.querySelector(".counter-input, .qty-input"); 
            
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

    const carouselWrapper = document.querySelector(".carousel-wrapper");
    const navBtns = document.querySelectorAll(".nav-btn");

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

        setActive(productGrid.classList.contains("list-view") ? listBtn : gridBtn);
    }

    const userBtn = document.querySelector(".user-btn");
    const dropdown = document.querySelector(".dropdown-menu");

    if (userBtn && dropdown) {
        userBtn.addEventListener("click", (e) => {
            e.stopPropagation(); 
            dropdown.style.display = dropdown.style.display === "flex" ? "none" : "flex";
        });

        document.addEventListener("click", (e) => {
            if (!userBtn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = "none";
            }
        });
    }


   
    const searchForm = document.querySelector('.search-box');
    const searchBtn = document.querySelector('.search-btn');
    const searchInput = document.querySelector('.search-input');

    if (searchForm && searchBtn) {
        searchBtn.addEventListener('click', (e) => {
            if (!searchForm.classList.contains('active')) {
                e.preventDefault(); 
                searchForm.classList.add('active'); 
                searchInput.focus(); 
            } 
            else if (searchInput.value.trim() === '') {
                e.preventDefault();
                searchForm.classList.remove('active');
            }
        });
    }


    const menuToggle = document.getElementById('menu-toggle');
    const navLinks = document.querySelector('.nav-links');

    menuToggle.addEventListener('click', () => {
    navLinks.classList.toggle('active');
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const searchInput = this.querySelector('input[name="search"]');
            const search = searchInput.value.trim();
            
            const categoryId = this.dataset.categoryId || 1;
            let url = `/RecoltePure/categories/${categoryId}`;
            if (search.length > 0) {
                url += `/search/${encodeURIComponent(search)}`;
            }

            window.location.href = url;
        });
    }
});


document.addEventListener('DOMContentLoaded', function() {
    const productWrappers = document.querySelectorAll('.product-img-wrapper');

    productWrappers.forEach(wrapper => {
        const imgTag = wrapper.querySelector('img');
        const images = JSON.parse(wrapper.dataset.images);
        let index = 0;
        let interval;

        wrapper.addEventListener('mouseenter', () => {
            if (images.length <= 1) return;

            interval = setInterval(() => {
                index = (index + 1) % images.length;
                imgTag.src = `/RecoltePure/assets/uploads/products/${images[index]}`;
            }, 800); // swap every 800ms
        });

        wrapper.addEventListener('mouseleave', () => {
            clearInterval(interval);
            index = 0;
            imgTag.src = `/RecoltePure/assets/uploads/products/${images[0]}`;
        });
    });
});
