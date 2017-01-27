<?php

namespace common\models;

/**
 * This is the model class for table "file".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $size
 * @property string $parent
 * @property string $type
 * @property string $citrix_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $status
 */
class File extends AbstractUndeletableActiveRecord
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 100;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'size', 'parent', 'type', 'citrix_id', 'created_at', 'updated_at'], 'required'],
            [['description'], 'string'],
            [['size', 'created_at', 'updated_at', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['parent', 'citrix_id'], 'string', 'max' => 50],
            [['type'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'File',
            'description' => 'Description',
            'size' => 'Size',
            'parent' => 'Parent',
            'type' => 'Type',
            'citrix_id' => 'Citrix ID',
            'created_at' => 'Date',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
