<?php
namespace app\admin\controller;
use app\admin\Model\Image as ImageModel;
use app\common\controller\Admin;
use think\Controller;
use think\Db;
use think\Request;

/**
 *
 */
class Image extends Admin {
	public function add() {
		if (request::instance()->isGet()) {
			return $this->fetch();
		} else if (request::instance()->isPost()) {
			$file = request()->file('image');
			$link = request()->param();

			if ($file) {
				$info = $file->validate(['ext' => 'jpg,jpeg,png', 'size' => 2 * 1024 * 1024])->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads');
				if ($info) {
					$data = $info->getSaveName();
					$images = [
						'image' => $data,
						'title' => $link['title'],
						// 'created' => time(),
					];

					$res = model('image')->save($images);
					if ($res) {
						$this->success("上传成功，文件目录为:" . $data, url('admin/image/watch'));
						// return "上传成功，文件目录为:" . $data;
					} else {
						// $this->error($res);
						return $this->error('添加失败');
					}
				} else {
					// 上传失败获取错误信息
					// $this->error("上传失败");
					return $this->error('上传文件失败');
				}
			} else {
				// $this->error("上传失败请选择要上传的文件");
				return $this->error('未找到文件');
			}
		}
	}
	public function watch() {
		$slide = db('image')->field('id,title,image')->where('image', 'neq', '')->order('created DESC')->limit(5)->select();
		$image = db('image')->order('created DESC')->select();

		$this->assign([
			'slide' => $slide,
			'image' => $image,
		]);
		return $this->fetch();
	}
	public function update() {
		$id = request()->param()['id'];
		$data = db('image')->find($id);
		$this->assign('data', $data);
		return $this->fetch();
	}

	public function amend(Request $request) {
		$file = request()->file('image');
		$data = request()->param();
		$id = $data['id'];
		$result = db('image')->where('Id', $id)->select();
		if ($file) {
			$info = $file->validate(['ext' => 'jpg,jpeg,png', 'size' => 2 * 1024 * 1024])->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads');
			if ($info) {
				$file = $info->getSaveName();
				$value = [
					'image' => $file,
					'title' => $data['title'],
				];

				$c = ImageModel::get($id);
				$c->save($value); //save修改时间自动完成

				// $res = Image::where('id', $id)->update($value);
				// $res = db('image')->where('id', $id)->update($value);
				return $this->redirect(url('admin/image/watch'));
			} else {
				$this->error("上传失败");
			}
		} else {
			$this->error("上传失败请选择要上传的文件");
		}

	}

	public function delete($id) {
		$res = db('image')->delete($id);
		if ($res) {
			return $this->redirect(url('admin/image/watch'));
		} else {
			return $this->error('删除失败');
		}
	}

}