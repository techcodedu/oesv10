import Cleave from "cleave.js";

const alert = document.getElementById("alert");
setTimeout(() => {
    alert.style.opacity = 0;
    setTimeout(() => {
        alert.style.display = "none";
    }, 400);
}, 1000);

var cleave = new Cleave("#price", {
    numeral: true,
    numeralDecimalMark: ".",
    delimiter: ",",
    numeralDecimalScale: 2,
    numeralPositiveOnly: true,
    prefix: "₱",
});

setTimeout(function () {
    $(".alert").fadeOut("slow");
}, 3000);
