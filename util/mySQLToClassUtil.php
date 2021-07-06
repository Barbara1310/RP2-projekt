<?php
function mySQLToClass($document, $obj, $skip = false)
{
    //    echo '<pre>';
    //    print_r($document);
    //    echo '</pre>';
    //    echo '<br>';
    //    return;
    foreach ($document as $key => $val) {
        $setProperty = "set" . ucfirst($key);

        if ($key === "_id") {
            $obj->setId($val["\$oid"]);
            continue;
        } elseif (strpos($key, "Id")) {
            //            echo '<pre>';
            //            print_r($key);
            //            print_r($val);
            //            echo '</pre>';
            //            echo '<br>';
            //            return;
            $obj->$setProperty($val["\$oid"]);
            continue;
        }

        if (!is_array($val)) {
            $obj->$setProperty($val);
        } elseif (strpos($key, "Array")) {
            $innerObjectArray = [];
            $innerClass = ucfirst(preg_replace("/Array/", "", $key));
            foreach ($val as $inner) {
                $innerObj = new $innerClass;
                if ($skip === false)
                    $innerObjectArray[] = mongoToClass($inner, $innerObj);
                else // Problem je kod upita za salesForProduct. Vraca se array sa jednim clanom, i onda se trazi Sales::setSaleArray metoda
                    return mongoToClass($inner, $innerObj);
            }

            $obj->$setProperty($innerObjectArray);
        } else {
            $innerClass = ucfirst($key);
            $innerObj = new $innerClass;
            $obj->$setProperty(mongoToClass($val, $innerObj));
        }
    }
    return $obj;
}
