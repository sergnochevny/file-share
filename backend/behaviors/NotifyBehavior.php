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

    /** @var string */
    public $createTemplate;

    /** @var string */
    public $updateTemplate;

    /** @var string */
    public $deleteTemplate;

    /** @var string */
    public $sendFrom;

    //@todo subject ??

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->mailer = \Yii::$app->getMailer();

        if (!isset($this->createTemplate, $this->updateTemplate, $this->deleteTemplate)) {
            throw new \ErrorException('Need set createTemplate, updateTemplate, deleteTamplate for mails');
        }

        $this->sendFrom = isset($this->sendFrom) ? $this->sendFrom : 'noreply@' . \Yii::$app->getHomeUrl();
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
        $this->sendMessagesWithTemplate($this->createTemplate);
    }

    /**
     *
     */
    public function afterUpdate()
    {
        $this->sendMessagesWithTemplate($this->updateTemplate);
    }

    /**
     * @hint delete aka "move to history"
     */
    public function afterDelete()
    {
        $this->sendMessagesWithTemplate($this->deleteTemplate);
    }

    /**
     * Collects admin's emails
     *
     * @return array
     */
    private function collectAdminsEmails()
    {
        $emails =  User::findByRole('admin')->select(['email'])->asArray()->all();

        return array_column($emails, 'email');
    }

    /**
     * Collects client's emails
     *
     * @return array
     * @throws ErrorException
     */
    private function collectClientsEmails()
    {
        $emails = User::findByRole('client')
            ->select(['email'])
            ->joinWith('company')
            ->where([Company::tableName() . '.id' => $this->getCompanyId()])
            ->asArray()
            ->all();

        return array_column($emails, 'email');
    }

    /**
     * Collects required emails and sends emails with template
     *
     * @param string $template
     */
    private function sendMessagesWithTemplate($template)
    {
        $emails = array_merge($this->collectAdminsEmails(), $this->collectClientsEmails());

        $messages = [];
        foreach ($emails as $email) {
            $messages[] = $this->mailer->compose([
                'html' => $template . '-html',
                'text' => $template . '-text'
            ], [
                'model' => $this->owner
            ])->setTo($email);
        }

        $this->mailer->sendMultiple($messages);
    }
}