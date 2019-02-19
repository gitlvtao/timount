<?php /*a:1:{s:55:"D:\Timount\mall\application\hotword\view\hot\index.html";i:1545290389;}*/ ?>
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
                                <input class="layui-input" name="key" id="key"  autocomplete="off" placeholder="请输入热搜词名称" style="width: 400px">
                            </div>
                            <button class="layui-btn layui-btn-sm" id="search" data-type="reload">搜索</button>
                            <button type="reset" class="layui-btn layui-btn-sm layui-btn-primary" lay-submit lay-filter="layui-datatables-reset">重置</button>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <div style="float: left">
                            <button class="layui-btn layui-btn-sm">媒体切换</button>
                        </div>
                        <div class="layui-inline" style="float: left">
                            <select name="media_id" id="select" lay-verify="require" lay-vertype="tips" lay-filter="mediaChoose">
                                <?php if(is_array($media) || $media instanceof \think\Collection || $media instanceof \think\Paginator): $i = 0; $__LIST__ = $media;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo htmlentities($v['media_id']); ?>"><?php echo htmlentities($v['media_title']); ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>

                    </div>
                </div>
            </form>
        </div>
        <div class="layui-btn-table">
            <a href="#" id="add" class="layui-btn layui-btn-sm layui-btn-normal" style="float:left;"><i class="fa fa-plus" aria-hidden="true"></i>添加热搜词</a>
            <a href="<?php echo url('index'); ?>" class="layui-btn layui-btn-sm">显示全部</a>
            <table class="layui-table" id="list" lay-filter="list"></table>
        </div>
    </div>
</div>
<script type="text/html" id="sort">
    <input name="{{d.hot_id}}" data-id="{{d.hot_id}}" class="list_order layui-input" value=" {{d.hot_sort}}" size="10"/>
</script>
<script type="text/html" id="index">
    <img src="{{d.column_thumb}}">
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
        var key = '', media_id = $("#select").val();
        tableIn = table.render({
            id: 'ad',
            elem: '#list',
            url: '<?php echo url("index"); ?>',
            method: 'post',
            where:{media_id:media_id},
            page:true,
            limit: 20,
            height: 'full-170',
            cols: [[
                {field: 'hot_title', title: '热搜词名称',align: 'center', width: 160,templet: '#media_balance'},
                {field: 'hot_url', title: '热搜词链接',align: 'center', minWidth: 160,templet: '#media_balance'},
                {field: 'hot_sort', title: '排序',align: 'center', width: 100,templet: '#sort'},
                {width: 200,title: '操作', align: 'center', toolbar: '#action',fixed:'right'}
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
                where: {key: key,media_id:media_id}
                ,page: {
                    curr: 1 //重新从第 1 页开始
                }
            });
        });

        //下拉切换
        form.on('select(mediaChoose)', function(data){
            media_id = data.value;
            tableIn.reload({
                where: {key: key,media_id:media_id}
                ,page: {
                    curr: 1 //重新从第 1 页开始
                }
            });
        });

        //新增
        $("#add").on('click',function(){
            layer.open({
                type: 2,
                title: '新增热搜词',
                content: '<?php echo url("add"); ?>?media_id='+ media_id,
                area: layerArea(), //计算页面大小
            })
        });

        table.on('tool(list)', function(obj) {
            var data = obj.data;
            if (obj.event === 'del'){
                layer.confirm('您确定要删除该热搜词吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('del'); ?>",{id:data.hot_id},function(res){
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
                    title: '编辑热搜词',
                    content: '<?php echo url("edit"); ?>?id='+ data.hot_id,
                    area: layerArea(), //计算页面大小
                })
            }
        });

        $('body').on('blur','.list_order',function() {
            var hot_id = $(this).attr('data-id');
            var sort = $(this).val();
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            $.post('<?php echo url("sort"); ?>',{hot_id:hot_id,hot_sort:sort},function(res){
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