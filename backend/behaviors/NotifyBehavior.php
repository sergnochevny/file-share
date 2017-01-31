<?php


namespace backend\behaviors;


use backend\models\Company;
use backend\models\User;
use yii\base\Behavior;
use yii\base\ErrorException;
use yii\db\BaseActiveRecord;

final class NotifyBehavior extends Behavior
{
    /** @var \yii\mail\MailerInterface */
    private $mailer;

    /** @var int|\Closure */
    private $companyId;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->mailer = \Yii::$app->getMailer();
    }

    /**
     * @param \Closure $companyId
     */
    public function setCompanyId(\Closure $companyId)
    {
        $this->companyId = $companyId;
    }

    /**
     * @return int
     */
    public function getCompanyId()
    {
        return call_user_func($this->companyId, $this->owner);
    }


    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            BaseActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    /**
     *
     */
    public function afterInsert()
    {

    }

    /**
     *
     */
    public function afterUpdate()
    {

    }

    /**
     * @hint delete aka "move to history"
     */
    public function afterDelete()
    {

    }

    /**
     * @return array
     */
    private function collectAdminsMails()
    {
        $emails =  User::findByRole('admin')->select(['email'])->asArray()->all();

        return array_column($emails, 'email');
    }

    /**
     * @return array
     * @throws ErrorException
     */
    private function collectClientsMails()
    {
        $emails = User::findByRole('client')
            ->select(['email'])
            ->joinWith('company')
            ->where([Company::tableName() . '.id' => $this->getCompanyId()])
            ->asArray()
            ->all();

        return array_column($emails, 'email');
    }
}