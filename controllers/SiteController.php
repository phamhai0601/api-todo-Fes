<?php

namespace app\controllers;

use app\components\Controller;
use app\models\User;

class SiteController extends Controller {

	public function behaviors() {
		$behaviors                            = parent::behaviors();
		$behaviors['authenticator']['except'] = [
			'index',
			'login',
		];
		return $behaviors;
	}

	/**
	 * Displays homepage.
	 *
	 * @return array
	 */
	public function actionIndex() {
		$_data["app_name"] = "To do list";
		$_data["version"]  = "v1";
		$_data['author']   = "Pham Hai";
		return $this->success($_data);
	}

	/**
	 * @param $email
	 * @param $password
	 *
	 * @return array
	 */
	public function actionLogin($email, $password) {
		$user = User::findOne(['email' => $email]);
		if ($user) {
			if ($user->validatePassword($password)) {
				return $this->success((array) $user->attributes);
			}
			return $this->error("Please check again your email and password");
		}
		return $this->error("This account doesn't exist");
	}

	/**
	 * @return array
	 */
	public function actionInfo() {
		/** @var User $user */
		$user = \Yii::$app->user->identity;
		if ($user) {
			return $this->success($user->apiAttribute());
		}
		return $this->error();
	}
}
