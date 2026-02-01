console.log('📌 layout.js loaded');

document.addEventListener('DOMContentLoaded', function() {
    console.log('✓ DOMContentLoaded fired');
    
    const sidebar = document.getElementById('sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    
    console.log('sidebar:', sidebar ? '✓' : '✗');
    console.log('overlay:', overlay ? '✓' : '✗');
    
    if (!sidebar) {
        console.error('❌ sidebar not found');
        return;
    }

    window.toggleDesktop = function() {
        console.log('🖥️ toggleDesktop');
        sidebar.classList.toggle('collapsed');
        document.body.classList.toggle('sidebar-collapsed');
        const isCollapsed = sidebar.classList.contains('collapsed');
        localStorage.setItem('sidebarCollapsed', isCollapsed);
    };
    
    window.toggleMobile = function() {
        console.log('📱 toggleMobile');
        sidebar.classList.toggle('show');
        if (overlay) overlay.classList.toggle('active');
    };
    
    window.closeSidebar = function() {
        console.log('🔒 closeSidebar');
        sidebar.classList.remove('show');
        if (overlay) overlay.classList.remove('active');
    };
    
    console.log('✓ Functions exposed on window');

    if (overlay) {
        document.addEventListener('click', function(e) {
            if (overlay.classList.contains('active')) {
                const clickedEl = e.target;
                
                const isOnSidebar = clickedEl.closest('#sidebar');
                const isOnHeader = clickedEl.closest('#header');
                
                if (!isOnSidebar && !isOnHeader && clickedEl.closest('.sidebar-overlay')) {
                    console.log('🎯 Clicked on overlay - closing');
                    window.closeSidebar();
                }
            }
        });
        console.log('✓ Overlay click detection attached');
    }
    
    document.addEventListener('click', function(e) {
        if (window.innerWidth < 992 && e.target.closest('.nav-link')) {
            console.log('🔗 Nav-link clicked on mobile - closing');
            window.closeSidebar();
        }
    });
    
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            console.log('📐 Resized to desktop');
            window.closeSidebar();
        }
    });
    
    const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (sidebarCollapsed && window.innerWidth >= 992) {
        console.log('🔄 Restoring collapsed state');
        sidebar.classList.add('collapsed');
        document.body.classList.add('sidebar-collapsed');
    }
    
    console.log('✅ layout.js ready');
});
