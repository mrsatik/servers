<?php

namespace mrsatik\Servers;

interface ServerInterface
{
    /**
     * Данные по хосту подключения
     * @return string
     */
    public function getHost(): string;

    /**
     * Порт подключения к серверу. Опционален.
     * @return string|null
     */
    public function getPort(): ?string;

    /**
     * Пароль подключения к серверу. Опционален.
     * @return string|null
     */
    public function getPassword(): ?string;

    /**
     * Пользователь для подключения к серверу. Опционален.
     * @return string|null
     */
    public function getUser(): ?string;
}