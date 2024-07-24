// Fungsi untuk menambahkan titik sebagai pemisah ribuan
function formatRupiah(angka) {
  var number_string = angka.replace(/[^,\d]/g, "").toString(),
    split = number_string.split(","),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  if (ribuan) {
    separator = sisa ? "." : "";
    rupiah += separator + ribuan.join(".");
  }

  rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
  return rupiah;
}

// Fungsi untuk memvalidasi dan memformat input
function validateInput() {
  var totalBelanjaInput = document.getElementById("total_belanja");
  var value = totalBelanjaInput.value.replace(/\./g, "").replace(",", ".");
  if (parseFloat(value) < 0) {
    alert("Total belanja tidak boleh negatif.");
    totalBelanjaInput.value = "";
    return false;
  }
  totalBelanjaInput.value = formatRupiah(totalBelanjaInput.value);
}

document.addEventListener("DOMContentLoaded", function () {
  var totalBelanjaInput = document.getElementById("total_belanja");
  totalBelanjaInput.addEventListener("keyup", validateInput);
});
