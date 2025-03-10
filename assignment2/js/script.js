function toggleMenu() {
    const nav = document.getElementById("nav-links");
    const burger = document.getElementById("burger-menu");

    // Toggle menu visibility
    nav.classList.toggle("nav-active");
    burger.classList.toggle("open");
}
