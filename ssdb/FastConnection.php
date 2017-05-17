<?php
/**
 * FastConnect - yii2-ssdb
 *
 * @see https://github.com/jonnywang/phpssdb
 *
 * @author Jack.wu <xiaowu365@gmail.com>
 * @create_time 2015-06-02 14:29
 *
 *
 *
 */

namespace ijackwu\ssdb;

use yii\base\Component;

/**
 * Class FastConnection
 */
class FastConnection extends Component
{
    private $ssdbHandle;

    public $host = '127.0.0.1';
    public $port = 8888;
    public $timeout = 2000;
    public $password;
    public $persistentId;
    public $retryInterval;
    public $easy = true;


    public function init()
    {
        parent::init();
        $this->ssdbHandle = new \SSDB();

        if ($this->easy) {
            if ($this->persistentId && $this->retryInterval) {
                $this->ssdbHandle->connect($this->host, $this->port, $this->timeout, $this->persistentId, $this->retryInterval);
            } else {
                $this->ssdbHandle->connect($this->host, $this->port, $this->timeout);
            }

            if ($this->password) {
                $this->auth($this->password);
            }
        }
    }

    /**
     * @param $host
     * @param $port
     * @param $timeout
     * @param null $persistentId
     * @param null $retryInterval
     */
    public function connect($host, $port, $timeout, $persistentId = null, $retryInterval = null)
    {
        if ($persistentId && $retryInterval) {
            $this->ssdbHandle->connect($host, $port, $timeout, $persistentId, $retryInterval);
        } else {
            $this->ssdbHandle->connect($host, $port, $timeout);
        }
    }

    /**
     * @param $password
     * @return mixed
     * @return bool
     */
    public function auth($password)
    {
        return $this->ssdbHandle->auth($password);
    }

    /**
     * @return bool
     */
    public function ping()
    {
        return $this->ssdbHandle->ping();
    }

    /**
     * @return string|null
     */
    public function version()
    {
        return $this->ssdbHandle->version();
    }

    /**
     * @return long
     */
    public function dbsize()
    {
        return $this->ssdbHandle->dbsize();
    }

    /**
     * @param $key \SSDB::OPT_PREFIX|\SSDB::OPT_READ_TIMEOUT|\SSDB::OPT_SERIALIZER
     * @param $value
     * @return bool
     */
    public function option($key, $value)
    {
        return $this->ssdbHandle->option($key, $value);
    }

    /**
     * @param $params
     * @return array
     */
    public function request($params)
    {
        return $this->request($params);
    }

    /**
     * @param string $params
     * @return bool | null
     */
    public function write($params)
    {
        return $this->write($params);
    }

    /**
     * @param string $params
     * @return bool | null
     */
    public function read($params)
    {
        return $this->read($params);
    }

    /**
     * @param string $key
     * @param string $value
     * @param int $expire
     * @return bool
     */
    public function set($key, $value, $expire = null)
    {
        if ($expire)
            return $this->ssdbHandle->set($key, $value, $expire);
        else
            return $this->ssdbHandle->set($key, $value);
    }

    /**
     * @param $key
     * @param $value
     * @param null $expire
     * @return bool
     */
    public function setx($key, $value, $expire = null)
    {
        return $this->set($key, $value, $expire);
    }

    /**
     * @return array
     */
    public function info()
    {
        return $this->ssdbHandle->info();
    }

