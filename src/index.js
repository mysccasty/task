
    function sortRequest(url){
        const paramsString = document.location.search;
        const searchParams = new URLSearchParams(paramsString);
        const urlParams = new URLSearchParams(url);

        if (urlParams.get("sortedBy") === searchParams.get("sortedBy") && searchParams.get("order") !== "1"){
            urlParams.set('order','1');
        }
        else {
            urlParams.delete('page');
            urlParams.delete('order');
        }
        window.location.search = urlParams;
    }
    function pagination(page, mode){
        const url = document.location.search;
        const urlParams = new URLSearchParams(url);
        if (mode==="next"){
            urlParams.set('page', Number(page)+1);
        }
        else {
            urlParams.set('page', Number(page)-1);
        }
        window.location.search = urlParams;
    }
    function showtable() {
        const table = document.getElementById("hidetable");
        const showButton = document.getElementById("hide");
        if (table.style.display === "none") {
            table.style.display = "";
            showButton.value = "Скрыть таблицу";
        } else {
        table.style.display = "none";
        showButton.value = "Показать таблицу";
    }
}