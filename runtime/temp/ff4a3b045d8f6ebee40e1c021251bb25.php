<?php /*a:1:{s:55:"D:\Timount\mall\application\brand\view\brand\index.html";i:1547000725;}*/ ?>
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
                            <button class="layui-btn layui-btn-sm">媒体切换</button>
                        </div>
                        <div class="layui-inline" style="float: left">
                            <select name="media_id" id="select_media" lay-verify="require" lay-vertype="tips" lay-filter="mediaChoose">
                                <option value="">请选择</option>
                                <?php if(is_array($media) || $media instanceof \think\Collection || $media instanceof \think\Paginator): $i = 0; $__LIST__ = $media;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo htmlentities($v['media_id']); ?>"><?php echo htmlentities($v['media_title']); ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <div style="float: left">
                            <button class="layui-btn layui-btn-sm">性别切换</button>
                        </div>
                        <div class="layui-inline" style="float: left">
                            <select name="sex" id="select_sex" lay-verify="require" lay-vertype="tips" lay-filter="sexChoose">
                                <option value="2">女</option>
                                <option value="1">男</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <div style="float: left">
                            <button class="layui-btn layui-btn-sm">品牌分类切换</button>
                        </div>
                        <div class="layui-inline" style="float: left">
                            <select name="column_id" id="select_column" lay-verify="require" lay-vertype="tips" lay-filter="columnChoose">
                            </select>
                        </div>
                    </div>
                    <a id="add" class="layui-btn layui-btn-sm layui-btn-normal" ><i class="fa fa-plus" aria-hidden="true"></i>添加品牌</a>
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
<script type="text/html" id="index">
    <img src="{{d.brand_logo}}">
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
        var key = '', sex = $("#select_sex").val(),media_id = $("#select_media").val(),column_id = $("#select_column").val();
        tableIn = table.render({
            id: 'ad',
            elem: '#list',
            url: '<?php echo url("index"); ?>',
            method: 'post',
            where:{column_id:column_id},
            page:true,
            limit: 20,
            height: 'full-170',
            cols: [[
                {field: 'brand_title', title: '品牌名称',align: 'center', width: 160,templet: '#media_balance'},
                {field: 'brand_logo', title: '品牌缩略图',align: 'center', width: 200,templet: '#index'},
                {width: 200,title: '操作', align: 'center', toolbar: '#action',fixed:'right'}
            ]],
            done:function(res,curr,count){
                hoverOpenImg();//显示大图
                $('table tr').on('click',function(){
                    $('table tr').css('background','');
                    $(this).css('background','<%=PropKit.use("config.properties").get("table_color")%>');
                });
            }
        });
        //媒体切换
        form.on('select(mediaChoose)', function(data){
            media_id = data.value;
            if (media_id.length<0){
                layer.msg("请选择媒体",{time:1200,icon:1});
                return false;
            }
            column();
        });
        //下拉(性别)切换
        form.on('select(sexChoose)', function(data){
            sex = data.value;
            column();
        });
        //下拉(分类)切换
        form.on('select(columnChoose)',function (data) {
            column_id = data.value;
            tableIn.reload({
                where: {column_id:column_id}
                ,page: {
                    curr: 1 //重新从第 1 页开始
                }
            });
        });
        //切换公共方法
        column = function(){
            $.post("<?php echo url('get_media_column'); ?>",{media_id:media_id,sex:sex},function (res) {
                if(res.code == 1){
                    $("#select_column").empty();
                    $("#select_column").append(res.msg);
                    form.render('select');
                }
            })
        }

        //新增
        $("#add").on('click',function(){
            column_id = $("#select_column").val();
            if (column_id == null || column_id == ''){
                layer.msg("请选择品牌分类",{time:1500,icon:0});
                return false;
            }
            layer.open({
                type: 2,
                title: '新增品牌',
                content: '<?php echo url("add"); ?>?column_id='+ column_id,
                area: ['100%','100%'], //计算页面大小
            })
        });

        table.on('tool(list)', function(obj) {
            var data = obj.data;
            if (obj.event === 'del'){
                layer.confirm('您确定要删除该品牌吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('del'); ?>",{id:data.brand_id},function(res){
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
                    title: '新增品牌',
                    content: '<?php echo url("edit"); ?>?id='+ data.brand_id,
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