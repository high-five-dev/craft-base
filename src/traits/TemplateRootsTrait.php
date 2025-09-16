<?php

namespace highfive\base\traits;

use craft\base\Event;
use craft\events\RegisterTemplateRootsEvent;
use craft\web\View;
use const DIRECTORY_SEPARATOR;

trait TemplateRootsTrait
{
    private function registerTemplateRoots(): void
    {
        Event::on(
            View::class,
            View::EVENT_REGISTER_SITE_TEMPLATE_ROOTS,
            function (RegisterTemplateRootsEvent $event) {
                $dir = $this->getBasePath() . DIRECTORY_SEPARATOR . 'templates';

                if (!is_dir($dir)) {
                    return;
                }
                $event->roots[$this->handle] = $dir;
            }
        );
    }
}
