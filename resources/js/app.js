import "./bootstrap";

document.addEventListener("DOMContentLoaded", function () {
    // Select all forms
    var forms = document.querySelectorAll("form");

    forms.forEach(function (form) {
        form.addEventListener("submit", function (event) {
            var submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                // Re-enable the button after 3 seconds
                setTimeout(function () {
                    submitButton.disabled = false;
                }, 500);
            }
        });
    });
});
