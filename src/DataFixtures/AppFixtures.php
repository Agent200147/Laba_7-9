<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\News;
use App\Entity\Comments;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
        
        $user = new User();
        $password = $this->hasher->hashPassword($user, '111111');

        $user->setLogin('Agent47');
        $user->setEmail('Agent47@mail.ru');
        $user->setRoles($roles);
        $user->setPassword($password);
        $manager->persist($user);

        $user = new User();
        $password = $this->hasher->hashPassword($user, '222222');

        $user->setLogin('qqqqqq');
        $user->setEmail('qqqqqq@mail.ru');
        $user->setRoles($roles);
        $user->setPassword($password);

        $manager->persist($user);

        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
            
            $news = new News;
            $news->setName('Новость №'. $i);
            $news->setDescription('Россияне избили трансгендера, разгромили ЛГБТ-кафе и попали на видео');
            $news->setContent("В Омске неизвестные разгромили кафе, где собираются представители ЛГБТ-сообщества, избили трансгендера и попали на видео. Об этом сообщает РИА Новости с ссылкой на региональное управление МВД.

«В отделе полиции №1 Омска по факту причинения телесных повреждений зарегистрировано обращение гражданки 2001 года рождения. Также полицейские проверяют факт повреждения имущества, принадлежащего кафе», — рассказал представитель МВД.

Кадры, снятые камерой видеонаблюдения, публикует «Вести.ру». На них видно, что возле здания останавливается белый автомобиль, из которого выходит человек в черном и бьет ногами и руками людей, которые сидели к нему спиной. После нескольких ударов одна из жертв падает.

«Неизвестный напал со спины на двух людей на улице. В результате один из них (трансгендер) получил черепно-мозговую травму и сотрясение мозга. Впоследствии машина уехала и вернулась с подкреплением. Шесть человек выломали входную дверь кафе и разбили наружные камеры наблюдения», — рассказал активист Николай Родькин, передает РИА Новости.

Прошлым летом в Ярославле толпа десантников напала на ЛГБТ-активиста. Ярослав Сироткин встал на одной из центральных улиц города с плакатом «Геи тоже служат в ВДВ».");
            $date = new \DateTime('@'.strtotime('now + 3 hours'));
            $news->setDateLoad($date);
            $news->setViewsNum(0);
            $news->setUser($user);                     
            $manager->persist($news);


            $comment = new Comments();
            $comment->setContent("Мдаа, ну и позорище а не русские! Фу такими быть, я считаю.");
            $comment->setDateLoad($date);
            $comment->setUser($user);
            $comment->setNew($news);
            if($i % 2 == 0){
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
