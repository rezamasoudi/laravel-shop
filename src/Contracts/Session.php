<?php

namespace Masoudi\Laravel\Shop\Contracts;

interface Session
{
    /**
     * Set session name
     *
     * @param string $sessionName
     * @return void
     */
    public function setSession(string $sessionName): void;

    /**
     * Get session name
     *
     * @return string
     */
    public function getSessionName(): string;
}