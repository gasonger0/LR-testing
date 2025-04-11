<?php
require_once 'vendor/autoload.php';

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;

class LitresTest extends TestCase {
    protected $webDriver;

    protected function setUp(): void {
        $host = 'http://localhost:4444/wd/hub'; // Selenium Server
        $this->webDriver = RemoteWebDriver::create($host, [
            "browserName" => "chrome"
        ]);
        $this->webDriver->get("https://www.litres.ru");
    }

    // 1. Проверка заголовка
    public function testTitle() {
        $title = $this->webDriver->getTitle();
        $this->assertStringContainsString("Литрес", $title);
    }

    // 2. Проверка видимости объектов
    public function testElementsVisibility() {
        $logo = $this->webDriver->findElement(WebDriverBy::className("logo-litres"));
        $this->assertTrue($logo->isDisplayed());

        $searchField = $this->webDriver->findElement(WebDriverBy::name("q"));
        $this->assertTrue($searchField->isDisplayed());
    }

    // 3. Переход по ссылке
    public function testLinkNavigation() {
        $link = $this->webDriver->findElement(WebDriverBy::linkText("Аудиокниги"));
        $link->click();
        $this->assertStringContainsString("audioknigi", $this->webDriver->getCurrentURL());
    }

    // 4. Заполнение текстового поля
    public function testSearchField() {
        $searchField = $this->webDriver->findElement(WebDriverBy::name("q"));
        $searchField->sendKeys("Гарри Поттер")->submit();
        $results = $this->webDriver->findElement(WebDriverBy::className("search-container"));
        $this->assertTrue($results->isDisplayed());
    }

    // 5. Эмуляция нажатия на кнопку
    public function testButtonClick() {
        $button = $this->webDriver->findElement(WebDriverBy::className("login_link"));
        $button->click();
        $authForm = $this->webDriver->findElement(WebDriverBy::id("loginForm"));
        $this->assertTrue($authForm->isDisplayed());
    }

    protected function tearDown(): void {
        $this->webDriver->quit();
    }
}
?>