<?php
namespace app\admin\controller;
use app\admin\Model\User as UserModel;
use think\Controller;
use think\Db;
use think\Request;
use think\Validate;

/**
 * 后台用户控制器
 */
class User extends Controller {
	protected $beforeActionList = [
		'checkLogin' => ['except' => 'login'],
	];
	public function checkLogin() {
		if (!session('?admin')) {
			$this->redirect(url('admin/user/login'));
		}
	}
	//管理员退出
	public function logout() {
		// 将session中的admin清空
		session('admin', null);
		// 跳转到登录页面
		$this->redirect(url('admin/user/login'));
	}

	//添加管理员页面
	public function add() {
		return $this->fetch();
	}

	//执行添加管理员 接收表单数据 验证表单数据规则并提示消息
	public function doRegister(Request $request) {
		$data = request()->param();
		if (!captcha_check($data['captcha'])) {
			$this->error('验证码错误');
		};
		$rule = [
			// '字段名'=>'规则1|规则2|...'
			'username' => 'require|length:2,100|unique:user',
			'password' => 'require|min:6',
			'password2' => 'require|confirm:password',
		];

		$message = [
			'username.require' => '用户名不能为空',
			'username.length' => "用户名长度非法(2-100位)",
			'username.unique' => "用户名被占用,请重试",
			'password.require' => '密码不能为空',
			'password.min' => '密码最少6位',
		];
		$v = new Validate($rule, $message);
		if (!$v->check($data)) {
			$this->error($v->getError());
		}
		//判断密码输入是否相同  验证密码都通过获取数据添加数据库
		if ($data['password'] != $data['password2']) {
			$this->error('两次输入的密码不一致,请重新输入');
		}
		$users = [
			'username' => $data['username'],
			'password' => md5($data['password']),
		];

		if ($users) {
			$res = UserModel::create($users);

			$this->success('注册成功', url('admin/user/index'), '', 1);
		} else {
			$this->error($model->getError());
		}
	}

	//修改管理员页面
	public function amend() {
		$id = request()->param()['id'];
		$data = db('user')->find($id);

		$this->assign('data', $data);
		return $this->fetch();
	}
	//执行修改 输入原密码 如果正确则进行修改
	public function update(Request $request) {
		$data = request()->param();
		$id = $data['id'];
		$pwd = db('user')->find($id);
		if ($pwd['password'] == md5($data['password'])) {
			$users = [
				'username' => $data['username'],
				'password' => md5($data['password1']),
			];
		} else {
			$this->error('原密码错误');
		}
		//判断新密码两次输入手一致 然后执行修改操作到数据库
		if ($data['password1'] != $data['password2']) {
			$this->error('两次输入的密码不一致,请重新输入');
		}

		$rule = [
			// '字段名'=>'规则1|规则2|...'
			'username' => 'require|length:2,100',
			'password2' => 'require|min:6',
		];

		$message = [
			'username.require' => '用户名不能为空',
			'username.length' => "用户名长度非法(2-100位)",

			'password2.require' => '密码不能为空',
			'password2.min' => '密码最少6位',
		];
		$v = new Validate($rule, $message);
		if (!$v->check($data)) {
			$this->error($v->getError());
		}

		if ($users) {
			$res = usermodel::where('id', $id)->update($users);
			// $this->redirect(url('admin/user/index'));
			$this->success('修改成功', url('admin/user/index'), '', 1);
		} else {
			$this->error($model->getError());
		}
	}

	//删除管理员
	public function delete($id) {
		$count = count(db('user')->select());

		if ($count == 1) {
			return $this->error('最少有一个管理员');
		} else {

			$res = db('user')->delete($id);
			if ($res) {
				$this->success('删除成功');
			} else {
				$this->error('删除失败');
			}
		}
	}

	//管理员登录 判断传参方式  查询管理员表数据
	public function login() {
		if (request()->isGet()) {
			return $this->fetch();
		} else if (request()->isPost()) {
			$username = input('post.username/s');
			$password = input('post.password/s');

			$admin = db('user')
				->field('id,username')
				->where('username', $username)
				->where('password', md5($password))
				->find();
			if ($admin) {
				// 将管理员信息赋值给session
				session('admin', $admin);
				// 跳转到控制面板
				$this->redirect(url('admin/index/index'));
			} else {
				// 登录失败跳回登录页面
				$this->error('登录失败', url('admin/user/login'));
			}
		}
	}

	//查询用户列表
	public function index() {
		$res = model('user')->getList();
		$this->assign('user', $res);
		return $this->fetch();
	}
}