form.distpay.addEventListener("keydown", e => {
    if (e.key === "Enter") {
        e.preventDefault();
        form.distpay.value = eval(form.distpay.value)
    }
    else if (e.key === "Delete") {
        e.preventDefault();
        form.distpay.value = null
    }

})

function calculator(x) {
    form.distpay.value = form.distpay.value + x;
}
