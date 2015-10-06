<?php
/*
 * Copyright (c) 2014 Eltrino LLC (http://eltrino.com)
 *
 * Licensed under the Open Software License (OSL 3.0).
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://opensource.org/licenses/osl-3.0.php
 *
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@eltrino.com so we can send you a copy immediately.
 */
namespace Diamante\EmbeddedFormBundle\Tests\Twig;

use Diamante\EmbeddedFormBundle\Twig\BackLinkExtension;

class BackLinkExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldBeConstructed()
    {
        $this->markTestSkipped("Bundle should be rewritten and tests changed according to those changes");
        $this->createBackLinkExtension();
    }

    /**
     * @test
     */
    public function shouldReturnName()
    {
        $this->markTestSkipped("Bundle should be rewritten and tests changed according to those changes");
        $this->assertEquals(
            'diamante_embedded_form_back_link_extension',
            $this->createBackLinkExtension()->getName()
        );
    }

    /**
     * @test
     */
    public function shouldReturnTwigFilter()
    {
        $this->markTestSkipped("Bundle should be rewritten and tests changed according to those changes");
        $extension = $this->createBackLinkExtension();
        $filters = $extension->getFilters();

        $this->assertCount(1, $filters);

        $backLinkFilter = $filters[0];

        $this->assertInstanceOf('Twig_SimpleFilter', $backLinkFilter);

        $this->assertEquals('diamante_back_link', $backLinkFilter->getName());
        $this->assertSame([$extension, 'backLinkFilter'], $backLinkFilter->getCallable());
    }

    /**
     * @test
     */
    public function shouldReplacePlaceholderWithProvidedUrlAndLinkText()
    {
        $this->markTestSkipped("Bundle should be rewritten and tests changed according to those changes");
        $id = uniqid('id');
        $url = uniqid('url');
        $text = uniqid('text');
        $translatedText = uniqid('translatedText');
        $originalString = 'Before link {back_link|' . $text . '} After link';
        $expectedString = 'Before link <a href="' . $url . '">' . $translatedText . '</a> After link';

        $router = $this->getMock('Symfony\Component\Routing\Router', [], [], '', false);
        $router->expects($this->once())
            ->method('generate')
            ->with('diamante_embedded_form_submit', ['id' => $id])
            ->will($this->returnValue($url));

        $translator = $this->getMock('Symfony\Component\Translation\TranslatorInterface', [], [], '', false);
        $translator->expects($this->once())
            ->method('trans')
            ->with($text)
            ->will($this->returnValue($translatedText));

        $extension = $this->createBackLinkExtension($router, $translator);
        $this->assertEquals(
            $expectedString,
            $extension->backLinkFilter($originalString, $id)
        );
    }

    /**
     * @test
     */
    public function shouldReplacePlaceholderWithProvidedUrlAndDefaultLinkText()
    {
        $this->markTestSkipped("Bundle should be rewritten and tests changed according to those changes");
        $id = uniqid('id');
        $url = uniqid('url');
        $originalString = 'Before link {back_link} After link';
        $expectedString = 'Before link <a href="' . $url . '">Back</a> After link';

        $router = $this->getMock('Symfony\Component\Routing\Router', [], [], '', false);
        $router->expects($this->once())
            ->method('generate')
            ->with('diamante_embedded_form_submit', ['id' => $id])
            ->will($this->returnValue($url));

        $translator = $this->getMock('Symfony\Component\Translation\TranslatorInterface', [], [], '', false);
        $translator->expects($this->once())
            ->method('trans')
            ->with('oro.embeddedform.back_link_default_text')
            ->will($this->returnValue('Back'));

        $extension = $this->createBackLinkExtension($router, $translator);
        $this->assertEquals(
            $expectedString,
            $extension->backLinkFilter($originalString, $id)
        );
    }

    /**
     * @test
     */
    public function shouldReturnOriginalStringWhenNoPlaceholderProvided()
    {
        $this->markTestSkipped("Bundle should be rewritten and tests changed according to those changes");
        $originalString = uniqid('any string');

        $extension = $this->createBackLinkExtension();
        $this->assertEquals(
            $originalString,
            $extension->backLinkFilter($originalString, uniqid('id'))
        );
    }

    /**
     * @param $router
     * @param $translator
     * @return BackLinkExtension
     */
    protected function createBackLinkExtension($router = null, $translator = null)
    {
        $this->markTestSkipped("Bundle should be rewritten and tests changed according to those changes");
        if (!$router) {
            $router = $this->getMock('Symfony\Component\Routing\Router', [], [], '', false);
        }
        if (!$translator) {
            $translator = $this->getMock('Symfony\Component\Translation\TranslatorInterface', [], [], '', false);
        }

        return new BackLinkExtension($router, $translator);
    }
}
