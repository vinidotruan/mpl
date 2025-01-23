import { Modal } from "bootstrap";
window.dragOverHandler = function (ev) {
    ev.preventDefault();
}

window.dropHandler = function (ev) {
    ev.preventDefault();
    openModal(ev.dataTransfer.items)
}

function openModal(files) {
    const myModal = new Modal(document.getElementById('nameModal'))
    myModal.show();
    const button = document.getElementById("upload");
    button.onclick = function() {
        myModal.toggle();
        uploadFile(files);
    }
}

function showLoader() {
    const loader = new Modal(document.getElementById('loaderModal'))
    loader.toggle();
}

function uploadFile(files) {
    const name = document.getElementById("name").value;
    // showLoader()
    if (files) {
        [...files].forEach((item, _) => {
          if (item.kind === "file") {
            const file = item.getAsFile();
            const data = new FormData();
            data.append("file", file);
            data.append("name", name);
            axios.post("/api/books/upload", data)
                .then(_ => {
                    window.location.reload()
                })
                .catch(({response}) => {
                    console.log(response.data.message)
                });
          }
        });
    }

}
