let fields = (document.getElementsByClassName("Fields")).item(0);
let addButton = (document.getElementsByClassName("AddField")).item(0);

addButton.addEventListener("click" , ()=> {
    let newDiv = document.createElement("div");
    newDiv.classList.add("field");
    newDiv.innerHTML = '<input class="form-control inputFields" type="text" name="InfoOne[]" placeholder="Info One"><br><input class="form-control inputFields" type="text" name="InfoTwo[]" placeholder="Info Two"><br>';
    fields.appendChild(newDiv);
});
