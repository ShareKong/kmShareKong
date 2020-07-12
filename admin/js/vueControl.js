$(function(){
// 初始化
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
                        // $(".km-jquery-transtionToggle").slideToggle(500);
                        // alert(isAddsShow);
                    } 
                }                
            }
        }
    });
}
// 获取员工列表
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
// 头部导航
function head() { 
    // 修改密码按钮效果
    $("#modigyPwdBtnStart").click(function () { 
        // alert(1);
        $("#modigyPwd").slideToggle(500);
    });
    // 退出登陆
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
//  功能选项效果
function leftFuns()
{
    let lFuns = $(".km-side-function ul.nav li");
    let conts = $(".km-content .km-cont");
    lFuns.each(function(){
        $(this).click(function(){
            console.log($(this).index());
            conts.hide(500);
            conts.eq($(this).index()).show(500);
        });
    });
    // alert(lFuns.length);
}
// 获取菜品列表
function getMenus()
{
    $.post("./php/index.php",{
        "flag": "getMenus"
    }, function(data){
        if(data["status"] == 200)
        {
            let tMenusDe = data["res"];
            let tMenusCa = data["res1"];
            let temp = "";
            for(let i = 0; i < tMenusDe.length; i++)
            {
                temp += '<tr><td>'+tMenusDe[i][0]+'</td><td><img src="'+tMenusDe[i][3]+'" alt=""></td><td>'+tMenusDe[i][1]+'</td><td>'+tMenusDe[i][2]+'</td><td>';
                for(let j = 0; j < tMenusCa.length; j++)
                {
                    if(Number(tMenusCa[j][0]) > tMenusDe[i][0])
                    {
                        break;
                    }
                    else if(Number(tMenusCa[j][0]) == tMenusDe[i][0])
                    {
                        temp += '<span class="badge badge-pill badge-success">'+tMenusCa[j][1]+'</span>';
                    }
                }
                temp += '</td><td>'+tMenusDe[i][4]+'</td><td><button class="btn btn-danger btn-sm">移除</button></td></tr>';
            }
            $(".km-dishes tbody").html(temp);
            // 菜品总数
            $("#menuTotal").text(tMenusDe.length);
        }
        else if(data["status"] == 500)
        {
            console.log("获取菜品列表失败");
        }
    }, "json");
}
// 菜品管理效果
function menuEff()
{
    $("#addMenu").click(function(){
        console.log("addMenu");
        $("#addMenuS").slideToggle(500);
    });
}
// 获取菜品分类列表
function getMenuCate()
{
    $.post("./php/index.php",{
        "flag" : "getMenuCate"
    }, function(data){
        if(data["status"] == 200)
        {
            const r = data["res"];
            let temp = "";
            for(let i = 0; i < r.length; i++)
            {
                temp += '<tr><td>'+r[i][0]+'</td><td>'+r[i][1]+'</td><td><button class="btn btn-danger btn-sm">移除</button></td></tr>';
            }
            $("#menuCate tbody").html(temp);
            // 显示分类列表总数
            $("#menuCategoryTotal").text(r.length);
            deleteMenuCate();
        }
        else if(data["status"] == 500)
        {
            console.log("获取菜品分类列表失败");
        }
    }, "json");
}
// 添加菜品分类
function addMenuCate()
{
    $("#addMenuCate").click(function(){
        let menuCateName = $("#addMenuCateName").val();
        $.post("./php/index.php", {
            "flag" : "addMenuCate",
            "data" : menuCateName
        }, function(data){
            if(data["status"] == 200)
            {
                alert("添加分类列表成功");
                $("#addMenuCateName").val("");
                getMenuCate();
            }
            else
            {
                alert("添加分类列表失败");
            }
        }, "json");
        // console.log(menuCateName);
    });
}
// 删除菜品分类
function deleteMenuCate()
{
    const menuCateList = $("#menuCate tbody tr td button");
    menuCateList.click(function(){
        let cateID = $(this).parents("tr").find("td:first-child").text();
        $.post("./php/index.php", {
            "flag" : "deleteMenuCate",
            "data" : cateID
        }, function(data){
            if(data["status"] == 200)
            {
                alert("已删除编号为" + cateID + "的分类");
                getMenuCate();
            }
            else
            {
                alert("删除分类失败");
            }
        }, "json");
        // console.log(cateID);
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
    leftFuns(); 
    getMenus();
    menuEff();
    getMenuCate();
    addMenuCate();
}
all();

})