<h3>Главная страница</h3>
<?php foreach ($animals as $animal ):?>
    <h4><? echo $animal['animal_name'] ?></h4>
    <ul>
        <li>
            <a href="/animals/<?echo $animal['name']?>">
                Категория:
                <? echo $animal['description'] ?>
            </a>
        </li>
        <li>Возраст: <?echo $animal['age']?></li>

        <li>Документы:
            <?echo ($animal['passport']) ? 'есть' :  'нет'?>
        </li>
        <li>
            <a href="/animals/<?echo $animal['name']?>/<?echo $animal['id_animal']?>">Подробнее...</a>
        </li>
    </ul>
<?php endforeach;?>
