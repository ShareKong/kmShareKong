$(function(){
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
            emplo: {
                template: '#emplo',
                data() {
                    return {
                        }
                    }
            },
            hNav: {
                template: '#h-nav',
                data() {
                    return {
                        /// 控制子组件重新加载
                        timer: ''
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
                    }   
                }
            }
        }
    });
}

function all()
{
    vues();
    setSideHeight();
}
all();

})