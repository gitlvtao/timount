<?php /*a:1:{s:53:"D:\Timount\mall\application\goods\view\goods\add.html";i:1546842987;}*/ ?>
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
    <div class="layui-row layui-col-space15">
        <div class="layui-card">
            <div class="layui-btn-table">
                <form class="layui-form layui-form-pane">
                    <div class="layui-form-item layui-row">
                        <label class="layui-form-label" style="width: 150px">淘宝ID</label>
                        <div class="layui-input-4" style="float: left;width: 400px;">
                            <input autocomplete="off" type="text" name="taobao_id" value="<?php if(!(empty($goods['goodsid']) || (($goods['goodsid'] instanceof \think\Collection || $goods['goodsid'] instanceof \think\Paginator ) && $goods['goodsid']->isEmpty()))): ?><?php echo htmlentities($goods['goodsid']); ?><?php endif; ?>" lay-verify="required" placeholder="请输入大淘客ID" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item layui-row">
                        <label class="layui-form-label" style="width: 150px">商品短标题</label>
                        <div class="layui-input-4" style="float: left;width: 600px;">
                            <input autocomplete="off" type="text" name="d_title" value="<?php if(!(empty($goods['d_title']) || (($goods['d_title'] instanceof \think\Collection || $goods['d_title'] instanceof \think\Paginator ) && $goods['d_title']->isEmpty()))): ?><?php echo htmlentities($goods['d_title']); ?><?php endif; ?>" lay-verify="required" placeholder="请输入商品短标题" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item layui-row">
                        <label class="layui-form-label" style="width: 150px">商品标题</label>
                        <div class="layui-input-4" style="float: left;width: 600px;">
                            <input autocomplete="off" type="text" name="title" value="<?php if(!(empty($goods['title']) || (($goods['title'] instanceof \think\Collection || $goods['title'] instanceof \think\Paginator ) && $goods['title']->isEmpty()))): ?><?php echo htmlentities($goods['title']); ?><?php endif; ?>" lay-verify="required" placeholder="请输入商品标题" class="layui-input">
                        </div>
                    </div>

                    <!--图片上传①-->
                    <div class="layui-form-item layui-row">
                        <label class="layui-form-label" style="width: 150px">商品主图url地址</label>
                        <div class="layui-input-4" style="float: left;width: 600px;">
                            <input autocomplete="off" type="text" name="pic" value="<?php if(!(empty($goods['pic']) || (($goods['pic'] instanceof \think\Collection || $goods['pic'] instanceof \think\Paginator ) && $goods['pic']->isEmpty()))): ?><?php echo htmlentities($goods['pic']); ?><?php endif; ?>" lay-verify="required" placeholder="请输入商品标题" class="layui-input">
                        </div>
                    </div>


                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 150px">来源平台</label>
                            <div class="layui-input-inline" style="float: left;width: 100px;">
                                <select name="istmall" lay-verify="required" lay-filter="ccc" id="goods_istmall" style="float: -120px;">
                                    <option value="0" <?php if(!(empty($goods['quan_surplus']) || (($goods['quan_surplus'] instanceof \think\Collection || $goods['quan_surplus'] instanceof \think\Paginator ) && $goods['quan_surplus']->isEmpty()))): if($goods['istmall'] == '0'): ?>selected<?php endif; ?><?php endif; ?> >淘宝</option>
                                    <option value="1" <?php if(!(empty($goods['quan_surplus']) || (($goods['quan_surplus'] instanceof \think\Collection || $goods['quan_surplus'] instanceof \think\Paginator ) && $goods['quan_surplus']->isEmpty()))): if($goods['istmall'] == '1'): ?>selected<?php endif; ?><?php endif; ?>>天猫</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 150px">优惠券结束时间</label>
                            <div class="layui-input-inline" style="float: left;width: 200px;">
                                <input autocomplete="off" class="layui-input" type="text" name="quan_time" value="<?php if(!(empty($goods['quan_time']) || (($goods['quan_time'] instanceof \think\Collection || $goods['quan_time'] instanceof \think\Paginator ) && $goods['quan_time']->isEmpty()))): ?><?php echo htmlentities($goods['quan_time']); ?><?php endif; ?>" id="timeChoose">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 150px">优惠券剩余数</label>
                            <div class="layui-input-4" style="float: left;width: 100px;">
                                <input autocomplete="off" type="text" name="quan_surplus" value="<?php if(!(empty($goods['quan_surplus']) || (($goods['quan_surplus'] instanceof \think\Collection || $goods['quan_surplus'] instanceof \think\Paginator ) && $goods['quan_surplus']->isEmpty()))): ?><?php echo htmlentities($goods['quan_surplus']); ?><?php endif; ?>" lay-verify="required"  class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 150px">已领券数量</label>
                            <div class="layui-input-4" style="float: left;width: 100px;">
                                <input autocomplete="off" type="text" name="quan_receive" value="<?php if(!(empty($goods['quan_receive']) || (($goods['quan_receive'] instanceof \think\Collection || $goods['quan_receive'] instanceof \think\Paginator ) && $goods['quan_receive']->isEmpty()))): ?><?php echo htmlentities($goods['quan_receive']); ?><?php endif; ?>" lay-verify="required"  class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 150px">计划佣金比例(%)</label>
                            <div class="layui-input-4" style="float: left;width: 100px;">
                                <input autocomplete="off" type="text" name="commission_jihua" value="<?php if(!(empty($goods) || (($goods instanceof \think\Collection || $goods instanceof \think\Paginator ) && $goods->isEmpty()))): ?><?php echo htmlentities($goods['commission_jihua']); ?><?php endif; ?>" lay-verify="required"  class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 150px">鹊桥佣金比例(%)</label>
                            <div class="layui-input-4" style="float: left;width: 100px;">
                                <input autocomplete="off" type="text" name="commission_queqiao" value="<?php if(!(empty($goods) || (($goods instanceof \think\Collection || $goods instanceof \think\Paginator ) && $goods->isEmpty()))): ?><?php echo htmlentities($goods['commission_queqiao']); ?><?php endif; ?>" lay-verify="required"  class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 150px">优惠券金额</label>
                            <div class="layui-input-4" style="float: left;width: 100px;">
                                <input autocomplete="off" type="text" name="quan_price" value="<?php if(!(empty($goods) || (($goods instanceof \think\Collection || $goods instanceof \think\Paginator ) && $goods->isEmpty()))): ?><?php echo htmlentities($goods['quan_price']); ?><?php endif; ?>" lay-verify="required"  class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 150px">券后价格</label>
                            <div class="layui-input-4" style="float: left;width: 100px;">
                                <input autocomplete="off" type="text" name="price" value="<?php if(!(empty($goods) || (($goods instanceof \think\Collection || $goods instanceof \think\Paginator ) && $goods->isEmpty()))): ?><?php echo htmlentities($goods['price']); ?><?php endif; ?>" lay-verify="required"  class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 150px">正常售价</label>
                            <div class="layui-input-4" style="float: left;width: 100px;">
                                <input autocomplete="off" type="text" name="org_price" value="<?php if(!(empty($goods) || (($goods instanceof \think\Collection || $goods instanceof \think\Paginator ) && $goods->isEmpty()))): ?><?php echo htmlentities($goods['org_price']); ?><?php endif; ?>" lay-verify="required"  class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 150px">商品销量</label>
                            <div class="layui-input-4" style="float: left;width: 100px;">
                                <input autocomplete="off" type="text" name="sales_num" value="<?php if(!(empty($goods) || (($goods instanceof \think\Collection || $goods instanceof \think\Paginator ) && $goods->isEmpty()))): ?><?php echo htmlentities($goods['sales_num']); ?><?php endif; ?>" lay-verify="required"  class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 150px">优惠券ID</label>
                            <div class="layui-input-4" style="float: left;width: 350px;">
                                <input autocomplete="off" type="text" name="quan_id" value="<?php if(!(empty($goods) || (($goods instanceof \think\Collection || $goods instanceof \think\Paginator ) && $goods->isEmpty()))): ?><?php echo htmlentities($goods['quan_id']); ?><?php endif; ?>" lay-verify="required"  class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 150px">券使用条件</label>
                            <div class="layui-input-4" style="float: left;width: 400px;">
                                <input autocomplete="off" type="text" name="quan_condition" value="<?php if(!(empty($goods) || (($goods instanceof \think\Collection || $goods instanceof \think\Paginator ) && $goods->isEmpty()))): ?><?php echo htmlentities($goods['quan_condition']); ?><?php endif; ?>" lay-verify="required"  class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 150px">商品描述</label>
                            <div class="layui-input-4" style="float: left;width: 400px;">
                                <textarea autocomplete="off" type="text" name="introduce" value="" lay-verify="required"  class="layui-input"><?php if(!(empty($goods) || (($goods instanceof \think\Collection || $goods instanceof \think\Paginator ) && $goods->isEmpty()))): ?><?php echo htmlentities($goods['introduce']); ?><?php endif; ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item layui-layout-admin">
                        <div class="layui-input-block">
                            <input type="hidden" name="goods_id" value="<?php if(!(empty($goods) || (($goods instanceof \think\Collection || $goods instanceof \think\Paginator ) && $goods->isEmpty()))): ?><?php echo htmlentities($goods['goods_id']); ?><?php endif; ?>">
                            <button type="button" class="layui-btn" lay-submit="" lay-filter="submit">提交</button>
                            <!--<a href="<?php echo url('index'); ?>" class="layui-btn layui-btn-primary">返回</a>-->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/static/layuiadmin/layui/layui.js"></script><script type="text/javascript" src="/static/js/tools.js"></script>
<script>
    layui.use(['form', 'layer','upload','laydate'], function () {
        var form = layui.form, $ = layui.jquery, upload = layui.upload,laydate = layui.laydate;
        form.on('submit(submit)', function (data) {
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            var action = "<?php echo url('add'); ?>";
            if (data.field.goods_id.length > 0){
                action = "<?php echo url('edit'); ?>";
            }
            $.post(action, data.field, function (res) {
                layer.close(loading);
                if (res.code > 0) {
                    layer.msg(res.msg, {time: 1800, icon: 1}, function () {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                        parent.tableIn.reload();
                    });
                } else {
                    layer.msg(res.msg, {time: 1800, icon: 2});
                }
            });
        });

        //时间控件
        laydate.render({
            elem: '#timeChoose',
            type: 'datetime'
        });

    });

</script>
