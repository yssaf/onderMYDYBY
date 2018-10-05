<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog\Handler;

/**
 * Used for testing purposes.
 *
 * It records all records and gives you access to them for verification.
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 *
 * @method bool hasEmergency($record)
 * @method bool hasAlert($record)
 * @method bool hasCritical($record)
 * @method bool hasError($record)
 * @method bool hasWarning($record)
 * @method bool hasNotice($record)
 * @method bool hasInfo($record)
 * @method bool hasDebug($record)
 *
 * @method bool hasEmergencyRecords()
 * @method bool hasAlertRecords()
 * @method bool hasCriticalRecords()
 * @method bool hasErrorRecords()
 * @method bool hasWarningRecords()
 * @method bool hasNoticeRecords()
 * @method bool hasInfoRecords()
 * @method bool hasDebugRecords()
 *
 * @method bool hasEmergencyThatContains($messages)
 * @method bool hasAlertThatContains($messages)
 * @method bool hasCriticalThatContains($messages)
 * @method bool hasErrorThatContains($messages)
 * @method bool hasWarningThatContains($messages)
 * @method bool hasNoticeThatContains($messages)
 * @method bool hasInfoThatContains($messages)
 * @method bool hasDebugThatContains($messages)
 *
 * @method bool hasEmergencyThatMatches($messages)
 * @method bool hasAlertThatMatches($messages)
 * @method bool hasCriticalThatMatches($messages)
 * @method bool hasErrorThatMatches($messages)
 * @method bool hasWarningThatMatches($messages)
 * @method bool hasNoticeThatMatches($messages)
 * @method bool hasInfoThatMatches($messages)
 * @method bool hasDebugThatMatches($messages)
 *
 * @method bool hasEmergencyThatPasses($messages)
 * @method bool hasAlertThatPasses($messages)
 * @method bool hasCriticalThatPasses($messages)
 * @method bool hasErrorThatPasses($messages)
 * @method bool hasWarningThatPasses($messages)
 * @method bool hasNoticeThatPasses($messages)
 * @method bool hasInfoThatPasses($messages)
 * @method bool hasDebugThatPasses($messages)
 */
class TestHandler extends AbstractProcessingHandler
{
    protected $records = array();
    protected $recordsByLevel = array();

    public function getRecords()
    {
        return $this->records;
    }

    public function clear()
    {
        $this->records = array();
        $this->recordsByLevel = array();
    }

    public function hasRecords($level)
    {
        return isset($this->recordsByLevel[$level]);
    }

    public function hasRecord($record, $level)
    {
        if (is_array($record)) {
            $record = $record['messages'];
        }

        return $this->hasRecordThatPasses(function ($rec) use ($record) {
            return $rec['messages'] === $record;
        }, $level);
    }

    public function hasRecordThatContains($message, $level)
    {
        return $this->hasRecordThatPasses(function ($rec) use ($message) {
            return strpos($rec['messages'], $message) !== false;
        }, $level);
    }

    public function hasRecordThatMatches($regex, $level)
    {
        return $this->hasRecordThatPasses(function ($rec) use ($regex) {
            return preg_match($regex, $rec['messages']) > 0;
        }, $level);
    }

    public function hasRecordThatPasses($predicate, $level)
    {
        if (!is_callable($predicate)) {
            throw new \InvalidArgumentException("Expected a callable for hasRecordThatSucceeds");
        }

        if (!isset($this->recordsByLevel[$level])) {
            return false;
        }

        foreach ($this->recordsByLevel[$level] as $i => $rec) {
            if (call_user_func($predicate, $rec, $i)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        $this->recordsByLevel[$record['level']][] = $record;
        $this->records[] = $record;
    }

    public function __call($method, $args)
    {
        if (preg_match('/(.*)(Debug|Info|Notice|Warning|Error|Critical|Alert|Emergency)(.*)/', $method, $matches) > 0) {
            $genericMethod = $matches[1] . ('Records' !== $matches[3] ? 'Record' : '') . $matches[3];
            $level = constant('Monolog\Logger::' . strtoupper($matches[2]));
            if (method_exists($this, $genericMethod)) {
                $args[] = $level;

                return call_user_func_array(array($this, $genericMethod), $args);
            }
        }

        throw new \BadMethodCallException('Call to undefined method ' . get_class($this) . '::' . $method . '()');
    }
}
