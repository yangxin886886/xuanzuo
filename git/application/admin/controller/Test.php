<?php
namespace app\admin\controller;
use think\Validate;
use think\Controller;
require_once (ROOT_PATH .'/server/Ali/AlibabaCloudMes.php');
class Test extends Controller {
    public function index(){
        return $this->fetch();
    }
    public function test(){
    }
}