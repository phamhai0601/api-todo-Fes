<?php
/**
 * Created by FesVPN.
 * @project api-todo-app
 * @author  Pham Hai
 * @email   mitto.hai.7356@gmail.com
 * @date    27/8/2022
 * @time    2:13 PM
 */

namespace app\controllers;

use app\components\Controller;
use app\models\Task;
use app\models\TaskItem;

class TaskController extends Controller {

	/**
	 * @param string $title
	 * @param string $desc
	 */
	public function actionCreate($title = '', $desc = '') {
		$user             = \Yii::$app->user->identity;
		$_data            = [];
		$task             = new Task();
		$task->title      = $title;
		$task->status     = "new";
		$task->desc       = $title;
		$task->user_id    = $user->id;
		$task->created_at = time();
		if ($task->save()) {
			$_data["message"] = "Create task successfully.";
			return $this->success($_data);
		}
		$errorArr = array_reverse($task->firstErrors);
		return $this->error(array_pop($errorArr));
	}

	/**
	 * @return array
	 */
	public function actionList($key = '') {
		$query     = Task::find();
		$_response = [];
		if ($key !== '') {
			$query->andWhere([
				'like',
				'title',
				$key,
			]);
		}
		$taskLst = $query->all();
		if (!empty($taskLst)) {
			foreach ($taskLst as $key => $task) {
				$_response[] = $task->apiAttribute();
			}
			return $this->success($_response);
		}
		return $this->success([]);
	}

	/**
	 * @param $id
	 *
	 * @return array
	 */
	public function actionTaskDetail($id) {
		$task = Task::findOne($id);
		if ($task) {
			return $this->success($task->apiAttribute());
		}
		return $this->error("Not found");
	}

	public function actionTaskDetailList($id) {
		$taskDetailLst = TaskItem::find()->where(['task_id' => $id])->asArray()->all();
	}

	/**
	 * @throws \yii\db\StaleObjectException
	 * @throws \Throwable
	 */
	public function actionDelete($id) {
		try {
			$taskItemLst = TaskItem::find()->where(['task_id' => $id])->all();
			if (!empty($taskItemLst)) {
				foreach ($taskItemLst as $key => $taskItem) {
					$taskItem->delete();
				}
			}
			$task = Task::findOne($id);
			if ($task) {
				$task->delete();
			}
			return $this->success();
		} catch (\Exception $exception) {
			return $this->error($exception->getMessage());
		}
	}
}
