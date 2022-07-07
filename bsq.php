<?php
if (is_file($argv[1])) {
    $file = $argv[1];
    $result = [];
    $crossSquare = [];
    $finalArray = [];
    $finalResult = [];

    $map = file($file);
    $nbr_row = count($map) - 1;
    $axeY = strlen(trim($map[1]));
    if ($axeY != 2000) {
        foreach ($map as $rows) {
            $row = str_split($rows);
            foreach ($row as $chara) {
                if ($chara == "o") {
                    array_push($result, 0);
                } elseif ($chara == ".") {
                    array_push($result, 1);
                }
            }
        }
        $resultBefore = $result;
        if ($axeY > 1) {
            for ($i = 0; $i < $axeY * $nbr_row; $i++) {
                if (isset($result[$i - 1]) && isset($result[$i - $axeY]) && isset($result[$i - $axeY - 1])) {

                    $a = $result[$i - 1];
                    $b = $result[$i - $axeY];
                    $c = $result[$i - $axeY - 1];
                    $square = [];

                    if ($result[$i] != 0) {
                        array_push($square, $a, $b, $c);
                        $min = min($square);
                        $result[$i] += $min;
                    }
                }
            }
            $BigestSquare = max($result);
            $indexX = array_search($BigestSquare, $result);
            $indexY = $indexX - ($axeY * $BigestSquare) - $BigestSquare + 1;



            for ($i = 0; $i < ($BigestSquare * $axeY); $i += $axeY) {
                $tmp = pushRowInArray(($indexY + $i + $axeY), $BigestSquare, $crossSquare);
                array_push($finalArray, $tmp);
            }

            $it =  new RecursiveIteratorIterator(new RecursiveArrayIterator($finalArray));
            $l = iterator_to_array($it, false);
            $t = array_slice($l, 0, $axeY * $axeY);

            foreach ($resultBefore as $key => $val) {
                if ($val == 0) {
                    array_push($finalResult, "o");
                } elseif (in_array($key, $t) == true) {
                    array_push($finalResult, "x");
                } else {
                    array_push($finalResult, ".");
                }
            }
            $f = chunk_split(implode($finalResult), $axeY);
            $final = str_replace("\x0D", "", $f);
            echo $final;
        } else {

            foreach ($resultBefore as $key => $val) {

                if ($val == 0) {
                    array_push($finalResult, "o");
                } else {
                    array_push($finalResult, ".");
                }
            }
            $arraySearch = array_search(".", $finalResult);
            if ($arraySearch !== false) {
                $finalResult[$arraySearch] = "x";
                $f = chunk_split(implode($finalResult), $axeY);
                $final = str_replace("\x0D", "", $f);
            }
            $f = chunk_split(implode($finalResult), $axeY);
            $final = str_replace("\x0D", "", $f);
            echo $final;
        }
    }
}


function pushRowInArray($indexY, $BigestSquare, $crossSquare)
{
    for ($i = $indexY; $i < ($indexY + $BigestSquare); $i++) {
        array_push($crossSquare, $i);
    }
    return $crossSquare;
}
?>