/*!
    * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
// 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('.sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});





document.addEventListener('DOMContentLoaded', function () {
    const toggleSidebar = document.getElementById('close-sidebar'); // Sidebar toggle button
    const pageWrapper = document.querySelector('.page-wrapper');
    const sidebar = document.getElementById('sidebare'); // Sidebar element
    const layoutContent = document.getElementById('layoutSidenav_content');
    const layoutHeader = document.getElementById('layoutHeader');
    const sidebarDropdownLinks = document.querySelectorAll('.sidebar-dropdown > a');

    // Function to update rotation of the toggle button
    function updateToggleRotation() {
        if (pageWrapper.classList.contains('toggled')) {
            // Rotate when expanded
            toggleSidebar.style.transform = 'rotate(180deg)';
        } else {
            // Reset rotation when collapsed
            toggleSidebar.style.transform = 'rotate(0deg)';
        }
    }

    // Toggle sidebar visibility
    toggleSidebar.addEventListener('click', function () {
        if (pageWrapper.classList.contains('toggled')) {
            // If sidebar is open, close it
            pageWrapper.classList.remove('toggled');
            sidebar.classList.add('collapsed'); // Add collapsed class
            layoutContent.style.paddingLeft = '80px'; // Adjust padding when sidebar is collapsed
            layoutHeader.style.paddingLeft = '80px'; // Adjust padding when sidebar is collapsed
        } else {
            // If sidebar is closed, open it
            pageWrapper.classList.add('toggled');
            sidebar.classList.remove('collapsed'); // Remove collapsed class
            layoutContent.style.paddingLeft = '245px'; // Adjust padding when sidebar is expanded
            layoutHeader.style.paddingLeft = '255px'; // Adjust padding when sidebar is expanded
        }
        updateToggleRotation(); // Update rotation after toggling
    });

    // Remove submenu functionality (submenus won't toggle anymore)
    sidebarDropdownLinks.forEach(link => {
        link.removeEventListener('click', function () { });
    });

    // Adjust layout padding and rotation based on the initial state
    if (pageWrapper.classList.contains('toggled')) {
        layoutContent.style.paddingLeft = '245px';
        layoutHeader.style.paddingLeft = '255px';
    } else {
        layoutContent.style.paddingLeft = '80px';
        layoutHeader.style.paddingLeft = '80px';
    }
    updateToggleRotation(); // Ensure correct rotation on page load
});

