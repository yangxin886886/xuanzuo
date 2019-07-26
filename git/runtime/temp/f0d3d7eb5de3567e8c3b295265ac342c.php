<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:71:"D:\phpstudy\PHPTutorial\WWW\git/application/admin\view\shape\index.html";i:1563962611;s:81:"D:\phpstudy\PHPTutorial\WWW\git\application\admin\view\public\head_resources.html";i:1563868278;s:83:"D:\phpstudy\PHPTutorial\WWW\git\application\admin\view\public\bottom_resources.html";i:1563266818;}*/ ?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/public/layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="/public/layuiadmin/style/admin.css" media="all">
<link rel="stylesheet" href="/public/layuiadmin/style/template.css" media="all">
</head>
<body>

  <div class="layui-fluid">
    <div class="layui-card">
      <div class="layui-form layui-card-header layuiadmin-card-header-auto">

          <input type="hidden" name="img">
          <div class="layui-form-item">
              <label class="layui-form-label">上传二维码</label>
              <div class="layui-upload-list">
                  <img class="layui-upload-img" id="demo2" style="width:200px;height:200px;">
                  <p id="demoText2"></p>
              </div>
              <input type="hidden" value="" name="wx_qrcode" id="a_picture2">
              <div class="layui-input-inline layui-btn-container" style="width: auto;">
                  <button type="button" class="layui-btn layui-btn-primary" id="file_upload2">
                      <i class="layui-icon">&#xe67c;</i>上传图片
                  </button>
                  <!--                  <button class="layui-btn layui-btn-primary" layadmin-event="avartatPreview">查看图片</button >-->
              </div>
          </div>

      </div>

      <div class="layui-card-body">
<!--        <div style="padding-bottom: 10px;">-->
<!--          <button class="layui-btn layuiadmin-btn-list" data-type="batchdel">删除</button>-->
<!--          <button class="layui-btn layuiadmin-btn-list" data-type="add">添加</button>-->
<!--        </div>-->
        <table id="table" lay-filter="table"></table>
          <script type="text/html" id="img">
              {{#  if(d.fb_status == 1){ }}
              <button class="layui-btn layui-btn-xs" lay-event="activityFb">已发布</button>
              {{#  } else { }}
              <button class="layui-btn layui-btn-primary layui-btn-xs" lay-event="activityFb">未发布</button>
              {{#  } }}
          </script>

        <script type="text/html" id="table_curd">
          <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
          <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</a>
        </script>
      </div>
    </div>
  </div>

  <script src="/public/layuiadmin/layui/layui.js"></script>
<script src="/public/layuiadmin/js/jquery-3.1.1.min.js"></script>

  <script>
  layui.config({
    base: '/public/layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'contlist', 'table','form','admin','upload'], function(){
    var table = layui.table
    ,form = layui.form
    ,admin = layui.admin
        ,upload = layui.upload
    
    //监听搜索
    form.on('submit(LAY-app-contlist-search)', function(data){
      var field = data.field;
      
      //执行重载
      table.reload('LAY-app-content-list', {
        where: field
      });
    });

    //第一个实例
    table.render({
      elem: '#table'
      ,height: 700
      ,url: "<?php echo url('Shape/getShapeList'); ?>" //数据接口
      ,page: true //开启分页
      ,cols: [[ //表头
        {field: 'id', title: 'ID', sort: true, fixed: 'left'}
        ,{field: 'name', title: '活动名称'}
        ,{field: 'img', title: '形状',templet:'#img'}
        ,{field: '', title: '操作',templet:'#table_curd',width:150}
      ]]
    });


    //监听工具条
    table.on('tool(table)', function(obj){
      var data = obj.data; //获得当前行数据
      var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）


      if(layEvent === 'detail'){ //查看
        //do somehing
      }

      else if(layEvent === 'activityFb'){ //发布或暂停发布

          var activityFb = "<?php echo url('Activity/activityFb'); ?>";
          admin.req({
              url:activityFb,
              data:{id:data.id,fb_status:data.fb_status},
              done: function (res) {
                  layer.msg('成功')
                  window.location.reload();
              }
          })
      }
      else if(layEvent === 'activitySq'){ //启用上墙
          var enable_sq = "<?php echo url('Activity/activitySq'); ?>";
          admin.req({
              url:enable_sq,
              data:{id:data.id,is_sq:data.is_sq},
              done: function (res) {
                  layer.msg('成功');
                  window.location.reload();
              }
          })
      }

      else if(layEvent === 'del'){ //删除
        var del_url = "<?php echo url('Activity/activityDel'); ?>";
        layer.confirm('真的删除行么', function(index){
          admin.req({
            url:del_url,
            data:{id:data.id},
            done: function (res) {
              layer.msg('成功')
            }
          })
        });
      }
      else if(layEvent === 'edit'){ //编辑
        layer.open({
          type: 2
          ,title: '编辑'
          ,content: "<?php echo url('Activity/activityEditView'); ?>?id="+data.id
          ,area: ['90%', '90%']
          ,btn: ['确定', '取消']
          ,yes: function(index, layero){
            var iframeWindow = window['layui-layer-iframe'+ index]
                    ,submitID = 'LAY-user-back-submit'
                    ,submit = layero.find('iframe').contents().find('#'+ submitID);

            //监听提交
            iframeWindow.layui.form.on('submit('+ submitID +')', function(data){
              var field = data.field; //获取提交的字段
              //提交 Ajax 成功后，静态更新表格中的数据
              //$.ajax({});
              table.reload('LAY-user-front-submit'); //数据刷新
              layer.close(index); //关闭弹层
            });

            submit.trigger('click');
          }
        });

      }
    });

      var upload_url = "<?php echo url('Upload/upload'); ?>";
      upload.render({
          elem: '#file_upload2'
          ,url: upload_url
          ,before: function(obj){
              //预读本地文件示例，不支持ie8
              obj.preview(function(index, file, result){
                  $('#demo2').attr('src', result); //图片链接（base64）
              });
          }
          ,done: function(res){
              console.log(res);
              //如果上传失败
              if(res.code > 0){
                  layer.msg('上传失败');
              }
              $('#img').val(res.data);
              layer.msg('成功');
          }
          ,error: function(){
              //演示失败状态，并实现重传
              var demoText = $('#demoText');
              demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
              demoText.find('.demo-reload').on('click', function(){
                  uploadInst.upload();
              });
          }
      });


    $('.layui-btn.layuiadmin-btn-list').on('click', function(){
      var type = $(this).data('type');
      active[type] ? active[type].call(this) : '';
    });

  });
  </script>
</body>
</html>
