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

    const editBtn = document.querySelector('.custom-account-edit-btn');
    editBtn?.addEventListener('click', () => alert('Edit functionality would be implemented here'));

    const trackBtn = document.querySelector('.custom-account-track-btn');
    trackBtn?.addEventListener('click', () => {
        const value = document.getElementById('tracking-number')?.value.trim();
        alert(value ? `Tracking package: ${value}` : 'Please enter a tracking number');
    });
});
