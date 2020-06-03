function menu_mobile() {
    var elem_menu = document.getElementsByClassName('menu__list')[0];

    if (elem_menu.style.display === 'flex') {
        elem_menu.style.display = 'none';
    } else {
        elem_menu.style.display = 'flex';
    }
}

function menu_scroll() {
    let menu_links = document.querySelectorAll(".menu__link");

    window.addEventListener("scroll", event => {
        let from_top = window.scrollY - 50;

        menu_links.forEach(link => {
            if (link.hash) {
                let section = document.querySelector(link.hash);

                if (section.offsetTop <= from_top + 55 && section.offsetTop + section.offsetHeight > from_top + 55) {
                    link.classList.add("menu__link--active");
                } else {
                    link.classList.remove("menu__link--active");
                }
            }
        });
    });
}