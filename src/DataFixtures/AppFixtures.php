<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\News;
use App\Entity\Comments;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {

        $roles = [
            'ROLE_USER',
            'ROLE_ADMIN',
        ];

        $roles_user = [
            'ROLE_USER',
        ];
        
        //Обычный юзер
        $user = new User();
        $password = $this->hasher->hashPassword($user, 'wwwwww');
        $user->setLogin('wwwwww');
        $user->setEmail('www@mail.ru');
        $user->setRoles($roles_user);
        $user->setPassword($password);
        $user->setApiToken(Uuid::v1()->toRfc4122());

        $manager->persist($user);

        //Админ
        $user = new User();
        $password = $this->hasher->hashPassword($user, '111111');
        $user->setLogin('Agent47');
        $user->setEmail('Agent47@mail.ru');
        $user->setRoles($roles);
        $user->setPassword($password);
        $user->setApiToken(Uuid::v1()->toRfc4122());

        $manager->persist($user);

        //Админ
        $user = new User();
        $password = $this->hasher->hashPassword($user, '222222');
        $user->setLogin('qqqqqq');
        $user->setEmail('qqqqqq@mail.ru');
        $user->setRoles($roles);
        $user->setPassword($password);
        $user->setApiToken(Uuid::v1()->toRfc4122());
        
        $manager->persist($user);

        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
            
            if($i % 2 == 0){
                $news = new News;
                $news->setName('WOW Awards 2022. Что нового? №'. $i);
                $news->setDescription('Премия эффектного креатива рынка недвижимости WOW Awards в этом году проходит в 11-й раз. Все самое важное остается неизменным: огненная вечеринка в честь победителей WOW Awards, п...');
                $news->setContent("Новые номинации, идеи, “фишки”, изменения в регламенте, основанные на обратной связи от участников. Этот год – не исключение.

    В 2022 году организаторы премии WOW Awards решили сделать отдельную номинацию «Респект года» для самого яркого события рынка недвижимости.

    Но событие ≠ event. Под событием в этой номинации подразумевается все, что произвело wow-впечатление: неожиданная коллаборация, нестандартные каналы и инструменты продвижения. Все, за что профессиональное сообщество готово «респектнуть» команде. Как и во всех номинациях, свои награды получат и заказчик, и исполнитель.

    «Респект года» – логическое продолжение номинации «Команда года», но Экспертный совет будет оценивать не работу за год, а одно конкретное достижение.

    Сколько стоит подать заявку на «Респект года»? Эта номинация бесплатная. 

    В ближайшее время на сайте премии появится техническая возможность подать свой кейс, а в регламенте — все детали по критериям оценки и составу заявки. Ну а пока вспоминайте самое яркое событие и готовьтесь принять участие в номинации! И возможно 8 сентября на церемонии награждения WOW Awards 2022 рынок недвижимости «респектнет» вам.

    Что касается условий участия, здесь тоже есть изменения: ранее было условие, что от каждого застройщика в одну номинацию можно было подать не более 3-х заявок. В этом году ограничения касаются не застройщика, а рекламируемого объекта. То есть в одну номинацию может быть подано не более 2-х заявок по продвижению каждого объекта (ЖК). Если же рекламируется бренд застройщика, то подать можно аналогично не более 2-х заявок в одну номинацию.");
                $date = new \DateTime('@'.strtotime('now + 3 hours'));
                $news->setDateLoad($date);
                $news->setViewsNum(0);
                $news->setfotopath('6313.jpg');
                $news->setUser($user);                     
                $manager->persist($news);
            }

            else{
                $news = new News;
                $news->setName('WSJ сообщила о снижении доверия к рекламе от звездных блогеров №'. $i);
                $news->setDescription('Крупные компании стали более скептически относиться к инфлюенсерам, продвигающим их товары в Instagram и на YouTube. Причина - в низкой эффективности такой рекламы. Подписчики все меньше верят в искре...');
                $news->setContent("Крупные компании стали более скептически относиться к инфлюенсерам, продвигающим их товары в Instagram и на YouTube. Причина - в низкой эффективности такой рекламы. Подписчики все меньше верят в искренность блогеров, а сами сетевые звезды пользуются ботами
Крупные компании продолжают тратить миллиарды долларов на покупку рекламы у интернет-знаменитостей, продвигающих их товары в социальных сетях, пишет The Wall Street Journal. В этом году глобальные расходы брендов на такую форму продвижения составят от $4 млрд до более чем $8 млрд, а цена одного поста в социальной сети знаменитости будет варьироваться от $20 000 до $500 000, приводит WSJ данные маркетингового агентства Mediakix. В 2020-м расходы составят уже примерно от $5 млрд до $10 млрд.

Однако в последнее время доверие к инфлюенсерам стало снижаться. Натянутые отношения между рекламодателями и блогерами возникли из-за того, что последние стали искусственно увеличивать количество подписчиков и покупать тысячи ботов, чтобы улучшить свои показатели. А по репутации в глазах фанатов ударило то, что инфлюенсеры продвигают товары, которыми не пользуются.");
                $date = new \DateTime('@'.strtotime('now + 3 hours'));
                $news->setDateLoad($date);
                $news->setViewsNum(0);
                $news->setfotopath('8296.jpg');
                $news->setActive(true);
                $news->setUser($user);                     
                $manager->persist($news);

            }
            


            $comment = new Comments();
            $comment->setContent("Очень интересная новость)");
            $comment->setDateLoad($date);
            $comment->setUser($user);
            $comment->setNew($news);
            if($i % 3 == 0){
                $flag = false;
            }
            else{
                $flag = true;
            }
            $comment->setActive($flag);

            $manager->persist($comment);
        }
        $manager->flush();
    }
}
