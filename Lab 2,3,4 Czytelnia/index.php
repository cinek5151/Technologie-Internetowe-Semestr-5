<?php

include_once "header.php";

$eventsFile = file_get_contents("events/events.json");
$events = json_decode($eventsFile)->events;


?>

<div class="container">

    <?php

    foreach ($events as $event) {
        ?>

        <div class="event-container">
            <span class="event-number">Wydarzenie nr. <?=$event->number?></span>
            <div class="event-title">
                <span><?=$event->title?></span>
                <hr>
            </div>


            <div class="event-description">
                <span><?=$event->description?></span>
                <hr>
            </div>

            <span class="event-date">Data wydarzenia: <?=$event->date?></span>

        </div>

        <?php
    }
    ?>


</div>

<?php

include_once "footer.php";

?>
