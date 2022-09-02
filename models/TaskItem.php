<?php

namespace app\models;
/**
 * This is the model class for table "task_item".
 *
 * @property int    $id
 * @property int    $task_id
 * @property string $title
 * @property string $description
 * @property string $status
 * @property int    $created_at
 */
class TaskItem extends \yii\db\ActiveRecord {

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'task_item';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[
				[
					'task_id',
					'title',
					'description',
					'status',
					'created_at',
				],
				'required',
			],
			[
				[
					'task_id',
					'created_at',
				],
				'integer',
			],
			[
				['description'],
				'string',
			],
			[
				[
					'title',
					'status',
				],
				'string',
				'max' => 255,
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id'          => 'ID',
			'task_id'     => 'Task ID',
			'title'       => 'Title',
			'description' => 'Description',
			'status'      => 'Status',
			'created_at'  => 'Created At',
		];
	}

	/**
	 * @return array
	 */
	public function apiAttribute() {
		$response                     = (array) $this->attributes;
		$response["created_at_until"] = date("Y-m-d H:i:s", $this->created_at);
		return $response;
	}

	/**
	 * @return int
	 */
	public function success() {
		return $this->updateAttributes(['status' => 'success']);
	}

	/**
	 * @return int
	 */
	public function renew(){
		return $this->updateAttributes(['status' => 'new']);
	}
}
