// ambil elemen2 yang dibutuhkan

let tombolKategori = document.querySelectorAll(".nama-pelatihan a");
let kontenPelatihan = document.getElementById("konten-pelatihan");

tombolKategori.forEach(function (el) {
  el.addEventListener("click", function (e) {
    // console.log(e.target.getAttribute("href"));
    const isiHref = e.target.getAttribute("href");
    e.preventDefault(); // cegah aksi default tag a
    e.stopPropagation(); // cegah event bubbling

    // buat object ajax
    let xhr = new XMLHttpRequest(); // biasanya namanya xhr/ajax

    // cek kesiapan ajax
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        //console.log(xhr.responseText);
        kontenPelatihan.innerHTML = xhr.responseText;
      }
    };

    // eksekusi ajax
    xhr.open("GET", "ajax/programPelatihan.php?kategori=" + isiHref, true); // false = syncronus,true = asyncronus
    xhr.send();
  });
});

// if (typeof variabel_kamu !== 'undefined') {
//   // kode kamu, jika variabel_kamu eksis
// }

// ambil elemen2 yang dibutuhkan
let cari = document.getElementById("cari");
let kontenTable = document.getElementById("konten-table");

if (cari !== null && kontenTable !== null) {
  // kode kamu, jika variabel_kamu eksis

  // tombolCari.addEventListener("click", function () {
  //   alert("Berhasil");
  // });

  // tambahkan event ketika cari ditulis
  cari.addEventListener("keyup", function () {
    //   console.log(cari.value); // ambil apappun yang diketik oleh user

    // buat object ajax
    let xhr = new XMLHttpRequest(); // biasanya namanya xhr/ajax

    // cek kesiapan ajax
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        //console.log(xhr.responseText);
        kontenTable.innerHTML = xhr.responseText;
      }
    };

    // eksekusi ajax
    xhr.open("GET", "ajax/pencarianPendaftaranAjax.php?cari=" + cari.value, true); // false = syncronus,true = asyncronus
    xhr.send();
  });
}

// ambil elemen2 yang dibutuhkan

let cariUser = document.getElementById("cari-user");
let kontenTableUser = document.getElementById("konten-table-user");

if (cariUser !== null && kontenTableUser !== null) {
  // tombolCari.addEventListener("click", function () {
  //   alert("Berhasil");
  // });

  // tambahkan event ketika cari ditulis
  cariUser.addEventListener("keyup", function () {
    //   console.log(cari.value); // ambil apappun yang diketik oleh user

    // buat object ajax
    let xhr = new XMLHttpRequest(); // biasanya namanya xhr/ajax

    // cek kesiapan ajax
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        //console.log(xhr.responseText);
        kontenTableUser.innerHTML = xhr.responseText;
      }
    };

    // eksekusi ajax
    xhr.open("GET", "ajax/pencarianDataUserAjax.php?cari=" + cariUser.value, true); // false = syncronus,true = asyncronus
    xhr.send();
  });
}
