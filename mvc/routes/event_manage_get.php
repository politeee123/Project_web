<?php

$result = getEvent();
renderView('event_manage_get', array('result' => $result));