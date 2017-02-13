<?php


namespace backend\models;


use yii\base\Model;

/**
 * Class Statistics
 * @package backend\models
 *
 * @property array $dateRangeList
 * @property integer $allApplicants
 * @property integer $completedApplicants
 * @property integer $activeApplicants
 * @property integer $pendingApplicants
 */
class Statistics extends Model
{
    public $dateRange;

    public function init()
    {
        $this->dateRange = 'last_7d';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['dateRange', 'in', 'range' => array_keys($this->getDateRangeList())]
        ];
    }

    /**
     * Allowable date ranges
     *
     * @return array
     */
    public function getDateRangeList()
    {
        return [
            'today' => 'Today',
            'yesterday' => 'Yesterday',
            'last_7d' => 'Last 7 days',
            'last_1m' => 'Last 30 days',
            'last_3m' => 'Last 90 days',
        ];
    }

    public function getAllApplicants()
    {
        return Investigation::find()->count();
    }

    public function getCompletedApplicants()
    {
        return $this->countApplicantsWithStatus(Investigation::STATUS_COMPLETED);
    }

    public function getActiveApplicants()
    {
        return $this->countApplicantsWithStatus(Investigation::STATUS_IN_PROGRESS);
    }

    public function getPendingApplicants()
    {
        return $this->countApplicantsWithStatus(Investigation::STATUS_PENDING);
    }

    public function countApplicantsWithStatus($status)
    {
        return Investigation::find()->where(['status' => $status])->count();

    }

    /**
     * Counts percentage of value and round down percentage to the nearest tenth
     *
     * @param $value
     * @return float
     */
    public function getInPercentageRoundedDown($value)
    {
        $percentage = $this->countPercentage($value);

        // round down to the nearest tenth
        return floor($percentage / 10) * 10;
    }

    /**
     * Counts percentage of value and round up percentage to the nearest tenth
     *
     * @param $value
     * @return float
     */
    public function getInPercentageRoundedUp($value)
    {
        $percentage = $this->countPercentage($value);

        // round up to the nearest tenth
        return ceil($percentage / 10) * 10;
    }

    /**
     * @param $value
     * @return float|int
     */
    private function countPercentage($value)
    {
        $allApplicants = $this->getAllApplicants();
        return $allApplicants ? ($value / $allApplicants) * 100 : 0;
    }
}