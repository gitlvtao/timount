<?php /*a:1:{s:57:"D:\Timount\mall\application\online\view\online\index.html";i:1547105826;}*/ ?>
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
                <!--搜索-->
                <div class="layui-form-item">
                    <div class="layui-inline" style="width: 300px;">
                        <label class="layui-form-label">商品来源：</label>
                        <div class="layui-input-block">
                            <select name="is_form"  lay-filter="is_form" id="is_form">
                                <option value="1">大淘客</option>
                                <option value="2">自主添加</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <div class="layui-inline">
                            <input class="layui-input" name="key" id="key"  autocomplete="off" placeholder="请输入商品淘宝id" style="width: 400px">
                        </div>
                        <button class="layui-btn layui-btn-sm" id="search" data-type="reload">搜索</button>
                        <button type="reset" class="layui-btn layui-btn-sm layui-btn-primary" lay-submit lay-filter="layui-datatables-reset">重置</button>
                    </div>
                </div>
                <div class="layui-form-item" id="abc">
                    <label class="layui-form-label" style="float: left;">淘客分类:</label>
                    <div  class="category">
                        <span class="cidclick select" data-cid="0" data-type="0" style="border: 1px solid #e2e2e4;border-radius:10px;height: auto;line-height: 16px;">全部</span>
                        <span class="cidclick " data-cid="0" data-type="1" style="border: 1px solid #e2e2e4;border-radius:10px;height: auto;line-height: 16px;">女装</span>
                        <span class="cidclick " data-cid="0" data-type="3" style="border: 1px solid #e2e2e4;border-radius:10px;height: auto;line-height: 16px;">美妆</span>
                        <span class="cidclick " data-cid="0" data-type="6" style="border: 1px solid #e2e2e4;border-radius:10px;height: auto;line-height: 16px;">美食</span>
                        <span class="cidclick " data-cid="0" data-type="9" style="border: 1px solid #e2e2e4;border-radius:10px;height: auto;line-height: 16px;">男装</span>
                        <span class="cidclick " data-cid="0" data-type="4" style="border: 1px solid #e2e2e4;border-radius:10px;height: auto;line-height: 16px;">居家日用</span>
                        <span class="cidclick " data-cid="0" data-type="5" style="border: 1px solid #e2e2e4;border-radius:10px;height: auto;line-height: 16px;">鞋品</span>
                        <span class="cidclick " data-cid="0" data-type="11" style="border: 1px solid #e2e2e4;border-radius:10px;height: auto;line-height: 16px;">箱包</span>
                        <span class="cidclick " data-cid="0" data-type="14" style="border: 1px solid #e2e2e4;border-radius:10px;height: auto;line-height: 16px;">家装家纺</span>
                        <span class="cidclick " data-cid="0" data-type="8" style="border: 1px solid #e2e2e4;border-radius:10px;height: auto;line-height: 16px;">数码家电</span>
                        <span class="cidclick " data-cid="0" data-type="2" style="border: 1px solid #e2e2e4;border-radius:10px;height: auto;line-height: 16px;">母婴</span>
                        <span class="cidclick " data-cid="0" data-type="12" style="border: 1px solid #e2e2e4;border-radius:10px;height: auto;line-height: 16px;">配饰</span>
                        <span class="cidclick " data-cid="0" data-type="10" style="border: 1px solid #e2e2e4;border-radius:10px;height: auto;line-height: 16px;">内衣</span>
                        <span class="cidclick " data-cid="0" data-type="7" style="border: 1px solid #e2e2e4;border-radius:10px;height: auto;line-height: 16px;">文娱车品</span>
                        <span class="cidclick " data-cid="0" data-type="13" style="border: 1px solid #e2e2e4;border-radius:10px;height: auto;line-height: 16px;">户外活动</span>
                    </div>
                    <input type="hidden" id="category" name="category" value="0"/>
                </div>

                <!--筛选条件-->
                <div class="layui-form-item">
                    <label class="layui-form-label">筛选：</label>
                    <div class="layui-inline">
                        <label class="layui-form-label">售价</label>
                        <div class="layui-input-inline" style="width: 100px;">
                            <input type="text" name="price_min" placeholder="￥" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-form-mid">-</div>
                        <div class="layui-input-inline" style="width: 100px;">
                            <input type="text" name="price_max" placeholder="￥" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">券面额>=</label>
                        <div class="layui-input-inline" style="width: 100px;">
                            <input type="text" name="quan_price" placeholder="￥" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">佣金比例>=</label>
                        <div class="layui-input-inline" style="width: 100px;">
                            <input type="text" name="commission" autocomplete="off" placeholder="%" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">月销量>=</label>
                        <div class="layui-input-inline" style="width: 100px;">
                            <input type="text" name="sales_num" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <button class="layui-btn" id="screen" data-type="reload">筛选</button>
                    <button class="layui-btn" id="cleanScreen" data-type="reload">重置筛选</button>
                </div>
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
                    <a class="layui-btn layui-btn-sm" id="addAll" data-type="reload">加入推广</a>
                    <div id="addReward" class="layui-btn layui-btn-sm">加入奖品库</div>
                </div>

                <div class="layui-form-item">
                    <div  class="sortChoose" style="float: left">
                        <span class="cidclick select" data-type="1" style="border: 1px solid #e2e2e4;border-radius:10px;height: auto;line-height: 16px;float: 10px">综合</span>
                        <span class="cidclick " data-type="2" style="border: 1px solid #e2e2e4;border-radius:10px;height: auto;line-height: 16px;float: 10px">销量</span>
                        <span class="cidclick " data-type="3" style="border: 1px solid #e2e2e4;border-radius:10px;height: auto;line-height: 16px;float: 10px">领券量</span>
                        <span class="cidclick " data-type="4" style="border: 1px solid #e2e2e4;border-radius:10px;height: auto;line-height: 16px;float: 10px">佣金比例</span>
                        <span class="cidclick " data-type="5" style="border: 1px solid #e2e2e4;border-radius:10px;height: auto;line-height: 16px;float: 10px;">价格升序</span>
                        <span class="cidclick " data-type="6" style="border: 1px solid #e2e2e4;border-radius:10px;height: auto;line-height: 16px;float: 10px">价格降序</span>
                    </div>
                    <input type="hidden" id="sortChoose" name="sortChoose" value="1"/>
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
    <input name="{{d.column_id}}" data-id="{{d.column_id}}" class="list_order layui-input" value=" {{d.column_sort}}" size="10"/>
