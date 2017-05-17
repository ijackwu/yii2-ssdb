<?php
/**
 * Cache.php - yii2-ssdb
 *
 * @author Jack.wu <xiaowu365@gmail.com>
 * @create_time 2015-06-14 12:24
 *
 *  * To use Ssdb Cache as the cache application component, configure the application as follows,
 *
 * ~~~
 * [
 *     'components' => [
 *         'cache' => [
 *             'class' => 'ijackwu\ssdb\Cache',
 *             'ssdb' => [
 *                 'host' => 'localhost',
 *                 'port' => 8888,
 *                 // 'passwd' => 'passowd',
 *             ]
 *         ],
 *     ],
 * ]
 * ~~~
 *
 * Or if you have configured the Ssdb [[Connection]] as an application component, the following is sufficient:
 *
 * ~~~
 * [
 *     'components' => [
 *         'cache' => [
 *             'class' => 'ijackwu\ssdb\Cache',
 *             // 'ssdb' => 'ssdb' // id of the connection application component
 *         ],
 *     ],
 * ]
 * ~~~
 */


namespace ijackwu\ssdb;

class Cache extends \yii\caching\Cache
{
    /**
     *
     * @var Ssdb
     */
    public $ssdb = 'ssdb';

    private $ssdbHandle;

    /**
     * @var string
     */
    public $cache_keys_hash = '_ssdb_cache_key_hash';

    /**
     * @var bool
     */
    public $is_unserialize = false;


    public function init()
    {
        parent::init();

        if (is_string($this->ssdb)) {
            $this->ssdbHandle = \Yii::$app->get($this->ssdb);
        } elseif (is_array($this->ssdb)) {
            if (!isset($this->ssdb['class'])) {
                $this->ssdb['class'] = 'ijackwu\ssdb\Connection';
            }
            $this->ssdbHandle = \Yii::createObject($this->ssdb);
        }

        if (!$this->ssdbHandle instanceof Connection && !$this->ssdbHandle instanceof FastConnection) {
            throw new Exception("Cache::ssdb must be either a Ssdb Connection instance or the application component ID of a ssdb Connection.");
        }

        if ($this->cache_keys_hash === "") {
            $this->cache_keys_hash = substr(md5(Yii::$app->id), 0, 5) . "___";
        }

    }

    public function getkeys()
    {
        return $this->ssdbHandle->hkeys($this->cache_keys_hash, "", "", $this->ssdbHandle->hsize($this->cache_keys_hash));
    }

    /**
     * Retrieves a value from cache with a specified key.
     * This is the implementation of the method declared in the parent class.
     * @param string $key a unique key identifying the cached value
     * @return string|boolean the value stored in cache, false if the value is not in the cache or expired.
     */
    protected function getValue($key)
    {
        $data = $this->ssdbHandle->get($key);
        return $this->is_unserialize ? unserialize($data) : $data;
    }

    /**
     * Stores a value identified by a key in cache.
     * This is the implementation of the method declared in the parent class.
     * @param string $key the key identifying the value to be cached
     * @param string $value the value to be cached
     * @param integer $expire the number of seconds in which the cached value will expire. 0 means never expire.
     * @return boolean true if the value is successfully stored into cache, false otherwise
     */
    public function setValue($key, $value, $expire)
    {
        $this->ssdbHandle->hset($this->cache_keys_hash, $key, 1);
        $data = $this->is_unserialize ? serialize($value) : $value;
        if ($expire > 0) {
            //$expire += time();
            return $this->ssdbHandle->setx($key, $data, (int)$expire);
        } else {
            return $this->ssdbHandle->set($key, $data);
        }
    }

    /**
     * Stores a value identified by a key into cache if the cache does not contain this key.
     * This is the implementation of the method declared in the parent class.
     * @param string $key the key identifying the value to be cached
     * @param string $value the value to be cached
     * @param integer $expire the number of seconds in which the cached value will expire. 0 means never expire.
     * @return boolean true if the value is successfully stored into cache, false otherwise
     */
    protected function addValue($key, $value, $expire)
    {
        return $this->setValue($key, $value, $expire);
    }

    /**
     * Deletes a value with the specified key from cache
     * This is the implementation of the method declared in the parent class.
     * @param string $key the key of the value to be deleted
     * @return boolean if no error happens during deletion
     */
    public function deleteValue($key)
    {
        $this->ssdbHandle->hdel($this->cache_keys_hash, $key);
        return $this->ssdbHandle->del($key);
    }

    /**
     * @return boolean whether the flush operation was successful.
     */
    protected function flushValues()
    {
        $this->ssdbHandle->multi_del($this->getkeys());
        return $this->ssdbHandle->hclear($this->cache_keys_hash);
    }
} 
