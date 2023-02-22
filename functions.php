<?php 
function sort_by_word_count($a,$b){
    return str_word_count($b)-str_word_count($a);
}
 
