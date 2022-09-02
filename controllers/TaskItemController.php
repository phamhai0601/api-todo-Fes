<?php
/**
 * Created by FesVPN.
 * @project api-todo-app
 * @author  Pham Hai
 * @email   mitto.hai.7356@gmail.com
 * @date    29/8/2022
 * @time    12:21 AM
 */

namespace app\controllers;

use app\components\Controller;
use app\models\TaskItem;

class TaskItemController extends Controller {

	/**
	 * @param        $title
	 * @param string $desc
	 * @param        $task_id
	 *
	 * @return array
	 */
	public function actionCreate($title, $desc = '', $task_id) {
		$taskItem              = new TaskItem();
		$taskItem->task_id     = $task_id;
		$taskItem->title       = $title;
		$taskItem->description = $desc;
		$taskItem->status      = "new";
		$taskItem->created_at  = time();
		if ($taskItem->save()) {
			return $this->success([], "Create task successfully.");
		}
		$errorArr = array_reverse($taskItem->firstErrors);
		return $this->error(array_pop($errorArr));
	}

	/**
	 * @param $taskID
	 *
	 * @return array
	 */
	public function actionList($taskID) {
		$taskItemLst = TaskItem::find()->where(['task_id' => $taskID])->orderBy(['created_at' => SORT_DESC])->all();
		$_response   = [];
		if (!empty($taskItemLst)) {
			foreach ($taskItemLst as $key => $taskItem) {
				$_response[] = $taskItem->apiAttribute();
			}
			return $this->success($_response);
		}
		return $this->success();
	}

	/**
	 * @param $id
	 *
	 * @return array
	 * @throws \Throwable
	 * @throws \yii\db\StaleObjectException
	 */
	public function actionDelete($id) {
		$taskItem = TaskItem::findOne($id);
		if ($taskItem) {
			$taskItem->delete();
			return $this->success([], "Delete task item successfully.");
		}
		return $this->error("Not found task item.");
	}

	/**
	 * @param $id
	 *
	 * @return array
	 */
	public function actionSuccess($id) {
		$taskItem = TaskItem::findOne($id);
		if ($taskItem) {
			$taskItem->success();
			return $this->success([], "Task Item is successfully.");
		}
		return $this->error("Not found task item.");
	}

	/**
	 * @param $id
	 *
	 * @return array
	 */
	public function actionRenew($id) {
		$taskItem = TaskItem::findOne($id);
		if ($taskItem) {
			$taskItem->renew();
			return $this->success([], "Renew Task Item is successfully.");
		}
		return $this->error("Not found task item.");
	}
}
