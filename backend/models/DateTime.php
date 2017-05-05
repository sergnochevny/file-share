<?php


namespace backend\models;

/**
 * Class DateTime
 * @package backend\models
 *
 * Implements additional methods for manipulates dates with intervals, but with no side effects
 * @see http://php.net/manual/ru/datetime.sub.php#102192
 *
 * @NOTICE: Methods minus and plus returns new instances
 */
class DateTime extends \DateTime
{
    /**
     * @param \DateInterval $interval
     * @return DateTime new instance
     */
    public function minus(\DateInterval $interval)
    {
        $dt = new static();
        $dt->setTimestamp($this->getTimestamp()); //adjust datetime from current instance
        return $dt->sub($interval);
    }

    /**
     * @param \DateInterval $interval
     * @return DateTime new instance
     */
    public function plus(\DateInterval $interval)
    {
        $dt = new static();
        $dt->setTimestamp($this->getTimestamp()); //adjust datetime from current instance
        return $dt->add($interval);
    }
}