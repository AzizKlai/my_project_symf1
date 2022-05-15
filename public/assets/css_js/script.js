const tr = document.querySelectorAll("tr");

tr.forEach(el=>el.addEventListener("click", function(e) {
    el.classList.toggle('highlight')}));