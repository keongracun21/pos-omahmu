let orders = {};

function selectMenu(nama, harga) {
    // 1. Format nama file gambar dengan benar
    const formattedName = nama
        .toLowerCase()
        .replace(/\s+/g, "-") // Ganti spasi dengan dash
        .replace(/[^a-z0-9-]/g, ""); // Hapus karakter khusus

    // 2. Gunakan path relatif dari public/img
    const imgPath = `img/${formattedName}.png`;

    if (orders[nama]) {
        orders[nama].qty += 1;
    } else {
        orders[nama] = {
            nama: nama,
            harga: harga,
            qty: 1,
            img: imgPath, // Gunakan path langsung tanpa asset helper
        };
    }

    renderOrderPanel();
}

function changeQty(nama, delta) {
    if (orders[nama]) {
        orders[nama].qty += delta;
        if (orders[nama].qty <= 0) {
            delete orders[nama];
        }
        renderOrderPanel();
    }
}

function renderOrderPanel() {
    const container = document.getElementById("orderContent");
    container.innerHTML = "";

    let totalItems = 0;
    let totalHarga = 0;

    for (let key in orders) {
        const item = orders[key];
        totalItems += item.qty;
        totalHarga += item.harga * item.qty;

        const element = document.createElement("div");
        element.className =
            "d-flex align-items-center border rounded p-2 position-relative";
        element.innerHTML = `
            <div style="width: 5px; height: 100%; background-color: #1E293B; position: absolute; left: 0; top: 0; border-top-left-radius: 6px; border-bottom-left-radius: 6px;"></div>
            <img src="${item.img}" alt="${
            item.nama
        }" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; margin-left: 10px; margin-right: 10px;">
            <div class="flex-grow-1">
                <div class="fw-bold">${item.nama}</div>
                <div>Rp ${item.harga.toLocaleString()}</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm px-2" style="background-color:#1E293B; color:white;" onclick="changeQty('${
                    item.nama
                }', -1)">-</button>
                <span>${item.qty}</span>
                <button class="btn btn-sm px-2" style="background-color:#1E293B; color:white;" onclick="changeQty('${
                    item.nama
                }', 1)">+</button>
            </div>
        `;
        container.appendChild(element);
    }

    if (totalItems === 0) {
        container.innerHTML =
            '<small class="text-muted">Silahkan pilih menu</small>';
    }

    document.getElementById(
        "totalItemsLabel"
    ).innerText = `${totalItems} items`;
    document.getElementById(
        "totalHargaLabel"
    ).innerText = `Rp ${totalHarga.toLocaleString()}`;
}

function filterMenu(kategori) {
    const allMenuItems = document.querySelectorAll(".menu-item");
    allMenuItems.forEach((item) => {
        item.style.display =
            item.getAttribute("data-kategori") === kategori ? "block" : "none";
    });

    // Tambahkan highlight ke tombol aktif
    document
        .querySelectorAll(".menu-tabs button")
        .forEach((btn) => btn.classList.remove("active"));
    event.target.classList.add("active");
}

function goToPayment() {
    const totalItems = document.getElementById("totalItemsLabel").innerText;
    const totalHarga = document.getElementById("totalHargaLabel").innerText;

    if (totalItems === "0 items") {
        alert("Silakan pilih menu terlebih dahulu!");
        return;
    }

    document.getElementById("orderPanel").classList.add("d-none");
    document.getElementById("paymentPanel").classList.remove("d-none");

    document.getElementById("totalItemsLabelPayment").innerText = totalItems;
    document.getElementById("totalHargaLabelPayment").innerText = totalHarga;
}

function goBackToOrder() {
    document.getElementById("paymentPanel").classList.add("d-none");
    document.getElementById("orderPanel").classList.remove("d-none");
}

function handlePayment(method) {
    const metode =
        method === "credit"
            ? "Credit Card"
            : method === "cash"
            ? "Cash"
            : "QR Code";
    alert(`Pembayaran dengan ${metode} berhasil!`);

    // Reset order
    document.getElementById("orderContent").innerHTML =
        '<small class="text-muted">Silahkan pilih menu</small>';
    document.getElementById("totalItemsLabel").innerText = "0 items";
    document.getElementById("totalHargaLabel").innerText = "Rp 0";

    goBackToOrder();
}

function selectPayment(method) {
    const creditForm = document.getElementById("creditCardForm");
    const cashForm = document.getElementById("cashForm");
    const qrForm = document.getElementById("qrForm");
    const methods = document.querySelectorAll(".payment-method");

    // Reset tampilan semua metode
    methods.forEach((el) => el.classList.remove("selected"));
    creditForm.classList.add("d-none");
    cashForm.classList.add("d-none");
    qrForm.classList.add("d-none");

    // Tampilkan form sesuai metode
    if (method === "credit") {
        creditForm.classList.remove("d-none");
    } else if (method === "cash") {
        cashForm.classList.remove("d-none");
    } else if (method === "qr") {
        qrForm.classList.remove("d-none");
    }

    // Tandai metode yang dipilih
    document
        .querySelector(`.payment-method[onclick="selectPayment('${method}')"]`)
        .classList.add("selected");
}

function hitungKembalian() {
    const jumlahBayar =
        parseInt(document.getElementById("jumlahBayarInput").value) || 0;
    const totalLabel = document.getElementById(
        "totalHargaLabelPayment"
    ).innerText;
    const total = parseInt(totalLabel.replace(/[^\d]/g, ""));

    const kembalian = jumlahBayar - total;
    const kembalianOutput = document.getElementById("kembalianOutput");

    if (kembalian < 0) {
        kembalianOutput.value = "Kurang Bayar";
    } else {
        kembalianOutput.value = `Rp ${kembalian.toLocaleString()}`;
    }
}

function submitPayment() {
    const selected = document.querySelector(".payment-method.selected");

    if (!selected) {
        alert("Silakan pilih metode pembayaran!");
        return;
    }

    const method = selected.getAttribute("data-method");

    if (method === "cash") {
        const jumlahBayar =
            parseInt(document.getElementById("jumlahBayarInput").value) || 0;
        const total = parseInt(
            document
                .getElementById("totalHargaLabelPayment")
                .innerText.replace(/[^\d]/g, "")
        );

        if (jumlahBayar < total) {
            alert("Jumlah bayar kurang dari total belanja.");
            return;
        }

        alert("Pembayaran tunai berhasil!");
    } else if (method === "credit") {
        alert("Pembayaran dengan kartu berhasil!");
    } else if (method === "qr") {
        alert("Pembayaran QR berhasil!");
    }

    // Reset semua form dan order
    orders = {};
    document.getElementById("orderContent").innerHTML =
        '<small class="text-muted">Silahkan pilih menu</small>';
    document.getElementById("totalItemsLabel").innerText = "0 items";
    document.getElementById("totalHargaLabel").innerText = "Rp 0";
    document.getElementById("jumlahBayarInput").value = "";
    document.getElementById("kembalianOutput").value = "";

    goBackToOrder();
}
