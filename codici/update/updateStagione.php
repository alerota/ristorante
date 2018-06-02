<?php
function _isDateCorrette($inizio, $fine) {
    if($fine <= $inizio)
        return true;
    else
        return false;
}
?>