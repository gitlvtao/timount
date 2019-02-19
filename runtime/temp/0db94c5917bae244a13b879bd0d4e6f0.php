<?php /*a:1:{s:55:"D:\Timount\mall\application\goods\view\goods\index.html";i:1547689432;}*/ ?>
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
                                <input class="layui-input" name="key" id="key"  autocomplete="off" placeholder="请输入商品名称" style="width: 400px">
                            </div>
                            <button class="layui-btn layui-btn-sm" id="search" data-type="reload">搜索</button>
                            <button type="reset" class="layui-btn layui-btn-sm layui-btn-primary" lay-submit lay-filter="layui-datatables-reset">重置</button>
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
        <div class="layui-btn-table">
            <a href="#" id="add" class="layui-btn layui-btn-sm layui-btn-normal" style="float:left;"><i class="fa fa-plus" aria-hidden="true"></i>添加商品</a>
            <a href="<?php echo url('index'); ?>" class="layui-btn layui-btn-sm">显示全部</a>
            <table class="layui-table" id="list" lay-filter="list"></table>
        </div>
    </div>
</div>
<script type="text/html" id="sort">
    <input name="{{d.column_id}}" data-id="{{d.column_id}}" class="list_order layui-input" value=" {{d.column_sort}}" size="10"/>
</script>
<script type="text/html" id="goods_pic">
    <img src="{{d.pic}}">
</script>
<script type="text/html" id="action">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    {{#  if(d.status == 1){ }}
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">下架</a>
    {{#  } else { }}
        <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="del">上架</a>
    {{#  } }}

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
            page:true,
            limit: 20,
            height: 'full-170',
            cols: [[
                {field: 'd_title', title: '商品名称',align: 'center', minWidth: 320,templet: '#media_name',fixed:'left'},
                {field: 'pic', title: '商品图片',align: 'center', width: 150,templet: '#goods_pic'},
                {field: 'quan_surplus', title: '剩余优惠券',align: 'center', width: 100,templet: '#media_name'},
                {field: 'quan_receive', title: '已领取优惠券',align: 'center', width: 120,templet: '#media_name'},
                {field: 'quan_price', title: '券额度(元)',align: 'center', width: 120,templet: '#media_name'},
                {field: 'price', title: '券后价(元)',align: 'center', width: 120,templet: '#media_name'},
                {field: 'sales_num', title: '商品销量',align: 'center', width: 100,templet: '#media_name'},
                {field: 'commission_jihua', title: '佣金比例(%)',align: 'center', width: 120,templet: '#media_name'},
                {field: 'quan_time', title: '优惠券有效期',align: 'center', width: 160,templet: '#media_identi'},
                {field: 'create_time', title: '商品更新时间',align: 'center', width: 180,templet: '#media_name'},
                {width: 120,title: '操作', align: 'center', toolbar: '#action',fixed:'right'}
            ]],
            done:function(res,curr,count){
                hoverOpenImg();//显示大图
                $('table tr').on('click',function(){
                    $('table tr').css('background','');
                    $(this).css('background','<%=PropKit.use("config.properties").get("table_color")%>');
                });
            }
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
            return false;
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
            return false;
        });

        //新增
        $("#add").on('click',function(){
            layer.open({
                type: 2,
                title: '新增商品',
                content: '<?php echo url("add"); ?>',
                area: ['100%','100%'], //计算页面大小
            })
        });

        table.on('tool(list)', function(obj) {
            var data = obj.data;
            if (obj.event === 'del'){
                layer.confirm('您确定要操作该商品吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('del'); ?>",{id:data.goods_id,type:data.status},function(res){
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
                    title: '编辑商品',
                    content: '<?php echo url("edit"); ?>?id='+ data.goods_id,
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

        function hoverOpenImg(){
            var img_show = null; // tips提示
            $('td img').hover(function(){
                //alert($(this).attr('src'));
                var img = "<img class='img_msg' src='"+$(this).attr('src')+"' style='width:300px;' />";
                img_show = layer.tips(img, this,{
                    tips:[1, 'rgba(41,41,41,.5)']
                    ,area: ['330px']
                });
            },function(){
                layer.close(img_show);
            });
            $('td img').attr('style','max-width:70px');
        }
    })
</script>
</body>
</html>