    /**
     * @param string $key
     * @return string|null
     */
    public function get($key)
    {
        return $this->ssdbHandle->get($key);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function del($key)
    {
        return $this->ssdbHandle->del($key);
    }

    /**
     * @param string $key
     * @param int $incrNum
     * @return long
     */
    public function incr($key, $incrNum)
    {
        return $this->ssdbHandle->incr($key, $incrNum);
    }

    /**
     * @param $key
     * @return bool
     */
    public function exists($key)
    {
        return $this->ssdbHandle->incr($key);
    }

    /**
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function setnx($key, $value)
    {
        return $this->ssdbHandle->setnx($key, $value);
    }


    /**
     * @param string $key
     * @param int $timeout
     * @return bool
     */
    public function expire($key, $timeout)
    {
        return $this->ssdbHandle->expire($key, $timeout);
    }

    /**
     * @param $key
     * @return long
     */
    public function ttl($key)
    {
        return $this->ssdbHandle->ttl($key);
    }

    /**
     * @param string $key
     * @return long
     */
    public function strlen($key)
    {
        return $this->ssdbHandle->strlen($key);
    }

    /**
     * @param string $key
     * @param int $offset
     * @param string $value
     * @return bool
     */
    public function setbit($key, $offset, $value)
    {
        return $this->ssdbHandle->setbit($key, $offset, $value);
    }

    /**
     * @param $key
     * @param $offset
     * @return mixed
     */
    public function getbit($key, $offset)
    {
        return $this->ssdbHandle->getbit($key, $offset);
    }

    /**
     * @param $key
     * @param null $start
     * @param null $size
     * @return mixed
     */
    public function countbit($key, $start = null, $size = null)
    {
        return $this->ssdbHandle->countbit($key, $start, $size);
    }

    /**
     * @param $key
     * @param null $start
     * @param null $size
     * @return mixed
     */
    public function substr($key, $start = null, $size = null)
    {
        return $this->ssdbHandle->countbit($key, $start, $size);
    }

    /**
     * @param string $startKey
     * @param string $endKey
     * @param $limit
     * @return mixed
     */
    public function keys($startKey = "", $endKey = "", $limit)
    {
        return $this->ssdbHandle->keys($startKey, $endKey, $limit);
    }

    /**
     * @param string $startKey
     * @param string $endKey
     * @param $limit
     * @return mixed
     */
    public function scan($startKey = "", $endKey = "", $limit)
    {
        return $this->ssdbHandle->scan($startKey, $endKey, $limit);
    }

    /**
     * @param string $startKey
     * @param string $endKey
     * @param $limit
     * @return mixed
     */
    public function rscan($startKey = "", $endKey = "", $limit)
    {
        return $this->ssdbHandle->rscan($startKey, $endKey, $limit);
    }

    /**
     * @param array $keyValArr
     * @return bool
     */
    public function multi_set(array $keyValArr)
    {
        return $this->ssdbHandle->multi_set($keyValArr);
    }

    /**
     * @param $keyArr
     * @return array
     */
    public function multi_get($keyArr)
    {
        return $this->ssdbHandle->multi_get($keyArr);
    }

    /**
     * @param $keyArr
     * @return array
     */
    public function multi_del($keyArr)
    {
        return $this->ssdbHandle->multi_del($keyArr);
    }

    /**
     * @param string $key
     * @param string $member
     * @return bool
     */
    public function zdel($key, $member)
    {
        return $this->ssdbHandle->zdel($key, $member);
    }

    /**
     * @param string $key
     * @param string $member
     * @param int $score
     * @return mixed
     */
    public function zset($key, $member, $score)
    {
        return $this->ssdbHandle->zset($key, $member, $score);
    }

    /**
     * @param $key
     * @param $member
     * @return long
     */
    public function zget($key, $member)
    {
        return $this->ssdbHandle->zget($key, $member);
    }

    /**
     * @param $key
     * @param $member
     * @param $score
     * @return mixed
     */
    public function zincr($key, $member, $score)
    {
        return $this->ssdbHandle->zincr($key, $member, $score);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function zsize($key)
    {
        return $this->ssdbHandle->zsize($key);
    }

    /**
     * @param string $keyStart
     * @param string $endEnd
     * @param $limit
     * @return mixed
     */
    public function zlist($keyStart = "", $endEnd = "", $limit)
    {
        return $this->ssdbHandle->zlist($keyStart = "", $endEnd = "", $limit);
    }

    /**
     * @param string $keyStart
     * @param string $endEnd
     * @param $limit
     * @return mixed
     */
    public function rzlist($keyStart = "", $endEnd = "", $limit)
    {
        return $this->ssdbHandle->rzlist($keyStart, $endEnd, $limit);
    }

    /**
     * @param $key
     * @param $member
     * @return mixed
     */
    public function zexists($key, $member)
    {
        return $this->ssdbHandle->zexists($key, $member);
    }

    /**
     * @param $key
     * @param $memberStartName
     * @param $memberStartScore
     * @param $memberEndScore
     * @param $limit
     * @return mixed
     */
    public function zkeys($key, $memberStartName, $memberStartScore, $memberEndScore, $limit)
    {
        return $this->ssdbHandle->zkeys($key, $memberStartName, $memberStartScore, $memberEndScore, $limit);
    }

    /**
     * @param $key
     * @param $memberStartName
     * @param $memberStartScore
     * @param $memberEndScore
     * @param $limit
     * @return mixed
     */
    public function zscan($key, $memberStartName, $memberStartScore, $memberEndScore, $limit)
    {
        return $this->ssdbHandle->zscan($key, $memberStartName, $memberStartScore, $memberEndScore, $limit);
    }

    /**
     * @param $key
     * @param $memberStartName
     * @param $memberStartScore
     * @param $memberEndScore
     * @param $limit
     * @return mixed
     */
    public function rzscan($key, $memberStartName, $memberStartScore, $memberEndScore, $limit)
    {
        return $this->ssdbHandle->zrscan($key, $memberStartName, $memberStartScore, $memberEndScore, $limit);
    }

    /**
     * @param $key
     * @param $member
     * @return mixed
     */
    public function zrank($key, $member)
    {
        return $this->ssdbHandle->zrank($key, $member);
    }

    /**
     * @param $key
     * @param $member
     * @return mixed
     */
    public function zrrank($key, $member)
    {
        return $this->ssdbHandle->zrrank($key, $member);
    }


    /**
     * @param $key
     * @param $offset
     * @param $limit
     * @return mixed
     */
    public function zrange($key, $offset, $limit)
    {
        return $this->ssdbHandle->zrange($key, $offset, $limit);
    }

    /**
     * @param $key
     * @param $offset
     * @param $limit
     * @return mixed
     */
    public function zrrange($key, $offset, $limit)
    {
        return $this->ssdbHandle->zrrange($key, $offset, $limit);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function zlear($key)
    {
        return $this->ssdbHandle->zlear($key);
    }

    /**
     * @param $key
     * @param $scoreStart
     * @param $scoreEnd
     * @return mixed
     */
    public function zcount($key, $scoreStart, $scoreEnd)
    {
        return $this->ssdbHandle->zcount($key, $scoreStart, $scoreEnd);
    }

    /**
     * @param $key
     * @param $scoreStart
     * @param $scoreEnd
     * @return mixed
     */
    public function zsum($key, $scoreStart, $scoreEnd)
    {
        return $this->ssdbHandle->zsum($key, $scoreStart, $scoreEnd);
    }

    /**
     * @param $key
     * @param $scoreStart
     * @param $scoreEnd
     * @return mixed
     */
    public function zavg($key, $scoreStart, $scoreEnd)
    {
        return $this->ssdbHandle->zavg($key, $scoreStart, $scoreEnd);
    }

    /**
     * @param $key
     * @param $scoreStart
     * @param $scoreEnd
     * @return mixed
     */
    public function zremrangebyscore($key, $scoreStart, $scoreEnd)
    {
        return $this->ssdbHandle->zremrangebyscore($key, $scoreStart, $scoreEnd);
    }

    /**
     * @param $key
     * @param $scoreStart
     * @param $scoreEnd
     * @return mixed
     */
    public function zremrangebyrank($key, $scoreStart, $scoreEnd)
    {
        return $this->ssdbHandle->zremrangebyrank($key, $scoreStart, $scoreEnd);
    }

    /**
     * @param $key
     * @param array $kayValArr
     * @return mixed
     */
    public function multi_zset($key, $kayValArr)
    {
        return $this->ssdbHandle->multi_zset($key, $kayValArr);
    }

    /**
     * @param $key
     * @param $kayArr
     * @return mixed
     */
    public function multi_zget($key, $kayArr)
    {
        return $this->ssdbHandle->multi_zget($key, $kayArr);
    }

    /**
     * @param $key
     * @param $kayArr
     * @return mixed
     */
    public function multi_zdel($key, $kayArr)
    {
        return $this->ssdbHandle->multi_zdel($key, $kayArr);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function zpop_front($key)
    {
        return $this->ssdbHandle->zpop_front($key);
    }

    public function zpop_back($key)
    {
        return $this->ssdbHandle->zpop_back($key);
    }

    /**
     * @param $hashKey
     * @param $key
     * @param $val
     */
    public function hset($hashKey, $key, $val)
    {
        return $this->ssdbHandle->hset($hashKey, $key, $val);
    }

    /**
     * @param $hashKey
     * @param $key
     * @return mixed
     */
    public function hget($hashKey, $key)
    {
        return $this->ssdbHandle->hget($hashKey, $key);
    }

    /**
     * @param $hashKey
     * @param $key
     * @return mixed
     */
    public function hdel($hashKey, $key)
    {
        return $this->ssdbHandle->hdel($hashKey, $key);
    }

    /**
     * @param $hashKey
     * @param $hincr
     * @return mixed
     */
    public function hincr($hashKey, $hincr)
    {
        return $this->ssdbHandle->hincr($hashKey, $hincr);
    }

    public function hexists($hashKey, $key)
    {
        return $this->ssdbHandle->hexists($hashKey, $key);
    }

    public function hsize($hashKey)
    {
        return $this->ssdbHandle->hsize($hashKey);
    }

    public function hlist($hashKey, $keyStartName = "", $keyEndName = "")
    {
        return $this->ssdbHandle->hlist($hashKey, $keyStartName, $keyEndName);
    }

    public function rhlist($hashKey, $keyStartName = "", $keyEndName = "")
    {
        return $this->ssdbHandle->rhlist($hashKey, $keyStartName, $keyEndName);
    }

    public function hkeys($hashKey, $keyStartName = "", $keyEndName = "", $limit)
    {
        return $this->ssdbHandle->hkeys($hashKey, $keyStartName, $keyEndName, $limit);
    }

    public function hgetall($hashKey)
    {
        return $this->ssdbHandle->hgetall($hashKey);
    }

    public function hscan($hashKey, $keyStartName = "", $keyEndName = "")
    {
        return $this->ssdbHandle->hscan($hashKey, $keyStartName, $keyEndName);
    }

    public function rhscan($hashKey, $keyStartName = "", $keyEndName = "")
    {
        return $this->ssdbHandle->rhscan($hashKey, $keyStartName, $keyEndName);
    }

    public function multi_hset($hashKey, $keyArrName)
    {
        return $this->ssdbHandle->multi_hset($hashKey, $keyArrName);
    }

    public function multi_hget($hashKey, $keyArr)
    {
        return $this->ssdbHandle->multi_gset($hashKey, $keyArr);
    }

    public function multi_hdel($hashKey, $keyArr)
    {
        return $this->ssdbHandle->multi_hdel($hashKey, $keyArr);
    }

    public function qsize($key)
    {
        return $this->ssdbHandle->qsize($key);
    }

    public function qlist($hashKey, $keyStartName = "", $keyEndName = "", $limit)
    {
        return $this->ssdbHandle->qlist($hashKey, $keyStartName, $keyEndName, $limit);
    }

    public function rqlist($hashKey, $keyStartName = "", $keyEndName = "", $limit)
    {
        return $this->ssdbHandle->rqlist($hashKey, $keyStartName, $keyEndName, $limit);
    }

    public function qclear($hashKey)
    {
        return $this->ssdbHandle->qclear($hashKey);
    }

    public function qpush($key, $val)
    {
        return $this->ssdbHandle->qpush($key, $val);
    }

    public function qpush_back($key, $val)
    {
        return $this->ssdbHandle->qpush_back($key, $val);
    }

    public function qpush_front($key, $val)
    {
        return $this->ssdbHandle->qpush_front($key, $val);
    }

    public function qpop($key, $limit = 1)
    {
        return $this->ssdbHandle->qpop($key, $limit);
    }

    public function qpop_back($key, $limit = 1)
    {
        return $this->ssdbHandle->qpop_back($key, $limit);
    }

    public function qpop_front($key, $limit = 1)
    {
        return $this->ssdbHandle->qpop_front($key, $limit);
    }

    public function qfront($key)
    {
        return $this->ssdbHandle->qfront($key);
    }

    public function qback($key)
    {
        return $this->ssdbHandle->qback($key);
    }

    public function qget($key, $offset = 0)
    {
        return $this->ssdbHandle->qget($key, $offset);
    }

    public function qset($key, $offset = 0, $value)
    {
        return $this->ssdbHandle->qset($key, $offset, $value);
    }

    public function qtrim_front($key, $limit = 1)
    {
        return $this->ssdbHandle->qtrim_front($key, $limit);
    }

    public function qtrim_back($key, $limit = 1)
    {
        return $this->ssdbHandle->qtrim_back($key, $limit);
    }

    public function geo_set($key, $member, $latitude, $longitude)
    {
        return $this->ssdbHandle->geo_set($key, $member, $latitude, $longitude);
    }

    public function geo_get($key, $member)
    {
        return $this->ssdbHandle->geo_get($key, $member);
    }

    public function geo_neighbour($key, $radius_meters, $return_limit = null, $zscan_limit = 2000)
    {
        if ($return_limit)
            return $this->ssdbHandle->geo_neighbour($key, $radius_meters, $return_limit, $zscan_limit);
        else
            return $this->ssdbHandle->geo_neighbour($key, $radius_meters);
    }

    public function geo_radius($key, $latitude, $longitude, $radius_meters, $return_limit = null, $zscan_limit = 2000)
    {
        if ($return_limit)
            return $this->ssdbHandle->geo_radius($key, $latitude, $longitude, $radius_meters, $return_limit , $zscan_limit);
        else
            return $this->ssdbHandle->geo_radius($key, $latitude, $longitude,$radius_meters);
    }

    public function geo_del($key, $member)
    {
        return $this->ssdbHandle->geo_del($key, $member);
    }

    public function geo_clear($key)
    {
        return $this->ssdbHandle->geo_clear($key);
    }

    public function geo_distance($key,$member, $member2 )
    {
        return $this->ssdbHandle->geo_distance($key, $member, $member2);
    }
}
