<?php


namespace backend\behaviors;


use backend\models\Company;
use backend\models\Investigation;
use backend\models\User;
use common\models\UndeleteableActiveRecord;
use yii\base\Behavior;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use yii\db\AfterSaveEvent;

class NotifyBehavior extends Behavior
{
    /** @var \yii\mail\MailerInterface */
    private $mailer;

    /** @var User current user */
    private $identity;

    /** @var int|\Closure */
    private $companyId;

    /** @var string */
    public $createTemplate = 'create';

    /** @var string */
    public $updateTemplate = 'update';

    /** @var string */
    public $completeTemplate = 'completed';

    /** @var string */
    public $archiveTemplate = 'archive';

    /** @var string */
    public $deleteTemplate = 'delete';

    /** @var string */
    public $sendFrom;

    //@todo subject ??

    /**
     * Collects required emails and sends emails with template
     *
     * @param string $template
     */
    private function sendMessagesWithTemplate($template, $destinations = ['admin' => true, 'user' => true])
    {
        $this->initialize();
        $messages = [];
        if (is_array($destinations)) {
            if (!empty($destinations['admin']) && $destinations['admin']) {
                foreach ($this->collectAdminEmails() as $email) {
                    $messages[] = $this->composeMailer('admin/' . $template)->setTo($email);
                }
            }

            if (!empty($destinations['user']) && $destinations['user']) {
                foreach ($this->collectClientEmails() as $email) {
                    $messages[] = $this->composeMailer('client/' . $template)->setTo($email);
                }
            }

            if (!empty($messages)) $this->mailer->sendMultiple($messages);
        }

    }

    /**
     * @inheritdoc
     */
    private function initialize()
    {
        $this->mailer = \Yii::$app->getMailer();
        $this->identity = \Yii::$app->getUser()->getIdentity();
        if (null == $this->identity) {
            throw new ErrorException('Current user (identity) NULL');
        }

        if (!isset($this->createTemplate, $this->updateTemplate, $this->archiveTemplate, $this->deleteTemplate)) {
            throw new ErrorException('Need set createTemplate, updateTemplate, archiveTemplate, deleteTemplate for mails');
        }

        if ($this->sendFrom instanceof \Closure) $this->sendFrom = call_user_func($this->sendFrom);
        $this->sendFrom = !empty($this->sendFrom) ? $this->sendFrom : 'noreply@example.com';
    }

    /**
     * Collects admin's emails
     *
     * @return array
     */
    private function collectAdminEmails()
    {
        $adminEmails = User::findByRole('admin')->select(['email'])->column();
        $superAdminEmails = User::findByRole('sadmin')->select(['email'])->column();

        return array_merge($adminEmails, $superAdminEmails);
    }

    /**
     * Collects client's emails
     *
     * @return array
     * @throws ErrorException
     */
    private function collectClientEmails()
    {
        $companyId = $this->getCompanyId();
        if (null === $companyId) {
            return [];
        }

        $companyTbl = Company::tableName();
        $emails = User::findByRole('user')
            ->select(["$companyTbl.id", 'email'])
            ->joinWith('company')
            ->andWhere(["$companyTbl.id" => $this->getCompanyId()])
            ->asArray()
            ->all();

        return array_column($emails, 'email');
    }

    /**
     * @param $template
     * @return \yii\mail\MessageInterface
     */
    private function composeMailer($template)
    {
        return $this->mailer->compose([
            'html' => $template . '-html',
            'text' => $template . '-text'
        ], [
            'model' => $this->owner,
            'identity' => $this->identity,
        ])->setFrom($this->sendFrom)->setSubject("Protus3 BI App Notification");
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
            UndeleteableActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            UndeleteableActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            UndeleteableActiveRecord::EVENT_AFTER_ARCHIVE => 'afterArchive',
            UndeleteableActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
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
    public function afterUpdate($event)
    {
        /**
         * @var $model ActiveRecord
         * @var $event AfterSaveEvent
         */
        $model = $this->owner;
        if (($model instanceof \common\models\Investigation) &&
            ($model->attributes['status'] == Investigation::STATUS_COMPLETED) &&
            (!empty($event->changedAttributes)) &&
            (in_array('status', array_keys($event->changedAttributes)))
        ) {
            $this->sendMessagesWithTemplate($this->completeTemplate, ['admin'=>true, 'user' => true]);
        } else $this->sendMessagesWithTemplate($this->updateTemplate);
    }

    /**
     *
     */
    public function afterArchive()
    {
        $this->sendMessagesWithTemplate($this->archiveTemplate);
    }

    /**
     *
     */
    public function afterDelete()
    {
        $this->sendMessagesWithTemplate($this->deleteTemplate);
    }
}