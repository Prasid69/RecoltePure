document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".product-card").forEach(card => {
        const minusBtn = card.querySelector(".minus");
        const plusBtn  = card.querySelector(".plus");
        const counterInput = card.querySelector(".counter-input");
        const quantityField = card.querySelector(".quantity-field");

        // Only attach if element exists
        if (plusBtn) {
            plusBtn.addEventListener("click", () => {
                let value = parseInt(counterInput.value);
                value++;
                counterInput.value = value;
                quantityField.value = value;
            });
        }

        if (minusBtn) {
            minusBtn.addEventListener("click", () => {
                let value = parseInt(counterInput.value);
                if (value > 1) value--;
                counterInput.value = value;
                quantityField.value = value;
            });
        }
    });
});



window.addEventListener("scroll", function() {
    const navbar = document.querySelector(".navbar");
    if (window.scrollY > 100) { 
        navbar.classList.add("scrolled");
    } else {
        navbar.classList.remove("scrolled");
    }
});


document.querySelectorAll(".product-card").forEach(card => {
    const minusBtn = card.querySelector(".minus");
    const plusBtn  = card.querySelector(".plus");
    const counterInput = card.querySelector(".counter-input");
    const quantityField = card.querySelector(".quantity-field");

    plusBtn.addEventListener("click", () => {
        let value = parseInt(counterInput.value);
        value++;
        counterInput.value = value;
        quantityField.value = value;
    });

    minusBtn.addEventListener("click", () => {
        let value = parseInt(counterInput.value);
        if (value > 1) {
            value--;
            counterInput.value = value;
            quantityField.value = value;
        }
    });
});


const wrapper = document.querySelector(".carousel-wrapper");
const prevBtn = document.querySelectorAll(".nav-btn")[0];
const nextBtn = document.querySelectorAll(".nav-btn")[1];

const scrollAmount = 270; 
nextBtn.addEventListener("click", () => {
    wrapper.scrollBy({ left: scrollAmount, behavior: 'smooth' });
});


prevBtn.addEventListener("click", () => {
    wrapper.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
});



document.addEventListener("DOMContentLoaded", function () {
    const productGrid = document.getElementById("productGrid");
    const gridBtn = document.getElementById("gridView");
    const listBtn = document.getElementById("listView");

    if (!productGrid || !gridBtn || !listBtn) return;
    // Default view
    if (!productGrid.classList.contains("grid-view") && !productGrid.classList.contains("list-view")) {
        productGrid.classList.add("grid-view");
    }

    // Active button styling
    function setActive(btn) {
        gridBtn.classList.remove("active-view");
        listBtn.classList.remove("active-view");
        btn.classList.add("active-view");
    }

    // Click events
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

    // Initial active state
    setActive(gridBtn);
});

