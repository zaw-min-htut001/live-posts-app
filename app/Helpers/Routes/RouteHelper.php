<?php

namespace App\Helpers\Routes;


class RouteHelper
{
    public static function includeRouteFiles(string $folder)
    {
        $dirItertor = new \RecursiveDirectoryIterator($folder);

        $it = new \RecursiveIteratorIterator($dirItertor);

        while($it->valid()){
            if(!$it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php')
            {
                require $it->key();
            }
            $it->next();
        }
    }

}
