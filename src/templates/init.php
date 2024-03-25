<?php

require_once __DIR__ . "/../bootstrap.php";

use Clearuns\Events\StartUpEvent;

StartUpEvent::start($entity_manager);
