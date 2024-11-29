// SideBar Menu
function openNavMenu() {
    document.getElementById("SidebarMenu").style.width = "400px";

    const backdrop = document.getElementById("backdrop");
    backdrop.classList.add("active");
}

function closeNavMenu() {
    document.getElementById("SidebarMenu").style.width = "0";

    const backdrop = document.getElementById("backdrop");
    backdrop.classList.remove("active");
}

// Sidebar Profile
function openNavProfile() {
    document.getElementById("SidebarProfile").style.width = "400px";

    const backdrop = document.getElementById("backdrop");
    backdrop.classList.add("active");
}

function closeNavProfile() {
    document.getElementById("SidebarProfile").style.width = "0";

    const backdrop = document.getElementById("backdrop");
    backdrop.classList.remove("active");
}

// Sidebar Profile
function openNavCart() {
    document.getElementById("SidebarCart").style.width = "400px";
    
    const backdrop = document.getElementById("backdrop");
    backdrop.classList.add("active");
}

function closeNavCart() {
    document.getElementById("SidebarCart").style.width = "0";

    const backdrop = document.getElementById("backdrop");
    backdrop.classList.remove("active");
}
