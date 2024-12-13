<?php

if (!function_exists('getProficiencyColor')) {
    function getProficiencyColor($proficiency) {
        switch ($proficiency) {
            case 1:
                return 'danger'; 
            case 2:
                return 'warning'; 
            case 3:
                return 'info'; 
            case 4:
                return 'primary'; 
            case 5:
                return 'success'; 
            default:
                return 'secondary'; 
        }
    }
}
