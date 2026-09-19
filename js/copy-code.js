function fallbackCopy(text) {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.setAttribute("readonly", "");
    textArea.style.position = "fixed";
    textArea.style.opacity = "0";
    document.body.appendChild(textArea);
    textArea.select();

    const copied = document.execCommand("copy");
    textArea.remove();

    if (!copied) {
        throw new Error("The browser rejected the copy command.");
    }
}

async function copyText(text) {
    if (navigator.clipboard && window.isSecureContext) {
        await navigator.clipboard.writeText(text);
        return;
    }

    fallbackCopy(text);
}

document.querySelectorAll("pre > code").forEach((code) => {
    const pre = code.parentElement;
    const button = document.createElement("button");
    let resetTimer;

    pre.classList.add("code-snippet");
    button.className = "copy-code-button";
    button.type = "button";
    button.textContent = "Copy";
    button.setAttribute("aria-label", "Copy code to clipboard");

    button.addEventListener("click", async () => {
        window.clearTimeout(resetTimer);

        try {
            await copyText(code.textContent);
            button.textContent = "Copy";
            button.dataset.state = "copied";
        } catch (error) {
            button.textContent = "Error";
            button.dataset.state = "error";
            console.error("Unable to copy code to the clipboard.", error);
        }

        resetTimer = window.setTimeout(() => {
            button.textContent = "Copy";
            delete button.dataset.state;
        }, 2000);
    });

    pre.appendChild(button);
});
