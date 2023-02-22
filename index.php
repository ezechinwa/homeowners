<?php 

// Author: Williams Chinwa 
// Date: 22nd Feb 2023
// Time: 10:13 AM

require('functions.php');
$filename = 'example.csv';

// read the CSV file into an array
$peopleList = array_map('str_getcsv', file($filename));

// Create an initial variable to store the list of persons 
$people = array();

// loop through each name in the CSV and split into correct fields
foreach ($peopleList as $personString) {
    // My simple program assumes the homeowner would always be first column name from the csv
    if($personString[0] == "homeowner"){
        continue;
    }

    // split the name into individual names if there is an "and" in the string
    if ((strpos($personString[0], "and") !== false)) {
        $names = explode(" and ", $personString[0]);
        //sort their names based on wordcount 

    } 
    elseif( (strpos($personString[0], "&") !== false)){
          $names = explode(" & ", $personString[0]);
    }
    else {
        $names = array($personString[0]);
    }

    usort($names,'sort_by_word_count');
 
    // this temp variable would be used to determine the other person's name 

     $temp = $names[0]; 

    foreach ($names as $name) {
        // initialize the variables for this name
        $title = null;
        $firstName = null;
        $initial = null;
        $lastName = null;

        // fetch the title from the input 
        $split_name =explode(' ', $name);
        foreach ($split_name as $item) {
            if (in_array(strtolower($item), ['mr', 'mrs', 'miss', 'mister','ms', 'dr', 'prof'])){
                $title = ucfirst($item);
            }
        }

            if( str_word_count($name) > 1){
                $pieces = explode(' ', $name);
                $lastName = ucfirst(array_pop($pieces));

                 foreach ($pieces as $item) {
             
                    if (!in_array(strtolower($item), ['mr', 'mrs', 'miss', 'mister', 'ms', 'dr', 'prof', 'and'])){
                        //fetch the initial 
                          if (strpos($item, '.') !== false) {
                            $initial = ucfirst(substr($item, 0, 1));
                          }else{
                            $firstName = ucfirst($item);
                          }
                    }
                 }
                // print_r($pieces); 
               
            }
            else{

                $pieces = explode(' ', $temp);
                $lastName = ucfirst(array_pop($pieces));
                 foreach ($pieces as $item) {
                    if (!in_array(strtolower($item), ['mr', 'mrs', 'miss','mister', 'ms', 'dr', 'prof', 'and'])){
                          if (strpos($item, '.') !== false) {
                            $initial = ucfirst(substr($item, 0, 1));
                          }else{
                            $firstName = ucfirst($item);
                          }
                    }
                 }
            }

       



        //Now add the person to the person array
        $person = array(
            'title' => $title,
            'first_name' => $firstName,
            'initial' => $initial,
            'last_name' => $lastName
        );
        array_push($people, $person);
    }
}

// print the output in human readable format 
print "<pre>";
print_r($people);
print "</pre>";