<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-12-26
 * Time: 下午3:23
 */

namespace backend\models;

use common\base\BaseModel;
use yii\rbac\Rule;
use Yii;


class BizRule extends BaseModel
{
    /**
     * @var  rule 名称
     */
    public $name;

    public $createdAt;

    public $updatedAt;

    /**
     * @var string Rule classname.
     */
    public $className;

    /**
     * @var Rule
     */
    private $_item;

    /**
     * Initilaize object
     * @param \yii\rbac\Rule $item
     * @param array $config
     */
    public function __construct($item, $config = [])
    {
        $this->_item = $item;
        if ($item !== null) {
            $this->name = $item->name;
            $this->className = get_class($item);
            $this->updatedAt=$item->updatedAt;
            $this->createdAt=$item->createdAt;
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'className'], 'required'],
            [['name'], 'uniques', 'when' => function() {
                return $this->isNewRecord || ($this->_item->name != $this->name);
            }],
            [['className'], 'string'],
            [['className'], 'classExists']
        ];
    }

    /**
     * Check per is unique
     */
    public function uniques()
    {
        $authManager = Yii::$app->authManager;
        $value = $this->name;
        if ($authManager->getRule($value) !== null ) {
            $message = "请确认规则名称唯一";
            $params = [
                'attribute' => $this->getAttributeLabel('name'),
                'value' => $value,
            ];
            $this->addError('name', Yii::$app->getI18n()->format($message, $params, Yii::$app->language));
        }
    }

    /**
     * Validate class exists
     */
    public function classExists()
    {
        if (!class_exists($this->className)) {
            $message ="Class {$this->className}不存在";
            $this->addError('className', $message);
            return;
        }
        if (!is_subclass_of($this->className, Rule::class)) {

            $message="Class{$this->className} 必须为'yii\rbac\Rule'的子类";
            $this->addError('className', $message);
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' =>'规则名称',
            'className' =>'Class Name',
        ];
    }

    /**
     * Check if new record.
     * @return boolean
     */
    public function getIsNewRecord()
    {
        return $this->_item === null;
    }

    /**
     * Find model by id
     * @param int $id
     * @return null|static
     */
    public static function find($id)
    {
        $item = Yii::$app->getAuthManager()->getRule($id);
        if ($item !== null) {
            return new static($item);
        }

        return null;
    }

    /**
     * Save model to authManager
     * @return boolean
     * @throws
     */
    public function save()
    {
        if ($this->validate()) {
            $manager = Yii::$app->getAuthManager();
            $class = $this->className;
            if ($this->_item === null) {
                $this->_item = new $class();
                $isNew = true;
            } else {
                $isNew = false;
                $oldName = $this->_item->name;
            }
            $this->_item->name = $this->name;

            if ($isNew) {
                $manager->add($this->_item);
            } else {
                $manager->update($oldName, $this->_item);
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Get item
     * @return mixed
     * @throws
     */
    public function getItem()
    {
        return $this->_item;
    }
}
