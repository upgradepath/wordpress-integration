<?php

namespace Upgradepath\Cron;

abstract class Cronjob
{
    abstract public function handle();

    abstract public function deactivate();
}
