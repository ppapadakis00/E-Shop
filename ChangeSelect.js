function selectOpt(){
    var d=document.getElementById("headercategory");
    var displaytext = d.options[d.selectedIndex].text;
    document.getElementById("Pname").value=displaytext;
}