document.getElementById('sidebarToggle').addEventListener('click', function() {
    var sidebar = document.getElementById('sidebar');
    var content = document.getElementById('content');
    
    sidebar.classList.toggle('closed');
    content.classList.toggle('expanded');
});
