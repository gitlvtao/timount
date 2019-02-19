<?php /*a:1:{s:55:"D:\Timount\mall\application\banner\view\banner\add.html";i:1546854913;}*/ ?>
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
                        <label class="layui-form-label" style="width: 200px">广告名称</label>
                        <div class="layui-input-4" style="float: left;width: 400px;">
                            <input autocomplete="off" type="text" name="banner_title" value="<?php if(!(empty($banner) || (($banner instanceof \think\Collection || $banner instanceof \think\Paginator ) && $banner->isEmpty()))): ?><?php echo htmlentities($banner['banner_title']); ?><?php endif; ?>" lay-verify="required" placeholder="请输入广告名称" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item layui-row">
                        <label class="layui-form-label" style="width: 200px">广告链接</label>
                        <div class="layui-input-4" style="float: left;width: 400px;">
                            <input autocomplete="off" type="text" name="banner_url" value="<?php if(!(empty($banner) || (($banner instanceof \think\Collection || $banner instanceof \think\Paginator ) && $banner->isEmpty()))): ?><?php echo htmlentities($banner['banner_url']); ?><?php endif; ?>" lay-verify="required" placeholder="请输入广告名称" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item layui-row">
                        <label class="layui-form-label" style="width: 200px">广告属性</label>
                        <div class="layui-input-4" style="float: left;width: 400px;">
                            <input lay-filter="type" type="radio" name="banner_sex" value="0" title="全部" <?php if(!(empty($banner) || (($banner instanceof \think\Collection || $banner instanceof \think\Paginator ) && $banner->isEmpty()))): if($banner['banner_sex'] == 0): ?>checked<?php endif; else: ?>checked<?php endif; ?>>
                            <input lay-filter="type" type="radio" name="banner_sex" value="1" title="男" <?php if(!(empty($banner) || (($banner instanceof \think\Collection || $banner instanceof \think\Paginator ) && $banner->isEmpty()))): if($banner['banner_sex'] == 1): ?>checked<?php endif; ?><?php endif; ?>>
                            <input lay-filter="type" type="radio" name="banner_sex" value="2" title="女" <?php if(!(empty($banner) || (($banner instanceof \think\Collection || $banner instanceof \think\Paginator ) && $banner->isEmpty()))): if($banner['banner_sex'] == 2): ?>checked<?php endif; ?><?php endif; ?>>
                        </div>
                    </div>

                    <!--图片上传①-->
                    <div class="layui-form-item">
                        <label class="layui-form-label" style="width: 200px">广告图(750*300px)</label>
                        <input type="hidden" name="banner_img" id="pic_index" value="<?php if(!(empty($banner) || (($banner instanceof \think\Collection || $banner instanceof \think\Paginator ) && $banner->isEmpty()))): ?><?php echo htmlentities($banner['banner_img']); ?><?php endif; ?>">
                        <div class="layui-input-block">
                            <div class="layui-upload">
                                <button type="button" class="layui-btn layui-btn-primary" id="adBtn_index"><i class="icon icon-upload3"></i>点击上传</button>
                                <div class="layui-upload-list">
                                    <img class="layui-upload-img" id="adPic_index" src="<?php if(!(empty($banner['banner_img']) || (($banner['banner_img'] instanceof \think\Collection || $banner['banner_img'] instanceof \think\Paginator ) && $banner['banner_img']->isEmpty()))): ?><?php echo htmlentities($banner['banner_img']); ?><?php endif; ?>" onerror="this.src='/static/img/nopicture.gif';this.onerror=null" style="width: 240px; height: 180px">
                                    <p id="demoText_index"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item layui-layout-admin">
                        <div class="layui-input-block">
                            <input type="hidden" name="media_id" value="<?php if(!(empty($media_id) || (($media_id instanceof \think\Collection || $media_id instanceof \think\Paginator ) && $media_id->isEmpty()))): ?><?php echo htmlentities($media_id); ?><?php endif; ?>" class="layui-input">
                            <input type="hidden" name="banner_id" value="<?php if(!(empty($banner) || (($banner instanceof \think\Collection || $banner instanceof \think\Paginator ) && $banner->isEmpty()))): ?><?php echo htmlentities($banner['banner_id']); ?><?php endif; ?>" class="layui-input">
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
    layui.use(['form', 'layer','upload'], function () {
        var form = layui.form, $ = layui.jquery, upload = layui.upload;
        form.on('submit(submit)', function (data) {
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            var action = "<?php echo url('add'); ?>";
            if (data.field.banner_id.length > 0){
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


        //缩略图片上传
        var posterWidth_1 = 750, posterHeight_1 = 300;
        var uploadIndex = upload.render({
            elem: '#adBtn_index'
            ,url: '<?php echo url("other/upload/image"); ?>'
            ,auto: false
            ,field: 'image'
            ,accept: 'images'
            ,acceptMime: 'image/!*'
            ,before: function(obj){
                layer.load(); //上传loading
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#adPic_index').attr('src', result); //图片链接（base64）
                });
            }
            ,choose: function(obj) {
                obj.preview(function(index, file, result) {
                    var img = new Image();
                    img.onload = function() {
                        // console.log('choose poster', img.width, img.height);
                        if (posterWidth_1 == img.width && posterHeight_1 == img.height) {
                            $('#adPic_index').attr('src', result); //图片链接（base64）不支持ie8
                            obj.upload(index, file);
                        } else {
                            layer.msg('图片尺寸必须为：' + posterWidth_1 + 'x' + posterHeight_1 + 'px');
                        }
                    };
                    img.src = result;
                });
            }
            ,done: function(res){
                if(res.code>=0){
                    $('#pic_index').val(res.data);
                }else{
                    //如果上传失败
                    return layer.msg('上传失败');
                }
                layer.closeAll('loading'); //关闭loading
            }
            ,error: function(){
                layer.closeAll('loading'); //关闭loading
                //演示失败状态，并实现重传
                var demoText = $('#demoText_index');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function(){
                    uploadIndex.upload();
                });
            }
        });


    });

</script>
