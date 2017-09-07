<?php
/**
 * Created by PhpStorm.
 * User: Serg
 * Date: 25.01.2017
 * Time: 12:48
 */

namespace common\behaviors;


use common\models\Company;
use common\models\File;
use common\models\Investigation;
use common\models\RecoverableActiveRecord;
use common\models\UndeleteableActiveRecord;
use Yii;
use yii\base\Behavior;
use yii\base\InvalidCallException;

class ArchiveCascadeBehavior extends Behavior
{

    private function beforeCompanyArchive($event)
    {
        /**
         * @var $company Company
         */
        $res = false;
        $company = $this->owner;
        $investigations = $company->investigations;
        if (!empty($investigations) && (count($investigations) > 0)) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($investigations as $investigation) {
                    if (!$investigation->isDeleted()) {
                        if (!$investigation->isArchivable()) {
                            throw new \Exception("There are active investigations in the company's profile.");
                        }
                        $investigation->detachBehavior('historyBehavior');
                        $res = $investigation->archive();
                    } else $res = true;
                }

                $transaction->commit();

            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        } else $res = true;

        return $event->isValid = $res;
    }

    private function beforeInvestigationArchive($event)
    {
        /**
         * @var $investigation Investigation
         */
        $res = false;
        $investigation = $this->owner;
        if (!$investigation->isArchivable()) {
            throw new \Exception('Investigation: "' . $investigation->fullName . '" is unfinished.');
        }
        $files = $investigation->files;
        if (!empty($files) && (count($files) > 0)) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($files as $file) {
                    if (!$file->isDeleted()) {
                        if (!$file->isArchivable()) {
                            throw new \Exception('File: "' . $file->name . '" doesn`t archiving');
                        }
                        $file->detachBehavior('historyBehavior');
                        $res = $file->archive();
                    } else $res = true;
                }

                $transaction->commit();

            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        } else $res = true;

        return $event->isValid = $res;
    }

    private function afterCompanyRecover($event)
    {
        /**
         * @var $company Company
         */
        $res = false;
        $company = $this->owner;
        $investigations = $company->investigationsWh;
        if (!empty($investigations) && (count($investigations) > 0)) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($investigations as $investigation) {
                    if (!$investigation->isDeleted()) {
                        $res = $investigation->recover();
                    } else $res = true;
                }

                $transaction->commit();

            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        } else $res = true;

        return $event->isValid = $res;
    }

    private function afterInvestigationRecover($event)
    {
        /**
         * @var $investigation Investigation
         */
        $res = false;
        $investigation = $this->owner;
        $files = $investigation->filesWh;
        if (!empty($files) && (count($files) > 0)) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($files as $file) {
                    if (!$file->isDeleted()) {
                        $res = $file->recover();
                    } else $res = true;
                }

                $transaction->commit();

            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        } else $res = true;

        return $event->isValid = $res;
    }

    private function beforeFileRecover($event)
    {
        /**
         * @var $file File
         */
        $file = $this->owner;
        if (!$file->isDeleted()) {
            if (!$file->isRecoverable()) {
                throw new \Exception('File: "' . $file->name . '" doesn`t to recover.');
            }
            $res = true;
        } else $res = true;

        return $event->isValid = $res;
    }

    private function afterCompanyArchive($event)
    {
        return $event->isValid = true;
    }

    private function afterInvestigationArchive($event)
    {
        return $event->isValid = true;
    }

    private function beforeCompanyRecover($event)
    {
        $company = $this->owner;
        if (!$company->isRecoverable()) {
            throw new \Exception('Company: "' . $company->name . '" doesn`t to recover.');
        }

        return $event->isValid = true;
    }

    private function beforeInvestigationRecover($event)
    {
        $investigation = $this->owner;
        if (!$investigation->isRecoverable()) {
            throw new \Exception('Investigation: "' . $investigation->fullName . '" doesn`t to recover.');
        }
        return $event->isValid = true;
    }

    private function afterFileRecover($event)
    {
        return $event->isValid = true;
    }

    public function events()
    {
        return [
            UndeleteableActiveRecord::EVENT_BEFORE_ARCHIVE => 'beforeArchive',
            UndeleteableActiveRecord::EVENT_AFTER_ARCHIVE => 'afterArchive',
            RecoverableActiveRecord::EVENT_BEFORE_RECOVER => 'beforeRecover',
            RecoverableActiveRecord::EVENT_AFTER_RECOVER => 'afterRecover',
        ];
    }

    public function attach($owner)
    {
        parent::attach($owner);

        if (!($this->owner instanceof UndeleteableActiveRecord)) throw new InvalidCallException("This behavior is only for UndeletableActiveRecord");

    }

    public function afterArchive($event)
    {
        if ($this->owner instanceof Company) {
            return $this->afterCompanyArchive($event);
        } elseif ($this->owner instanceof Investigation) {
            return $this->afterInvestigationArchive($event);
        }

    }

    public function beforeArchive($event)
    {
        if ($this->owner instanceof Company) {
            return $this->beforeCompanyArchive($event);
        } elseif ($this->owner instanceof Investigation) {
            return $this->beforeInvestigationArchive($event);
        }

    }

    public function afterRecover($event)
    {
        if ($this->owner instanceof Company) {
            return $this->afterCompanyRecover($event);
        } elseif ($this->owner instanceof Investigation) {
            return $this->afterInvestigationRecover($event);
        } elseif ($this->owner instanceof File) {
            return $this->afterFileRecover($event);
        }

    }

    public function beforeRecover($event)
    {
        if ($this->owner instanceof Company) {
            return $this->beforeCompanyRecover($event);
        } elseif ($this->owner instanceof Investigation) {
            return $this->beforeInvestigationRecover($event);
        } elseif ($this->owner instanceof File) {
            return $this->beforeFileRecover($event);
        }
    }
}