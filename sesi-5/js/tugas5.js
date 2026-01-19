// ================= DATA =================
const products = [
  {
    id: 1,
    name: "Laptop Gaming",
    price: 15000000,
    description: "Laptop gaming performa tinggi",
    image: "https://cdn1-production-images-kly.akamaized.net/79vkH4uf5B9i9-pnm3jHfKgU840=/1280x720/smart/filters:quality(75):strip_icc()/kly-media-production/medias/3018975/original/022373600_1578727570-asus-tuf-laptops01.jpg",
    category: "Elektronik"
  },
  {
    id: 2,
    name: "Headphone",
    price: 350000,
    description: "Headphone bass mantap",
    image: "https://starcompjogja.com/storage/product/ac7d54d4fa90eaf5263d6a13f3bb9c0b_headset-dbe-gm350_2.webp",
    category: "Elektronik"
  },
  {
    id: 3,
    name: "Mouse Gaming",
    price: 150000,
    description: "Mouse gaming performa tinggi",
    image: "https://down-id.img.susercontent.com/file/be94cbe1686efe1779543e2d2683dc66",
    category: "Elektronik"
  },
  {
    id: 4,
    name: "Sepatu Sneakers",
    price: 750000,
    description: "Sneakers nyaman dan stylish",
    image: "https://image.807garage.com/content/uploads/2024/6/new-balance-530-white-silver-navy-8.jpg",
    category: "Fashion"
  },
  {
    id: 5,
    name: "Baju",
    price: 550000,
    description: "Kaos nyaman dan stylish",
    image: "https://media.karousell.com/media/photos/products/2024/12/17/rucas_artist_edition_sadikin_p_1734413166_35fdb437_progressive.jpg",
    category: "Fashion"
  },
  {
    id: 6,
    name: "Celana",
    price: 750000,
    description: "Celana nyaman dan stylish",
    image: "https://down-id.img.susercontent.com/file/id-11134207-7rasf-m4j8ec7w30aid2",
    category: "Fashion"
  },
  {
    id: 7,
    name: "Kopi Arabika",
    price: 120000,
    description: "Kopi arabika premium",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSLjeC8Dq4xmwh8Tc0UuG-oi3F38sUS6F3v_w&s",
    category: "Makanan"
  },
  {
    id: 8,
    name: "Susu UHT",
    price: 10000,
    description: "Susu sapi segar dan murni",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTYj2JuOJnnITCVBfgEz-HtNWGUvATR0ZTskw&s",
    category: "Makanan"
  },
  {
    id: 9,
    name: "Beras Segar",
    price: 44000,
    description: "Beras 5kg kualitas terbaik",
    image: "https://cdn.kerbel.in/assets/product/product_AAL8SQHGJT_1659922570_1.webp",
    category: "Makanan"
  }
];

let cart = [];

// ================= ELEMENT =================
const productList = document.getElementById("productList");
const categoryFilter = document.getElementById("categoryFilter");
const searchInput = document.getElementById("searchInput");
const priceSort = document.getElementById("priceSort");
const cartCount = document.getElementById("cartCount");
const cartItems = document.getElementById("cartItems");
const cartTotal = document.getElementById("cartTotal");

// ================= CATEGORY =================
function loadCategories() {
  const categories = ["all", ...new Set(products.map(p => p.category))];
  categoryFilter.innerHTML = categories
    .map(c => `<option value="${c}">${c}</option>`)
    .join("");
}

// ================= RENDER =================
function renderProducts(data) {
  productList.innerHTML = "";
  data.forEach(p => {
    productList.innerHTML += `
      <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="card h-100">
          <img src="${p.image}" class="card-img-top">
          <div class="card-body d-flex flex-column">
            <h5>${p.name}</h5>
            <p class="text-primary fw-bold">Rp ${p.price.toLocaleString("id-ID")}</p>
            <button class="btn btn-sm btn-outline-primary mb-2" onclick="showDetail(${p.id})">
              Detail
            </button>
            <button class="btn btn-sm btn-success" onclick="addToCart(${p.id})">
              Add to Cart
            </button>
          </div>
        </div>
      </div>
    `;
  });
}

// ================= DETAIL MODAL =================
function showDetail(id) {
  const p = products.find(item => item.id === id);
  document.getElementById("productDetail").innerHTML = `
    <div class="row">
      <div class="col-md-6">
        <img src="${p.image}" class="img-fluid rounded">
      </div>
      <div class="col-md-6">
        <h3>${p.name}</h3>
        <p>${p.description}</p>
        <h5 class="text-primary">Rp ${p.price.toLocaleString("id-ID")}</h5>
        <button class="btn btn-success" onclick="addToCart(${p.id})">
          Add to Cart
        </button>
      </div>
    </div>
  `;
  new bootstrap.Modal(document.getElementById("productModal")).show();
}

// ================= CART =================
function addToCart(id) {
  const product = products.find(p => p.id === id);
  cart.push(product);
  updateCart();
}

function updateCart() {
  cartCount.textContent = cart.length;
  cartItems.innerHTML = "";

  let total = 0;
  cart.forEach(item => {
    total += item.price;
    cartItems.innerHTML += `
      <div class="d-flex justify-content-between border-bottom py-2">
        <span>${item.name}</span>
        <strong>Rp ${item.price.toLocaleString("id-ID")}</strong>
      </div>
    `;
  });

  cartTotal.textContent = total.toLocaleString("id-ID");
}

// ================= FILTER =================
function applyFilter() {
  let result = [...products];

  const search = searchInput.value.toLowerCase();
  result = result.filter(p => p.name.toLowerCase().includes(search));

  if (categoryFilter.value !== "all") {
    result = result.filter(p => p.category === categoryFilter.value);
  }

  if (priceSort.value === "low") {
    result.sort((a, b) => a.price - b.price);
  } else if (priceSort.value === "high") {
    result.sort((a, b) => b.price - a.price);
  }

  renderProducts(result);
}

// ================= EVENT =================
searchInput.addEventListener("input", applyFilter);
categoryFilter.addEventListener("change", applyFilter);
priceSort.addEventListener("change", applyFilter);

// INIT
loadCategories();
renderProducts(products);
