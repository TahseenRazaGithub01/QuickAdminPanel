<?php

namespace Tests;

use App\User;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Faker\Factory;
use Laravel\Dusk\TestCase as BaseTestCase;
use Session;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments([
//            '--disable-gpu',
//            '--headless',
            '--window-size=1920,1080',
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()->setCapability(
            ChromeOptions::CAPABILITY, $options
        ),60000, 60000
        );
    }

    public function setUp() :void {
        parent::setUp();

        Session::start();

        $this->faker = Factory::create();

        $this->adminPrefix = '/admin/';

        $this->testId = "?test_id=1";

        $this->user = User::find(1);

        $this->timer = 1100;

        $this->imagePath = 'images/usertesting-730x356.jpg';
        $this->imagePath2 = 'images/verizon.jpg';
        $this->imagePath3 = 'images/user-icon.jpg';
        $this->imagePath4 = 'images/us.png';
        $this->imageLogo = 'images/logo.png';

        $this->saveBttnText = "Save";
        $this->updateBttnText = "Save";

    }
}
