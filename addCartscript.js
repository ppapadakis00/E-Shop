$(document).ready(function(){
    $(document).click(function(event){
        var productID = $(event.target);
        if(productID.hasClass("AddCartButton")==true){
            productID=$(event.target).val();
        }else{
            return;
        }
        $.post("addCart.php",{
            PrID: productID
        },function(data,status){
            $("#CartResult").html(data);
        });
    });
});