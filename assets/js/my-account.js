// JavaScript for custom My Account page functionality

document.addEventListener('DOMContentLoaded', () => {
    const sidebarItems = document.querySelectorAll('.custom-account-sidebar-item');
    const sections = document.querySelectorAll('.custom-account-content-section');

    sidebarItems.forEach(item => {
        item.addEventListener('click', e => {
            e.preventDefault();
            const target = item.dataset.section;

            sidebarItems.forEach(i => i.classList.remove('custom-account-active'));
            sections.forEach(s => s.classList.remove('custom-account-active'));

            item.classList.add('custom-account-active');
            document.getElementById(target)?.classList.add('custom-account-active');
        });
    });


    const trackBtn = document.querySelector('.custom-account-track-btn');
    trackBtn?.addEventListener('click', () => {
        const value = document.getElementById('tracking-number')?.value.trim();
        alert(value ? `Tracking package: ${value}` : 'Please enter a tracking number');
    });

});





// save and edit button functionality can be added here
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("custom-account-form");
    const button = document.getElementById("edit-save-btn");
    const inputs = form.querySelectorAll("input[type=text], input[type=email]");

    button.addEventListener("click", function () {
        if (button.textContent === "Edit") {
            // Enable fields
            inputs.forEach(input => input.removeAttribute("disabled"));
            button.textContent = "Save";
        } else {
            // Submit form
            form.submit();
        }
    });
});