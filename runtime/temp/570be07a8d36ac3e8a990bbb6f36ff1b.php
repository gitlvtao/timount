<?php /*a:1:{s:64:"D:\Timount\mall\application\userdata\view\goodsdetail\index.html";i:1549849226;}*/ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
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
        <div class="layui-card-header layuiadmin-card-header-auto">
            <form class="layui-form" id="search-form">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <div style="float: left">
                            <div class="layui-inline">
                                <input type="dateTime" class="layui-input" id="test1" autocomplete="off" placeholder="请选择日期范围" style="width: 300px;">
                            </div>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <div style="float: left">
                            <a class="layui-btn layui-btn-sm">媒体切换</a>
                        </div>
                        <div class="layui-inline" style="float: left;width: 120px;">
                            <select name="media_id" id="select" lay-verify="require" lay-vertype="tips" lay-filter="mediaChoose">
                                <?php if(is_array($media) || $media instanceof \think\Collection || $media instanceof \think\Paginator): $i = 0; $__LIST__ = $media;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo htmlentities($v['media_ident']); ?>"><?php echo htmlentities($v['media_title']); ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>
                    <button class="layui-btn layui-btn-sm" id="search" data-type="reload">搜索</button>
                    <a class="layui-btn layui-btn-sm" id="excel" data-type="reload">导出EXCEL</a>
                </div>
            </form>
        </div>
        <!-- datatables页 -->
        <div class="layui-card-body">
            <table class="layui-table" id="list" lay-filter="list"></table>
        </div>
    </div>
</div>
<script type="text/html" id="action">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script type="text/javascript" src="/static/layuiadmin/layui/layui.js"></script><script type="text/javascript" src="/static/js/tools.js"></script>
<script>
    var tableIn;
    layui.config({
        base: '/static/layuiadmin/modules/'
    }).extend({
        treetable: 'treetable-lay/treetable'
    }).use(['table','form','laydate','treetable'], function() {
        var table = layui.table,form = layui.form,$ = layui.jquery,laydate = layui.laydate;
        var treetable = layui.treetable;
        var media_id = $("#select").val();
        var dateTime = $("#test1").val();
        tableIn = function(dateTime,media_id){
            var url = '<?php echo url("index"); ?>' + "?time=" + dateTime + "&media_id=" + media_id;
            treetable.render({
                treeColIndex: 0,
                treeSpid: 0,
                treeIdName: 'id',
                treePidName: 'pid',
                elem: '#list',
                url: url,
                // limit: 20,
                height: 'full-170',
                // page:true,
                cols: [[
                    {field: 'name', title: '类型',align: 'center', width: 300,templet: '#media_balance'},
                    {field: 'PV', title: 'PV',align: 'center', width: 300,templet: '#media_balance'},
                    {field: 'UV', title: 'UV',align: 'center', width: 150,templet: '#media_balance'},
                    // {field: 'lose', title: '跳出率',align: 'center', width: 150,templet: '#media_balance'},
                    {field: 'vogTime', title: '平均停留时长',align: 'center', width: 150,templet: '#media_balance'}
                ]]
            });
        };

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

        //搜索
        $('#search').on('click', function () {
            dateTime = $("#test1").val();
            if (dateTime.length <= 0){
                layer.msg('请选择时间区间！', {icon: 0});
                return false;
            }
            var arr = dateTime.split('/');  //转数组
            var start = arr[0].replace(/^\s+|\s+$/g,"");  //去空格 首尾
            var end   = arr[1].replace(/^\s+|\s+$/g,"");
            var startTime = (new Date(start)).getTime()/1000;  // 日期时间格式转换
            var endTime   = (new Date(end)).getTime()/1000;
            var number = (endTime - startTime)/86400;
            if (number > 30){
                layer.msg('时间区间为一个月！', {icon: 0});
                return false;
            }
            tableIn(dateTime,media_id);
            return false;
        });
        tableIn(dateTime,media_id);

        //导出表格
        $("#excel").on('click',function (res) {
            dateTime = $("#test1").val();
            var url = "<?php echo url('phpExcel'); ?>?time=" + dateTime + "&media_id=" + media_id;
            $("#excel").attr("href", url);
        });
    })
</script>
</body>
</html>