$(function(){
function login()
{
    $("#login").click(function(){
        let name = $("input[name='loginUsername']").val();
        let pwd = $("input[name='loginPassword']").val();
        // alert(name + pwd);
        $.post("./php/index.php",{
            "flag": "login",
            "name": name,
            "pwd": pwd
        }, function(data){
            if(data["res"] == 200)
            {
                window.location.href = "./index.html";
            }
            else if(data["res"] == 500)
            {
                $("#show").show(500);
            }   
        }, "json");
    });
}
login();
})