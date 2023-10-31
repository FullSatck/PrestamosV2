document.addEventListener("DOMContentLoaded", () => {
    document.querySelector('#sidebarCollapse').addEventListener('click', () => {
        document.querySelector('#sidebar').classList.toggle('active');
        document.querySelector('#content').classList.toggle('active');
    });
});
