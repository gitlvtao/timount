<?php /*a:1:{s:61:"D:\Timount\mall\application\goods\view\goodsmanage\index.html";i:1547000162;}*/ ?>
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
    <link rel="stylesheet" type="text/css" href="/static/layuiadmin/layui/css/layui.css" /><link rel="stylesheet" type="text/css" href="/static/layuiadmin/style/admin.css" /><link rel="stylesheet" type="text/css" href="/static/css/goodsList.css" />
    <title></title>
</head>
<body>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <form class="layui-form" id="search-form">
                <!--媒体分类切换-->
                <div class="layui-form-item">
                    <div class="layui-inline" >
                        <label class="layui-form-label">性别选择：</label>
                        <div class="layui-input-block" style="width: 100px;">
                            <select name="sex_choose" lay-filter="sexChoose" id="sexChoose">
                                <option value="2">女</option>
                                <option value="1">男</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline" >
                        <label class="layui-form-label">媒体选择：</label>
                        <div class="layui-input-block">
                            <select name="media_choose" lay-filter="mediaChoose" id="mediaChoose">
                                <option value="">请选择媒体</option>
                                <?php if(is_array($media) || $media instanceof \think\Collection || $media instanceof \think\Paginator): $i = 0; $__LIST__ = $media;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                    <option value="<?php echo htmlentities($vo['media_id']); ?>"><?php echo htmlentities($vo['media_title']); ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline" >
                        <label class="layui-form-label">分类选择：</label>
                        <div class="layui-input-block">
                            <select name="column_choose" lay-filter="column_choose" id="columnChoose">
                                <option value="">请选择分类</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline" >
                        <label class="layui-form-label">品牌馆：</label>
                        <div class="layui-input-block" style="width: 100px;">
                            <select name="brand_choose" lay-filter="brand_choose" id="brandChoose">
                                <option value="1">否</option>
                                <option value="2">是</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline" id="brand_info" >
                        <label class="layui-form-label">品牌选择：</label>
                        <div class="layui-input-block">
                            <select name="brand_info_choose" lay-filter="brand_info_choose" id="brandInfoChoose">
                            </select>
                        </div>
                    </div>
                    <!--<a class="layui-btn layui-btn-sm" id="addAll" data-type="reload">加入推广</a>-->
                </div>
            </form>
        </div>
        <!-- datatables页 -->
        <div class="layui-card-body">
            <table class="layui-table" id="list" lay-filter="list"></table>
        </div>
    </div>
</div>
<script type="text/html" id="sort">
    <input name="{{d.bind_id}}" data-id="{{d.bind_id}}" class="list_order layui-input" value=" {{d.bind_sort}}" size="10"/>
</script>
<script type="text/html" id="pic">
    <img src="{{d.pic}}">
</script>
<script type="text/html" id="action">
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script type="text/javascript" src="/static/layuiadmin/layui/layui.js"></script><script type="text/javascript" src="/static/js/tools.js"></script>
<script>
    var tableIn;
    layui.use(['table','form'], function() {
        var table = layui.table,form = layui.form,$ = layui.jquery;
        $("#brand_info").hide();
        var sex_choose = 2,column_choose = "",brand_choose = 1,brandColumn="",media_id="";
        tableIn = table.render({
            id: 'ad',
            elem: '#list',
            url: '<?php echo url("index"); ?>',
            method: 'post',
            where:{sex:sex_choose,column:column_choose,brand:brand_choose,brandColumn:brandColumn},
            limit: 20,
            height: 'full-170',
            page:true,
            cols: [[
                // {checkbox: true, fixed: true},
                {field: 'title', title: '商品标题',align: 'center', minWidth: 150,templet: '#media_balance',fixed:'left'},
                {field: 'pic', title: '商品图片',align: 'center', width: 150,templet: '#pic'},
                {field: 'quan_surplus', title: '剩余优惠券',align: 'center', width: 120,templet: '#media_balance'},
                {field: 'quan_receive', title: '已领取优惠券',align: 'center', width: 120,templet: '#media_balance'},
                {field: 'quan_price', title: '券额度(元)',align: 'center', width: 120,templet: '#media_balance'},
                {field: 'price', title: '券后价(元)',align: 'center', width: 120,templet: '#media_balance'},
                {field: 'sales_num', title: '商品销量',align: 'center', width: 100,templet: '#media_balance'},
                {field: 'commission_jihua', title: '计划佣金比例(%)',align: 'center', width: 150,templet: '#media_balance'},
                {field: 'quan_time', title: '优惠券有效期',align: 'center', width: 160,templet: '#media_balance'},
                {field: 'bind_sort', title: '排序',align: 'center', width: 90,templet: '#sort',fixed:'right'},
                {width: 150,title: '操作', align: 'center', toolbar: '#action',fixed:'right'}
            ]],
            done:function(res,curr,count){
                hoverOpenImg();//显示大图
                $('table tr').on('click',function(){
                    $('table tr').css('background','');
                    $(this).css('background','<%=PropKit.use("config.properties").get("table_color")%>');
                });
            }
        });

        //性别切换
        form.on('select(sexChoose)', function(data){
            sex_choose = data.value;
            getColumnChoose(media_id);
            column_choose = "";
            getData();
        });
        //监听媒体切换
        form.on('select(mediaChoose)',function(data){
            // console.log(data.value); //得到被选中的值
            media_id = data.value;
            getColumnChoose(media_id);
        });
        //媒体切换获取分类公共方法
        getColumnChoose = function(media_id){
            $.post("<?php echo url('get_media_column'); ?>",{media_id:media_id,sex:sex_choose},function(res){
                if(res.code == 1){
                    $("#columnChoose").empty();
                    $("#columnChoose").append(res.msg);
                    form.render('select');
                }
            })
        };
        //分类切换
        form.on('select(column_choose)',function(data){
            column_choose = data.value;
            getData();
        });
        //品牌馆切换
        form.on('select(brand_choose)',function(data){
            brand_choose = data.value;
            if (brand_choose == 1){
                $("#brand_info").hide();
            } else {
                $.post("<?php echo url('getBrand'); ?>",{column_id:column_choose},function(res){
                    if(res.code == 1){
                        $("#brandInfoChoose").empty();
                        $("#brandInfoChoose").append(res.msg);
                        form.render('select');
                    }
                });
                $("#brand_info").show();
            }
            getData();
        });
        //品牌分类切换
        form.on('select(brand_info_choose)',function(data){
            brandColumn = data.value;
            getData();
        });
        //数据更新
        getData = function () {
            tableIn.reload({
                where:{sex:sex_choose,column:column_choose,brand:brand_choose,brandColumn:brandColumn}
                ,page: {
                    curr: 1 //重新从第 1 页开始
                }
            })
        };
        //操作
        table.on('tool(list)', function(obj){
            var data = obj.data; //获得当前行数据
            var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
            if(layEvent === 'del'){ //查看
                layer.confirm('您确定要删除该商品吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('del'); ?>",{id:data.bind_id,brand:brand_choose},function(res){
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
            }
        });
        //排序
        $('body').on('blur','.list_order',function() {
            var column_id = $(this).attr('data-id');
            var sort = $(this).val();
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            $.post('<?php echo url("sort"); ?>',{id:column_id,sort:sort,brand:brand_choose},function(res){
                layer.close(loading);
                if(res.code === 1){
                    layer.msg(res.msg, {time: 1000, icon: 1});
                    tableIn.reload({
                        where:{sex:sex_choose,column:column_choose,brand:brand_choose,brandColumn:brandColumn}
                    });
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