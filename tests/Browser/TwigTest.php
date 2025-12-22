<?php

namespace DebugBar\Bridge\Twig\Tests\Browser;


class TwigTest extends AbstractBrowserTestcase
{
    public function testTwigCollector(): void
    {
        $client = static::createPantherClient();

        $client->request('GET', '/demo/');

        // Wait for Debugbar to load
        $crawler = $client->waitFor('.phpdebugbar-body');
        usleep(1000);

        if (!$this->isTabActive($crawler, 'twig')) {
            $client->click($this->getTabLink($crawler, 'twig'));
        }

        $crawler = $client->waitForVisibility('.phpdebugbar-panel[data-collector=twig]');

        $statements = $crawler->filter('.phpdebugbar-panel[data-collector=twig] .phpdebugbar-widgets-name')
            ->each(function($node){
                return $node->getText();
            });

        $this->assertEquals('foobar.html', $statements[1]);
        $this->assertCount(1, $statements);
    }
}
