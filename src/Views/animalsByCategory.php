<h3>Животные из категории: <? $animals[0]['description']?></h3>
<?php foreach ($animals as $animal ):?>
    <h4><? echo $animal['animal_name'] ?></h4>
    <ul>
        <li>Возраст: <?echo $animal['age']?></li>
        <li>
            <a href="/animals/<?echo $animal['name']?>/<?echo $animal['id_animal']?>">Подробнее...</a>
        </li>
    </ul>
<?php endforeach;?>