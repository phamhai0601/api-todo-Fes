<?php

namespace app\models;
/**
 * This is the model class for table "task".
 *
 * @property int         $id
 * @property int         $user_id
 * @property string      $title
 * @property string      $desc
 * @property string|null $img
 * @property string      $status
 * @property int         $created_at
 */
class Task extends \yii\db\ActiveRecord {

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'task';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[
				[
					'title',
					'desc',
					'status',
					'user_id',
					'created_at',
				],
				'required',
			],
			[
				[
					'desc',
					'status',
				],
				'string',
			],
			[
				['created_at'],
				'integer',
			],
			[
				[
					'title',
					'img',
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
			'id'         => 'ID',
			'user_id'         => 'User ID',
			'title'      => 'Title',
			'desc'       => 'Desc',
			'img'        => 'Img',
			'status'     => 'Status',
			'created_at' => 'Created At',
		];
	}

	/**
	 * @return array
	 */
	public function apiAttribute() {
		$response          = (array) $this->attributes;
		$response["tasks"] = TaskItem::find()->where(['task_id' => $this->id])->count();
		return $response;
	}
}
