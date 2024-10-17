<?php

class ReponseJson {
    public static function repondre(array $tableau, bool $die = true) {
        echo json_encode($tableau, JSON_PRETTY_PRINT);
        
        if($die)
            die();
    }
}