</script>
<script type="text/html" id="pic">
    <img src="{{d.pic}}">
</script>
<script type="text/html" id="info">
    <img src="{{d.column_banner}}">
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
        $("#brand_info").hide();
        var key='',is_form =1,sex_choose=2,category=0,price_min="",price_max="",quan_price="",commission="",sales_num="",sortChoose=1,column_choose="",brand_choose=1,brandColumn="";
        tableIn = table.render({
            id: 'ad',
            elem: '#list',
            url: '<?php echo url("index"); ?>',
            method: 'post',
            where:{is_form: is_form,key:key,category:category,min:price_min,max:price_max,price:quan_price,commission:commission,sales:sales_num,sortChoose:sortChoose},
            limit: 20,
            height: 'full-170',
            page:true,
            cols: [[
                {checkbox: true, fixed: true},
                {field: 'title', title: '商品标题',align: 'center', minWidth: 150,templet: '#media_balance'},
                {field: 'pic', title: '商品图片',align: 'center', width: 150,templet: '#pic'},
                {field: 'quan_surplus', title: '剩余优惠券',align: 'center', width: 120,templet: '#media_balance'},
                {field: 'quan_receive', title: '已领取优惠券',align: 'center', width: 120,templet: '#media_balance'},
                {field: 'quan_price', title: '券额度(元)',align: 'center', width: 120,templet: '#media_balance'},
                {field: 'price', title: '券后价(元)',align: 'center', width: 120,templet: '#media_balance'},
                {field: 'sales_num', title: '商品销量',align: 'center', width: 100,templet: '#media_balance'},
                {field: 'commission_jihua', title: '计划佣金比例(%)',align: 'center', width: 150,templet: '#media_balance'},
                {field: 'quan_time', title: '优惠券有效期',align: 'center', width: 160,templet: '#media_balance'},
                // {width: 150,title: '操作', align: 'center', toolbar: '#action',fixed:'right'}
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
            key = $('#key').val();
            if ($.trim(key) === '') {
                layer.msg('请输入关键字！', {icon: 0});
                return;
            }
            Refresh();
            return false;
        });
        //排序搜索sss
        $('.sortChoose').on('click', '.cidclick', function() {
            $(this).addClass('select').siblings().removeClass('select');
            $('#sortChoose').val($(this).attr('data-type'));
            sortChoose = $(this).attr('data-type');  //获取分类属性的值
            if(sortChoose == 2){
                $(this).text("销量从高到低");
            }else {
                $('.sortChoose').find('span').eq(1).text('销量')
            }
            if(sortChoose == 3){
                $(this).text("领券量从高到低");
            }else {
                $('.sortChoose').find('span').eq(2).text('领券量')
            }
            if(sortChoose == 4){
                $(this).text("佣金比例从高到低");
            }else{
                $('.sortChoose').find('span').eq(3).text('佣金比例')
            }
            Refresh();
            return false;
        });
        //来源切换sss
        form.on('select(is_form)', function(data){
            is_form = data.value;
            Refresh();
            return false;
        });
        //大淘客分类选中
        $('.category').on('click', '.cidclick', function() {
            $(this).addClass('select').siblings().removeClass('select');
            $('#category').val($(this).attr('data-type'));
            category = $(this).attr('data-type');  //获取分类属性的值
            Refresh();
            return false;
        });
        //筛选
        $("#screen").on('click',function(){
            Refresh();
            return false;
        });
        //刷新表单的公共方法
        Refresh = function(){
            if(is_form == 2){
                $("#abc").hide();
            }else{
                $("#abc").show();
            }
            //筛选条件
            price_min  = $("input[name='price_min']").val();
            price_max  = $("input[name='price_max']").val();
            quan_price = $("input[name='quan_price']").val();
            commission = $("input[name='commission']").val();
            sales_num  = $("input[name='sales_num']").val();
            tableIn.reload({
                where: {is_form: is_form,key:key,category:category,min:price_min,max:price_max,price:quan_price,commission:commission,sales:sales_num,sortChoose:sortChoose}
                ,page: {
                    curr: 1 //重新从第 1 页开始
                }
            });
        }
        //性别切换
        form.on('select(sexChoose)', function(data){
            sex_choose = data.value;
        });
        //监听媒体切换
        form.on('select(mediaChoose)',function(data){
            // console.log(data.value); //得到被选中的值
            var media_id = data.value;
            $.post("<?php echo url('get_media_column'); ?>",{media_id:media_id,sex:sex_choose},function(res){
                if(res.code == 1){
                    $("#columnChoose").empty();
                    $("#columnChoose").append(res.msg);
                    form.render('select');
                }
            })
        });
        //分类切换
        form.on('select(column_choose)',function(data){
            column_choose = data.value;
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
        });
        //品牌分类切换
        form.on('select(brand_info_choose)',function(data){
            brandColumn = data.value;
        });

        //加入
        $("#addAll").on('click',function(){
            if (column_choose.length <1){
                layer.msg("请选择分类",{time: 1200, icon: 0});
                return false;
            }
            var checkStatus = table.checkStatus('ad'); //test即为参数id设定的值
            var ids = [];
            $(checkStatus.data).each(function (i, o) {
                ids.push(o.goodsid);
            });
            if (ids.length == 0){
                layer.msg("请选择要加入的商品",{time: 1200, icon: 0});
                return false;
            }
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            $.post("<?php echo url('addAll'); ?>",{is_form:is_form,column:column_choose,brand:brand_choose,data:ids,brandColumn:brandColumn},function (res) {
                layer.close(loading);
                if(res.code===1){
                    layer.msg(res.msg,{time:1000,icon:1});
                    tableIn.reload();
                }else{
                    layer.msg('操作失败！',{time:1000,icon:2});
                }
            })
        });


        //加入奖品库
        $("#addReward").on('click',function () {
            var checkStatus = table.checkStatus('ad'); //test即为参数id设定的值
            var reward = [];
            $(checkStatus.data).each(function (i, o) {
                reward.push(o.goodsid);
            });
            if (reward.length == 0){
                layer.msg("请选择要加入的商品",{time: 1200, icon: 0});
                return false;
            }
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            $.post("<?php echo url('addReward'); ?>",{is_form:is_form,reward:reward},function (res) {
                layer.close(loading);
                if(res.code===1){
                    layer.msg(res.msg,{time:1000,icon:1});
                    tableIn.reload();
                }else{
                    layer.msg('操作失败！',{time:1000,icon:2});
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