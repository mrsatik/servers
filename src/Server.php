<?php

namespace mrsatik\Servers;

use mrsatik\Servers\ServerInterface;

class Server implements ServerInterface
{
    /**
     * Хост сервера
     * @var string
     */
    private $host;

    /**
     * Порт соединения
     * @var string|null
     */
    private $port;

    /**
     * Пароль для авторизации
     * @var string|null
     */
    private $password;

    /**
     * Пользователь для авторизации
     * @var string|null
     */
    private $user;

    /**
     *
     * @param string $host хост сервера
     * @param null|string $port порт подключения
     * @param null|string $password пароль или токен
     */
    public function __construct(string $host, ?string $port = null, ?string $user = null, ?string $password = null)
    {
        $this->host = $host;
        $this->port = $port !== null && trim($port) !== '' ? $port : null;
        $this->user = $user !== null && trim($user) !== '' ? $user : null;
        $this->password = $password !== null && trim($password) !== '' ? $password : null;
    }

    /**
     * {@inheritDoc}
     * @see ServerInterface::getHost()
     */
    final public function getHost(): string
    {
        return $this->host;
    }

    /**
     * {@inheritDoc}
     * @see ServerInterface::getPort()
     */
    final public function getPort(): ?string
    {
        return $this->port;
    }

    /**
     * {@inheritDoc}
     * @see ServerInterface::getUser()
     */
    final public function getUser(): ?string
    {
        return $this->user;
    }

    /**
     * {@inheritDoc}
     * @see ServerInterface::getPassword()
     */
    final public function getPassword(): ?string
    {
        return $this->password;
    }

    private function __clone() { }
}
