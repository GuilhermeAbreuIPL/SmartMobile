function openSidebar(sidebarId) {
    const sidebar = document.getElementById(sidebarId);
    if (sidebar) {
        sidebar.style.width = "400px";
        document.getElementById("backdrop").classList.add("active");
    }
}

function closeAllSidebars(sidebarId) {
    const sidebar = document.getElementById(sidebarId);
    if (sidebar) {
        sidebar.style.width = "0";
        document.getElementById("backdrop").classList.remove("active");
    }
}

