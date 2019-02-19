<?php /*a:1:{s:55:"D:\Timount\mall\application\media\view\media\index.html";i:1547083636;}*/ ?>
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
        <div class="layui-card-header layuiadmin-card-header-auto">
            <form class="layui-form" id="search-form">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <div style="float: left">
                            <div class="layui-inline">
                                <input class="layui-input" name="key" id="key"  autocomplete="off" placeholder="请输入媒体名称" style="width: 400px">
                            </div>
                            <button class="layui-btn layui-btn-sm" id="search" data-type="reload">搜索</button>
                            <button type="reset" class="layui-btn layui-btn-sm layui-btn-primary" lay-submit lay-filter="layui-datatables-reset">重置</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- datatables页 -->
        <div class="layui-card-body">
            <div style="padding-bottom: 10px;">
                <a id="addMedia" class="layui-btn layui-btn-normal" style="float:left;"><i class="fa fa-plus" aria-hidden="true"></i>添加媒体</a>
                <a href="<?php echo url('index'); ?>" class="layui-btn">显示全部</a>
            </div>
            <table class="layui-table" id="list" lay-filter="list"></table>
        </div>
    </div>
</div>
<script type="text/html" id="sort">
    <input name="{{d.column_id}}" data-id="{{d.column_id}}" class="list_order layui-input" value=" {{d.column_sort}}" size="10"/>
</script>
<script type="text/html" id="media_getUrl">
    <a href="{{d.media_getUrl}}" target="_blank">{{d.media_getUrl}}</a>
</script>
<script type="text/html" id="action">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script type="text/javascript" src="/static/layuiadmin/layui/layui.js"></script><script type="text/javascript" src="/static/js/tools.js"></script>
<script>
    var tableIn;
    layui.use(['table','form'], function() {
        var table = layui.table,form = layui.form,$ = layui.jquery;
        tableIn = table.render({
            id: 'ad',
            elem: '#list',
            url: '<?php echo url("index"); ?>',
            method: 'post',
            limit: 20,
            height: 'full-170',
            page:true,
            cols: [[
                {field: 'media_title', title: '媒体名称',align: 'center', minWidth: 150,templet: '#media_balance'},
                {field: 'media_ident', title: '媒体标识',align: 'center', width: 120,templet: '#media_balance'},
                {field: 'media_getUrl', title: '媒体链接',align: 'center', minWidth: 200,templet: '#media_getUrl'},
                {field: 'media_pid', title: '媒体淘宝联盟推广位PID',align: 'center', width: 300,templet: '#media_balance'},
                {field: 'media_divided_into', title: '媒体分成比率',align: 'center', width: 150,templet: '#media_balance'},
                {field: 'media_service_fee', title: '技术服务费比率',align: 'center', width: 150,templet: '#media_balance'},
                {field: 'media_create_time', title: '媒体创建时间',align: 'center', width: 160,templet: '#media_balance'},
                {width: 150,title: '操作', align: 'center', toolbar: '#action',fixed:'right'}
            ]]
        });

        //搜索
        $('#search').on('click', function () {
            var key = $('#key').val();
            if ($.trim(key) === '') {
                layer.msg('请输入关键字！', {icon: 0});
                return;
            }
            tableIn.reload({
                where: {key: key}
                ,page: {
                    curr: 1 //重新从第 1 页开始
                }
            });
        });

        //添加
        $("#addMedia").on('click',function(){
            layer.open({
                type: 2,
                title: '新增栏目',
                content: '<?php echo url("add"); ?>',
                area: ['100%','100%'], //计算页面大小
            })
        });

        table.on('tool(list)', function(obj) {
            var data = obj.data;
            if (obj.event === 'del'){
                layer.confirm('您确定要删除该媒体吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('del'); ?>",{id:data.media_id},function(res){
                        layer.close(loading);
                        if(res.code===1){
                            layer.msg(res.msg,{time:1000,icon:1});
                            tableIn.reload();
                        }else{
                            layer.msg('操作失败！',{time:1000,icon:2});
                        }
                    });
                    layer.close(index);
                });
            }else if(obj.event === 'edit'){
                layer.open({
                    type: 2,
                    title: '新增媒体',
                    content: '<?php echo url("edit"); ?>?id='+ data.media_id,
                    area: ['100%','100%'], //计算页面大小
                })
            }
        });

        $('body').on('blur','.list_order',function() {
            var column_id = $(this).attr('data-id');
            var sort = $(this).val();
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            $.post('<?php echo url("sort"); ?>',{column_id:column_id,column_sort:sort},function(res){
                layer.close(loading);
                if(res.code === 1){
                    layer.msg(res.msg, {time: 1000, icon: 1});
                    tableIn.reload();
                }else{
                    layer.msg(res.msg,{time:1000,icon:2});
                }
            })
        });

        /*$('#delAll').click(function(){
            layer.confirm('确认要删除选中的广告吗？', {icon: 3}, function(index) {
                layer.close(index);
                var checkStatus = table.checkStatus('ad'); //test即为参数id设定的值
                var ids = [];
                $(checkStatus.data).each(function (i, o) {
                    ids.push(o.ad_id);
                });
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.post("<?php echo url('delall'); ?>", {ids: ids}, function (data) {
                    layer.close(loading);
                    if (data.code === 1) {
                        layer.msg(data.msg, {time: 1000, icon: 1});
                        tableIn.reload();
                    } else {
                        layer.msg(data.msg, {time: 1000, icon: 2});
                    }
                });
            });
        })*/
    })
</script>
</body>
</html>