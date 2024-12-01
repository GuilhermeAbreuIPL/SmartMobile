function openSidebar(sidebarId) {
    const sidebar = document.getElementById(sidebarId);
    if (sidebar) {
        sidebar.style.width = "400px";
        document.getElementById("backdrop").classList.add("active");
    }
}

function closeNavMenu() {
    document.getElementById("SidebarMenu").style.width = "0";

    const backdrop = document.getElementById("backdrop");
    backdrop.classList.remove("active");
}

function closeNavProfile() {
    document.getElementById("SidebarProfile").style.width = "0";

    const backdrop = document.getElementById("backdrop");
    backdrop.classList.remove("active");
}

function closeNavCart() {
    document.getElementById("SidebarCart").style.width = "0";

    const backdrop = document.getElementById("backdrop");
    backdrop.classList.remove("active");
}
