<?php /*a:1:{s:57:"D:\Timount\mall\application\goods\view\topgoods\list.html";i:1547000608;}*/ ?>
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
                        <div class="layui-inline" style="float: left">商品库：</div>
                        <div class="layui-inline" style="float: left">
                            <select name="choose" id="choose" lay-filter="choose">
                                <option value="1">自定义商品</option>
                                <option value="2">商品总表</option>
                            </select>
                        </div>
                        <div class="layui-inline" style="float: left">
                            <label class="layui-form-label">性别选择：</label>
                            <div class="layui-input-block" style="width: 100px;">
                                <select name="sex_choose" lay-filter="sexChoose" id="sexChoose">
                                    <option value="2">女</option>
                                    <option value="1">男</option>
                                </select>
                            </div>
                        </div>
                        <div style="float: left">
                            <a id="add" class="layui-btn layui-btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>商品加入top精选</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="layui-btn-table">
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
        var type=1,sex=2;
        tableIn = table.render({
            id: 'ad',
            elem: '#list',
            url: '<?php echo url("listTop"); ?>',
            where:{type:type},
            method: 'post',
            page:true,
            limit: 20,
            height: 'full-170',
            cols: [[
                {type: 'checkbox', fixed: 'left'},
                {field: 'd_title', title: '商品名称',align: 'center', width: 500,templet: '#media_name',fixed:'left'},
                {field: 'pic', title: '商品图片',align: 'center', width: 150,templet: '#goods_pic'},
                {field: 'quan_surplus', title: '剩余优惠券',align: 'center', width: 100,templet: '#media_name'},
                {field: 'quan_receive', title: '已领取优惠券',align: 'center', width: 120,templet: '#media_name'},
                {field: 'quan_price', title: '券额度(元)',align: 'center', width: 120,templet: '#media_name'},
                {field: 'price', title: '券后价(元)',align: 'center', width: 120,templet: '#media_name'},
                {field: 'sales_num', title: '商品销量',align: 'center', width: 100,templet: '#media_name'},
                {field: 'commission_jihua', title: '佣金比例(%)',align: 'center', width: 120,templet: '#media_name'},
                {field: 'quan_time', title: '优惠券有效期',align: 'center', width: 200,templet: '#media_identi'},
            ]],
            done:function(res,curr,count){
                hoverOpenImg();//显示大图
                $('table tr').on('click',function(){
                    $('table tr').css('background','');
                    $(this).css('background','<%=PropKit.use("config.properties").get("table_color")%>');
                });
            }
        });

        //下拉切换(商品来源)
        form.on('select(choose)', function(data){
            type = data.value;
            tableIn.reload({
                where: {type: type}
                ,page: {
                    curr: 1 //重新从第 1 页开始
                }
            });
        });

        //下拉切换(性别)
        form.on('select(sexChoose)', function(data){
            sex = data.value;
        });

        $("#add").on('click',function(){
            var checkStatus = table.checkStatus('ad'); //test即为参数id设定的值
            var ids = [];
            $(checkStatus.data).each(function (i, o) {
                ids.push(o.goodsid);
            });
            if (ids.length < 1){
                layer.msg("请选择加入的商品!");
                return false;
            }
            $.post("<?php echo url('addTop'); ?>",{type:type,data:ids,sex:sex},function (res) {
                if (res.code === 1){
                    layer.msg(res.msg,{time:1000,icon:1});
                    tableIn.reload({
                        where: {type: type}
                    });
                } else {
                    layer.msg(res.msg,{time:1000,icon:2})
                }
            })
        })

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