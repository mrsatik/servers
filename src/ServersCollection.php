<?php
namespace mrsatik\Servers;

use Countable;
use InvalidArgumentException;
use Iterator;
use mrsatik\Servers\ServersCollectionInterface;

class ServersCollection implements
    ServersCollectionInterface,
    Iterator,
    Countable
{
    /**
     * Коллекция объектов серверов
     * @var array
     */
    private $servers = [];

    /**
     * @var int
     */
    private $position;

    public function __construct(?string $serverString)
    {
        if ($serverString === '' || $serverString === null) {
            throw new InvalidArgumentException('Server connection string is empty or not a string');
        }

        $this->rewind();
        $match = [];

        if ($this->serverConfigIsNew($serverString) === false) {
            preg_match_all('/(?:,*)(?P<host>[^\:,]+)\:(?P<port>[^\:,]*)\:(?P<password>[^\:,]*)(?:,*)/iu', $serverString, $match);
        } else {
            preg_match_all('/(?:,*)(?P<host>[^\:,]+)\:(?P<port>[^\:,]*)\:(?P<user>[^\:,]*)\:(?P<password>[^\:,]*)(?:,*)/iu', $serverString, $match);
        }
        if ($match !== [] && array_key_exists('host', $match)) {
            foreach ($match[0] as $k => $value) {
                if (isset($match['host'][$k])) {
                    if (!isset($match['user'][$k])) {
                        $this->servers[] = new Server($match['host'][$k], $match['port'][$k], null, $match['password'][$k]);
                    } else {
                        $this->servers[] = new Server($match['host'][$k], $match['port'][$k], $match['user'][$k], $match['password'][$k]);
                    }
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     * @see Iterator::rewind()
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @return ServerInterface
     */
    public function current()
    {
        return $this->servers[$this->position];
    }

    /**
     * {@inheritDoc}
     * @see Iterator::key()
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * {@inheritDoc}
     * @see Iterator::next()
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * {@inheritDoc}
     * @see Iterator::valid()
     */
    public function valid()
    {
        return isset($this->servers[$this->position]);
    }

    /**
     * {@inheritDoc}
     * @see Countable::count()
     */
    public function count()
    {
        return count($this->servers);
    }

    /**
     * Определяет формат конфига - новый или нет
     * @param string $serverString
     * @return bool
     *
     * @TODO: убрать проверку
     */
    private function serverConfigIsNew(string $serverString): bool
    {
        $servers = explode(',', $serverString);
        if (isset($servers[0])) {
            if (substr_count($servers[0], ':') === 3) {
                return true;
            }
        }
        return false;
    }

    private function __clone() { }
}
