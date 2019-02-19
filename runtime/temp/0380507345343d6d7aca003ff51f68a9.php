<?php /*a:1:{s:55:"D:\Timount\mall\application\order\view\order\index.html";i:1550130035;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <!-- 下面是定义标签库 -->
    <!-- 下面是定义通用的meta头信息 -->
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <!-- 下面是定义通用的变量信息 -->
    <link rel="stylesheet" type="text/css" href="/static/layuiadmin/layui/css/layui.css" /><link rel="stylesheet" type="text/css" href="/static/layuiadmin/style/admin.css" />
    <title></title>
</head>
<body>



<div class="layui-fluid">
    <div class="layui-card">

        <div class="layui-tab" lay-filter="demo">
            <ul class="layui-tab-title">
                <li class="layui-this">新老用户占比</li>
                <li>男女用户占比</li>
                <li>订单管理</li>
                <li>订单管理2</li>
                <li>订单管理3</li>
            </ul>
            <div class="layui-tab-content">

                <div class="layui-tab-item layui-show">
                    <!--内容1-->
                    <div class="layui-card-header layuiadmin-card-header-auto">
                        <form class="layui-form" id="search-form">
                            <div class="layui-form-item">
                                <div class="layui-inline">
                                    <div style="float: left">
                                        <div class="layui-inline">
                                            <input type="dateTime" class="layui-input" id="test1" autocomplete="off" placeholder="请选择日期范围" style="width: 300px;">
                                        </div>
                                    </div>
                                    <div class="layui-inline">
                                        <div style="float: left">
                                            <a class="layui-btn layui-btn-sm">媒体切换</a>
                                        </div>
                                        <div class="layui-inline" style="float: left;width: 120px;">
                                            <select name="media_id" class="select" lay-verify="require" lay-vertype="tips" lay-filter="mediaChoose">
                                                <?php if(is_array($media) || $media instanceof \think\Collection || $media instanceof \think\Paginator): $i = 0; $__LIST__ = $media;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                                                <option value="<?php echo htmlentities($v['media_ident']); ?>"><?php echo htmlentities($v['media_title']); ?></option>
                                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <button class="layui-btn layui-btn-sm" id="search_1" data-type="reload">搜索</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- datatables页 -->
                    <div id="demo_1" class="layui-card-body" style="width: 800px;height: 600px">
                        <!-- <table class="layui-table" id="list" lay-filter="list"></table>-->
                    </div>

                </div>

                <div class="layui-tab-item">
                    <!--内容2-->
                    <div class="layui-card-header layuiadmin-card-header-auto">
                        <form class="layui-form" id="search-form">
                            <div class="layui-form-item">
                                <div class="layui-inline">
                                    <div style="float: left">
                                        <div class="layui-inline">
                                            <input type="dateTime" class="layui-input" id="test2" autocomplete="off" placeholder="请选择日期范围" style="width: 300px;">
                                        </div>
                                    </div>
                                    <div class="layui-inline">
                                        <div style="float: left">
                                            <a class="layui-btn layui-btn-sm">媒体切换</a>
                                        </div>
                                        <div class="layui-inline" style="float: left;width: 120px;">
                                            <select name="media_id" class="select" lay-verify="require" lay-vertype="tips" lay-filter="mediaChoose">
                                                <?php if(is_array($media) || $media instanceof \think\Collection || $media instanceof \think\Paginator): $i = 0; $__LIST__ = $media;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                                                <option value="<?php echo htmlentities($v['media_ident']); ?>"><?php echo htmlentities($v['media_title']); ?></option>
                                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <button class="layui-btn layui-btn-sm" id="search_2" data-type="reload">搜索</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- datatables页 -->
                    <div id="demo_3" class="layui-card-body" style="width: 800px;height: 600px">
                       <!-- <table class="layui-table" id="list" lay-filter="list"></table>-->
                    </div>

                </div>

                <div class="layui-tab-item">
                    内容3
                </div>

                <div class="layui-tab-item">
                    内容31
                </div>

                <div class="layui-tab-item">
                    内容32
                </div>

            </div>
        </div>

    </div>
</div>
<script type="text/javascript" src="/static/layuiadmin/layui/layui.js"></script><script type="text/javascript" src="/static/js/tools.js"></script><script type="text/javascript" src="/static/js/echarts.js"></script>
<script>
    var tableIn;
    layui.use(['table','form','laydate','element'], function() {
        var table = layui.table,form = layui.form,$ = layui.jquery,laydate = layui.laydate, element = layui.element;

        var media_id = $(".select").val();
        var time_1 = $("#test1").val();
        var time_2 = $("#test2").val();

        //一些事件监听
        element.on('tab(demo)', function(data){
            // console.log(data.index,'index');
        });
        /**************start**************/
        //下拉切换
        form.on('select(mediaChoose)', function(data){
            media_id = data.value;
        });

       //时间
        laydate.render({
            elem: '#test1'
            ,type: 'datetime'
            ,range: '/' //或 range: '~' 来自定义分割字符
            ,max:0
        });

        laydate.render({
            elem: '#test2'
            ,type: 'datetime'
            ,range: '/' //或 range: '~' 来自定义分割字符
            ,max:0
        });
        /*****************end*****************/

        /***************newSTART**************/
        //新老用户占比
        var myChart_1 = echarts.init(document.getElementById('demo_1'));
        var action_1 = "index";
        getData(time_1,media_id,myChart_1,1,action_1);
        //男女用户占比
        var myChart_2 = echarts.init(document.getElementById('demo_3'));
        var action_2 = 'sexChoose';
        getData(time_2,media_id,myChart_2,2,action_2);

        //查询操作
        $("#search_1").on('click',function(){
            time_1 = $("#test1").val();
            if (time_1.length > 0){
                var arr = time_1.split('/');  //转数组
                var start = arr[0].replace(/^\s+|\s+$/g,"");  //去空格 首尾
                var end   = arr[1].replace(/^\s+|\s+$/g,"");
                var startTime = (new Date(start)).getTime()/1000;  // 日期时间格式转换
                var endTime   = (new Date(end)).getTime()/1000;
                var number = (endTime - startTime)/86400;
                if (number > 30){
                    layer.msg('时间区间为一个月！', {icon: 0});
                    return false;
                }
                getData(time_1,media_id,myChart_1,1);
                return false;
            }
            return false;
        });

        $('#search_2').on('click', function () {
            var time_2 = $("#test2").val();
            if (time_2.length > 0){
                var arr = time_2.split('/');  //转数组
                var start = arr[0].replace(/^\s+|\s+$/g,"");  //去空格 首尾
                var end   = arr[1].replace(/^\s+|\s+$/g,"");
                var startTime = (new Date(start)).getTime()/1000;  // 日期时间格式转换
                var endTime   = (new Date(end)).getTime()/1000;
                var number = (endTime - startTime)/86400;
                if (number > 30){
                    layer.msg('时间区间为一个月！', {icon: 0});
                    return false;
                }
                getData(time_2,media_id,myChart_2,2);
                return false;
            }
            return false;
        });

        function getData(time,media_id,myChart,type,action){
            $.ajax({
                url:action,
                method:'get',
                data:{time:time,media_id:media_id},
                beforeSend: function () {
                    // $(".login-img").html("<img src='__STATIC__/admin/images/data/login.gif'>");
                },
                success: function (res) {
                    // var list = JSON.parse(res);
                    myChart.hideLoading();    //隐藏加载动画
                    if (type == 1){
                        var option = {
                            title : {
                                text: '电商访问新老用户占比',
                                // subtext: '纯属虚构',
                                x:'center'
                            },
                            tooltip : {
                                trigger: 'item',
                                formatter: "{a} <br/>{b} : {c} ({d}%)"
                            },
                            legend: {
                                orient: 'vertical',
                                left: 'left',
                                data: ['新用户','老用户']
                            },
                            series : [
                                {
                                    name: '数据来源',
                                    type: 'pie',
                                    radius : '55%',
                                    center: ['50%', '60%'],
                                    data:[
                                        {value:res.data.men, name:'新用户'},
                                        {value:res.data.women, name:'老用户'}
                                    ],
                                    itemStyle: {
                                        emphasis: {
                                            shadowBlur: 10,
                                            shadowOffsetX: 0,
                                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                                        }
                                    }
                                }
                            ]
                        };
                    } else {
                        var option = {
                            title : {
                                text: '电商访问男女用户占比',
                                // subtext: '纯属虚构',
                                x:'center'
                            },
                            tooltip : {
                                trigger: 'item',
                                formatter: "{a} <br/>{b} : {c} ({d}%)"
                            },
                            legend: {
                                orient: 'vertical',
                                left: 'left',
                                data: ['男性用户','女性用户']
                            },
                            series : [
                                {
                                    name: '数据来源',
                                    type: 'pie',
                                    radius : '55%',
                                    center: ['50%', '60%'],
                                    data:[
                                        {value:res.data.men, name:'男性用户'},
                                        {value:res.data.women, name:'女性用户'}
                                    ],
                                    itemStyle: {
                                        emphasis: {
                                            shadowBlur: 10,
                                            shadowOffsetX: 0,
                                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                                        }
                                    }
                                }
                            ]
                        };
                    }
                    myChart.setOption(option)
                },
                error: function (data, type, err) {
                    // $(".login-img").html("");
                },
                complete: function () {
                    // $(".login-img").html("");
                }
            })
        }

        //其他数据

        console.log(action_1,action_2,'action');


        /***************newEND****************/


    })
</script>
</body>
</html>