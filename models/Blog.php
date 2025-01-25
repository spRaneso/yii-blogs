<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use Yii;

class Blog extends ActiveRecord
{
    public $image;

    public static function tableName()
    {
        return 'blogs';
    }

    // Define the scenarios
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    // Define the Status
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_DELETED = 'deleted';

    public static function getStatusList()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_REJECTED => 'Rejected',
        ];
    }

    // Define the rules for validation
    public function rules()
    {
        return [
            // Scenario: Create (only title, content and image are allowed)
            [['title', 'content'], 'required', 'on' => self::SCENARIO_CREATE],
            [['title', 'content'], 'string', 'on' => self::SCENARIO_CREATE],
            [['title'], 'unique', 'on' => self::SCENARIO_CREATE, 'message' => 'This title has already been taken.'],
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, gif', 'on' => self::SCENARIO_CREATE],

            // Scenario: Update (title, content and image are allowed)
            [['title', 'content'], 'required', 'on' => self::SCENARIO_UPDATE],
            [['title', 'content'], 'string', 'on' => self::SCENARIO_UPDATE],
            [['title'], 'unique', 'on' => self::SCENARIO_UPDATE, 'message' => 'This title has already been taken.', 'targetAttribute' => 'title', 'filter' => ['!=', 'id', $this->id]],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif', 'on' => self::SCENARIO_UPDATE],

            [['status'], 'in', 'range' => [self::STATUS_PENDING, self::STATUS_APPROVED, self::STATUS_REJECTED]],
        ];
    }

    // Define the scenarios method to control massive assignment
    public function scenarios()
    {
        $scenarios = parent::scenarios();

        // Scenario for Create: only allow title and content
        $scenarios[self::SCENARIO_CREATE] = ['title', 'content'];

        // Scenario for update: allow title and content
        $scenarios[self::SCENARIO_UPDATE] = ['title', 'content'];

        return $scenarios;
    }

    /**
     * Override beforeSave to automatically generate slug and user_id.
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            // Generate slug from the title
            $this->slug = Inflector::slug($this->title);

            // Set the user_id from the currently logged-in user
            $this->user_id = Yii::$app->user->id;
        }

        return parent::beforeSave($insert);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    // Method to return the status message
    public function getStatusMessage()
    {
        if ($this->status === self::STATUS_PENDING) {
            return 'Pending for Approval';
        } elseif ($this->status === self::STATUS_APPROVED) {
            return 'Approved & Published';
        } else {
            return 'Unknown Status'; // Default case for unknown statuses
        }
    }

    /**
     * Handles file upload for the blog image.
     * @return bool whether the image was successfully uploaded
     */
    public function uploadImage()
    {
        $file = $this->image;

        if ($file && $this->validate()) {
            $fileName = $this->slug . '_' . time() . '.' . $file->extension;
            $path = Yii::getAlias('@webroot/uploads/blogs/') . $fileName;

            if (!is_dir(Yii::getAlias('@webroot/uploads/blogs/'))) {
                mkdir(Yii::getAlias('@webroot/uploads/blogs/'), 0775, true);
            }

            if ($file->saveAs($path)) {
                $this->image_path = '/uploads/blogs/' . $fileName;
                return true;
            }
        }

        return false;
    }
}
