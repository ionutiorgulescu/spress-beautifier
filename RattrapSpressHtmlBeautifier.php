<?php

use Yosymfony\Spress\Core\Plugin\PluginInterface;
use Yosymfony\Spress\Core\Plugin\EventSubscriber;
use Yosymfony\Spress\Core\Plugin\Event\EnvironmentEvent;
use Yosymfony\Spress\Core\Plugin\Event\RenderEvent;

class RattrapSpressHtmlBeautifier implements PluginInterface
{
    private $io;
    private $excluded_files = ['.htaccess', 'CNAME', 'robots.txt', 'crossdomain.xml', 'sitemap.xml', 'rss.xml'];

    public function initialize(EventSubscriber $subscriber)
    {
        $subscriber->addEventListener('spress.start', 'onStart');
        $subscriber->addEventListener('spress.after_render_page', 'onAfterRenderPage');
    }

    public function getMetas()
    {
        return [
            'name' => 'rattrap/spress-html-beautifier',
            'description' => 'Beautify your HTML',
            'author' => 'Leonard Mocanu',
            'license' => 'MIT',
        ];
    }

    public function onStart(EnvironmentEvent $event)
    {
        $this->io = $event->getIO();

        $configValues = $event->getConfigValues();

        if (isset($configValues['html_beautifier_excluded'])) {
            $this->excluded_files = $configValues['html_beautifier_exclude'];
        }
    }

    public function onAfterRenderPage(RenderEvent $event)
    {
        $id = $event->getId();
        if ($this->isExcluded($id)) {
            return;
        }

        $this->io->write('Beautifying HTML: '.$event->getId());
        $event->setContent(\Mihaeu\HtmlFormatter::format($event->getContent()));
    }

    private function isExcluded($id)
    {
        if (in_array($id, $this->excluded_files) || preg_match('/(.*)?\.(jpe?g|png|gif|ico|svg|psd|tiff|webm|mov|avi|mkv|mp4)$/i', $id)) {
            return true;
        }

        return false;
    }
}
