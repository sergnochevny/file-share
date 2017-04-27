<?php
/**
 * Created by PhpStorm.
 * User: Serg
 * Date: 25.01.2017
 * Time: 12:48
 */

namespace backend\behaviors;


use backend\models\Company;
use backend\models\Investigation;
use common\models\UndeletableActiveRecord;
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
        if( !empty($investigations) && (count($investigations)>0)){
            $transaction = Yii::$app->db->beginTransaction();
            try{
                foreach ($investigations as $investigation){
                    if ($investigation->isNotCompleted()) {
                        throw new \Exception("There are active investigations in the company's profile.");
                    }
                    $investigation->detachBehavior('historyBehavior');
                    $res = $investigation->archive();
                    if (!$res) {
                        if ($investigation->hasErrors()) {
                            $m_errors = $investigation->errors;
                            foreach ($m_errors as $field => $f_errors) {
                                $errors[] = $field . ': ' . implode('<br>', $f_errors);
                            }
                        } else {
                            $errors = ['Don`t investigation archive!'];
                        }
                        throw new \Exception(implode('<br>', $errors));
                    }
                }

                $transaction->commit();

            } catch (\Exception $e){
                $transaction->rollBack();
                throw $e;
            }
        }

        $event->isValid = $res;
    }

    private function beforeInvestigationArchive($event)
    {
        /**
         * @var $investigation Investigation
         */
        $res = false;
        $investigation = $this->owner;
        if ($investigation->isNotCompleted()) {
            throw new \Exception("This is an active investigation");
        }
        $files = $investigation->files;
        if( !empty($files) && (count($files)>0)){
            $transaction = Yii::$app->db->beginTransaction();
            try{
                foreach ($files as $file){
                    $file->detachBehavior('historyBehavior');
                    $res = $file->archive();
                    if (!$res) {
                        if ($investigation->hasErrors()) {
                            $m_errors = $investigation->errors;
                            foreach ($m_errors as $field => $f_errors) {
                                $errors[] = $field . ': ' . implode('<br>', $f_errors);
                            }
                        } else {
                            $errors = ['Don`t file archive!'];
                        }
                        throw new \Exception(implode('<br>', $errors));
                    }
                }

                $transaction->commit();

            } catch (\Exception $e){
                $transaction->rollBack();
                throw $e;
            }
        }

        $event->isValid = $res;
    }

    private function afterCompanyArchive($event)
    {
        $event->isValid = true;
    }

    private function afterInvestigationArchive($event)
    {
        $event->isValid = true;
    }

    public function events()
    {
        return [
            UndeletableActiveRecord::EVENT_BEFORE_ARCHIVE => 'beforeArchive',
            UndeletableActiveRecord::EVENT_AFTER_ARCHIVE => 'afterArchive',
        ];
    }

    public function attach($owner)
    {
        parent::attach($owner);

        if (!($this->owner instanceof UndeletableActiveRecord)) throw new InvalidCallException("This behavior is only for UndeletableActiveRecord");

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

}