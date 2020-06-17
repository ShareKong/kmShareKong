$(function(){
function init() { 
    $.post("./php/index.php",{
        "flag": "indexStart"
    },function(data){
        if(data["res"] == 200)
        {
            $("#adminName").text(data["r"]);
        }
        else if(data["res"] == 500)
        {
            window.location.href = "./login.html";
        }
    }, "json");
}
    // 设置左侧栏高度
function setSideHeight()
{
    // const bodyHeight = $("body").height();
    const windowHeight = $(window).height();
    // alert(windowHeight);
    $(".km-side").css("height", windowHeight);
    // $(window).resize(function () {
    //     const h = $("body").height();
    //     const w = $("body").width();
    //     if(w > 600)
    //     {
    //         $(".km-side").css("height", h);
    //     }
    //     else
    //     {
    //         $(".km-side").css("height", "auto");
    //     }
    //  })
}

// vue 管理
function vues()
{
    const vm = new Vue({
        el: "#all",
        data: {
        },
        components: {
            hNav: {
                template: '#h-nav',
                data() {
                    return {
                        /// 控制子组件重新加载
                        timer: '',
                        isAddsShow: false                        
                    }
                }, 
                components: {
                    // 子组件
                    adds: {
                        template: '#add',
                        data() {
                            return {
                                name: "",
                                permission: ""
                            }
                        },
                        methods: {
                            getData() {
                                datas.name = name
                            }
                        },
                    }
                },
                methods: {
                    getChild () {
                        let name = this.$refs.adds.name;
                        let permission = this.$refs.adds.permission;
                        // alert(name + ":" + permission);
                        this.addEmplo(name, permission);
                        getEmplos();
                    },
                    addEmplo (name, permission) {
                        if($.trim(name) == '' || $.trim(name) == null || $.trim(permission) == '' || $.trim(permission) == null)
                        {
                            alert("请填写姓名和权限");
                        }
                        else
                        {
                            $.post("./php/index.php", {
                                "flag": "addEmplo",
                                "name": name,
                                "permission": permission
                            }, function(res){
                                if(res["res"] == 200)
                                {
                                    alert("添加成功");
                                }
                                else
                                {
                                    alert("添加失败");
                                }
                            }, "json");
                        }
                        this.timer = new Date().getTime();
                    },
                    changeAddsShow () {
                        this.isAddsShow = !this.isAddsShow;
                        // alert(isAddsShow);
                    } 
                }                
            }
        }
    });
}
// 
function getEmplos() {
    $.post("./php/index.php",{
        "flag": "getEmplos"
    },function(data){
        const emps = data.r;
        /// 在职员工
        $("#stallEmplo").text(emps.length);
        let temp = "";
        for(let key = 0; key < emps.length; key++)
        {
            let t_per = "";
            if(emps[key][3] == "km-1")
            {
                t_per = "管理员";
            }
            else if(emps[key][3] == "km-2")
            {
                t_per = "厨房人员";
            }
            else if(emps[key][3] == "km-3")
            {
                t_per = "服务人员";
            }
            temp += "<tr><td>"+(key + 1)+"</td><td>"+emps[key][0]+"</td><td>"+emps[key][1]+"</td><td>"+emps[key][2]+"</td><td>"+t_per+"</td><td><button class='btn btn-danger btn-sm' id='del'>删除</button><button class='btn btn-primary btn-sm ml-2'>详情</button></td></tr>";
        }
        $(".emps table tbody").html(temp);
        /// 删除
        $(".emps table tbody tr button[id='del']").click(function(){
            let td = $(this).parents("tr").find("td");
            deletEmplo(td.eq(2).text())
            // alert(td.eq(2).text());
        });
    }, "json");
}
// 删除员工
function deletEmplo(aount)
{
    $.post("./php/index.php",{
        "flag": "delEmploId",
        "aountId": aount
    },function(data){
        if(data["res"] == 200)
        {
            alert("删除成功");
            getEmplos();
        }
        else
        {
            alert("删除失败");
        }
    }, "json");
}
// 修改密码
function modifyPwdBtn()
{
    $("#modifyPwdBtn").click(function(){
        // alert("modifyPwdBtn");
        let pwd = $(this).parent().find("input");
        let p1 = pwd.eq(0).val();
        let p2 = pwd.eq(1).val();
        let p3 = pwd.eq(2).val();
        if($.trim(p1) == '' || $.trim(p2) == '' || $.trim(p3) == '')
        {
            alert("请填写所有字段");
        }
        else if(p2.length < 8)
        {
            alert("新密码长度不能小于 8");
        }
        else if(p2 != p3)
        {
            alert("两次输入密码不一致，请重新输入");
            pwd.eq(1).val('');
            pwd.eq(2).val('');
            pwd.eq(1).focus;
        }
        else
        {
            $.post("./php/index.php",{
                "flag": "modifyPwd",
                "pwd": p1,
                "pwd1": p2
            },function(data){
                if(data["res"] == 200)
                {
                    alert("密码修改成功");
                    pwd.eq(0).val('');
                    pwd.eq(1).val('');
                    pwd.eq(2).val('');
                    $("#modigyPwd").hide(500);
                }
                else if(data["res"] == 808)
                {
                    alert("您还没有登录，请登录。。。");
                    window.location.href = "./login.html";
                }
                else if(data["res"] == 500)
                {
                    alert("旧密码不正确");
                }
            }, "json");
        }
    });
}
// 
function head() { 
    $("#modigyPwdBtnStart").click(function () { 
        // alert(1);
        $("#modigyPwd").show(500);
    });
    $("#loginOut").click(function () {
        $.post("./php/index.php",{
            "flag": "loginOut"
        },function(data){
            if(data["res"] == 200)
            {
                window.location.href = "./login.html";
            }
            else
            {
                alert("系统错误，退出失败");
            }
        }, "json");
    });

 }
// 
function all()
{
    init();
    vues();
    getEmplos();
    setSideHeight();
    modifyPwdBtn();
    head();
}
all();

})