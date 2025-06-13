document.querySelectorAll('.toggle-done').forEach(checkbox => {
    checkbox.addEventListener('change', async function () {
        const id = this.getAttribute('data-id');
        const response = await fetch(`toggle.php?id=${id}`);
        const data = await response.json();

        if (data.id) {
            this.closest('li').classList.toggle('done', data.is_done);
        }
    });
});
