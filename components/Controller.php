<?php
/**
 * Created by FesVPN.
 * @project api-todo-app
 * @author  Pham Hai
 * @email   mitto.hai.7356@gmail.com
 * @date    26/8/2022
 * @time    3:06 PM
 */

namespace app\components;

use yii\filters\auth\QueryParamAuth;
use yii\filters\Cors;

class Controller extends \yii\web\Controller {

	public $_user = null;

	public function init() {
		\Yii::$app->user->enableSession = false;
		\Yii::$app->response->format    = "json";
		parent::init();
	}

	public function behaviors() {
		$behaviors                  = parent::behaviors();
		$behaviors['authenticator'] = [
			'class'      => QueryParamAuth::class,
			'except'     => [
				'index',
				'login',
			],
			'tokenParam' => 'token',
		];
		$behaviors['corsFilter']    = [
			'class' => Cors::class,
			'cors'  => [
				'Origin'                           => ['*'],
				'Access-Control-Request-Method'    => ['*'],
				'Access-Control-Request-Headers'   => ['*'],
				'Access-Control-Allow-Origin'      => ['*'],
				'Access-Control-Allow-Credentials' => false,
				'Access-Control-Max-Age'           => 3600,
			],
		];
		return $behaviors;
	}

	/**
	 * @param $data
	 *
	 * @return array
	 */
	public function success($data = [], $message = "OK", $status = 200) {
		return [
			"status"  => $status,
			"message" => $message,
			"data"    => $data,
		];
	}

	/**
	 * @param $data
	 *
	 * @return array
	 */
	public function error($message = "ERROR", $status = 400) {
		return [
			"status"  => $status,
			"message" => $message,
			"data"    => [],
		];
	}
}
