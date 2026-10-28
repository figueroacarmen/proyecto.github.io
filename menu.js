const loader = document.querySelector("#page-loader");
const minimumDisplayTime = 1250;

loader.hidden = true;
loader.setAttribute("aria-hidden", "true");

document.querySelectorAll(".pagina-inicio .opcion[href]").forEach((link) => {
    link.addEventListener("click", (clickEvent) => {
        if (
            clickEvent.button !== 0 ||
            clickEvent.metaKey ||
            clickEvent.ctrlKey ||
            clickEvent.shiftKey ||
            clickEvent.altKey
        ) {
            return;
        }

        if (link.target === "_blank" || link.origin !== window.location.origin) {
            return;
        }

        clickEvent.preventDefault();
        loader.hidden = false;
        loader.setAttribute("aria-hidden", "false");

        window.setTimeout(() => {
            window.location.assign(link.href);
        }, minimumDisplayTime);
    });
});
