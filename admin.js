console.log("Hello admin");

let chBtn = document.getElementById("change");
let dlBtn = document.getElementById("delete");

let id = document.getElementById("id");

chBtn.onclick = function() {
    window.location.href = 'adminChange.php?id='+id.value;
};

dlBtn.onclick = function() {
    window.location.href = 'adminDelete.php?id='+id.value;
};
