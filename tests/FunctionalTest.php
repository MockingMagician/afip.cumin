<?php

namespace Mmatweb\Cumin\Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;

class FunctionalTest extends TestCase
{
    /**
     * @var RemoteWebDriver
     */
    private $webDriver;

    /**
     * @var string
     */
    private $baseUrl = 'https://netbeans.org';

    public function test check title()
    {
        $options = (new ChromeOptions())->addArguments([
            '--disable-gpu',
            '--window-size=1200,800'
        ]);

        $desiredCapabilities = DesiredCapabilities::chrome();
        $desiredCapabilities
            ->setCapability("trustAllSSLCertificates", true)
            ->setCapability(ChromeOptions::CAPABILITY, $options)
        ;

        $this->webDriver = RemoteWebDriver::create(
            "http://localhost:4444/wd/hub",
            $desiredCapabilities
        );

        $this->webDriver->get($this->baseUrl);
        $this->assertStringContainsStringIgnoringCase('NetBeans', $this->webDriver->getTitle());

        $this->webDriver->wait(5);

        $remoteElement = $this->webDriver->findElement(WebDriverBy::id('lmb'));
        $remoteElement->click();

        $this->assertStringContainsStringIgnoringCase('apache', $this->webDriver->getTitle());
    }
}
