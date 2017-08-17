<?php


namespace backend\models;


use common\models\query\UndeleteableActiveQuery;
use yii\base\ErrorException;
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
 *
 *
 * @property DateTime $startDateTime
 * @property DateTime $dndDateTime
 * @property \DateInterval $dateInterval
 * @property UndeleteableActiveQuery $investigationQuery
 */
class Statistics extends Model
{
    /** @var string */
    public $dateRange;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->dateRange = 'P7D';
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
            //'P0D' => 'Today',
            //'P1D' => 'Yesterday',
            'P1D' => 'Last 24 hours',
            'P7D' => 'Last 7 days',
            'P30D' => 'Last 30 days',
            'P90D' => 'Last 90 days',
        ];
    }

    public function getAllApplicants()
    {
        return $this->getInvestigationQuery()->count();
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



    /**
     * @return \DateTime
     */
    public function getStartDateTime()
    {
        return $this->getEndDateTime()->minus($this->getDateInterval());
    }

    /**
     * @return DateTime
     */
    public function getEndDateTime()
    {
       return new DateTime();
    }

    /**
     * @return \DateInterval
     * @throws ErrorException
     */
    public function getDateInterval()
    {
        return new \DateInterval($this->dateRange);
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
     * @param int $value
     * @return float|int
     */
    public function countPercentage($value)
    {
        $allApplicants = $this->getAllApplicants();
        return $allApplicants ? round(($value / $allApplicants) * 100) : 0;
    }

    /**
     * Gets main query.
     * All queries must builds from this query if you need apply date range
     *
     * @return UndeleteableActiveQuery
     * @throws \ErrorException when validation failed
     */
    public function getInvestigationQuery()
    {
        if (!$this->validate()) {
            throw new ErrorException('Validation is failed');
        }

        return Investigation::find()
            ->andWhere([
                'between',
                'updated_at',
                $this->getStartDateTime()->getTimestamp(),
                $this->getEndDateTime()->getTimestamp()
            ]);
    }

    /**
     * @param int $status
     * @return int|string
     */
    private function countApplicantsWithStatus($status)
    {
        return $this->getInvestigationQuery()->andWhere(['status' => $status])->count();
    }
}