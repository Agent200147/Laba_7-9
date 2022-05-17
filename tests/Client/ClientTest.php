<?php

namespace App\Tests\Client;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientTest extends WebTestCase
{
    private array $trueData = ['email' => 'www@mail.ru', 'password' => 'wwwwww'];

    private array $falseData = ['email' => 'data@mail.ru', 'password' => '111111'];

    public function testIndexPage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('AestheticNews');
//        $this->assertSelectorTextContains('h1', 'Hello World');
        $this->assertCount(10, $crawler->filter('.post'));

        $link = $crawler->filter('.post-link')->link();
        $client->click($link);
        $this->assertResponseStatusCodeSame(200);
        $this->assertPageTitleContains('AestheticNews');
    }

    public function testAuthentication(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $link = $crawler->filter('.vhod--link')->link();
        $client->click($link);
        $this->assertResponseStatusCodeSame(200);
        $this->assertPageTitleContains('Вход');
        $client->submitForm('Войти', $this->falseData);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorTextContains('.error', 'Неверно введена почта или пароль');
        $client->submitForm('Войти', $this->trueData);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertPageTitleContains('AestheticNews');
    }

    public function testAddNew()
    {
        $client = static::createClient();


        $crawler = $client->request('GET', '/addNew');
        $this->assertResponseRedirects();
        $client->followRedirect();

        $this->assertPageTitleContains('Вход');
        $client->submitForm('Войти', $this->trueData);

        $this->assertResponseRedirects();
        $crawler = $client->followRedirect();
        $this->assertPageTitleContains('AestheticNews');

        $link = $crawler->filter('.add__new')->link();
        $client->click($link);
//        $this->assertResponseRedirects();
//        $client->followRedirect();
//        $this->assertPageTitleContains('AestheticNews');
//        $client->submitForm('Войти', $this->trueData);
//        $this->assertResponseRedirects();
//        $client->followRedirect();
//        $this->assertPageTitleContains('Добавление новости');
        $new_false = [
            'add_news[fotopath]' => ' ',
            'add_news[name]' => ' ',
            'add_news[description]' => ' ',
            'add_news[content]' => ' ',
        ];
        $client->submitForm('Загрузить', $new_false);
        $this->assertSelectorTextContains('.error', 'Пожалуйста введите название новости');
        $new_true = [
            'add_news[fotopath]' => 'C:\fakepath\car-vaporwave-1836077-wallhere.com.jpg',
            'add_news[name]' => 'Машина',
            'add_news[description]' => 'Летающая машина будущего..',
            'add_news[content]' => 'Летающая машина будущего будет представлена в ближайшие 10-15 лет'
        ];
        $client->submitForm('Загрузить', $new_true);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertPageTitleContains('AestheticNews');
    }


}
