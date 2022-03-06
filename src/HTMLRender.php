<?php
/**
 * Renders HTML To UI
 */
namespace EaseRoutes;
class HTMLRender{
    static function render($pageLocation,$renderMap=false){
        $contents = file_get_contents($pageLocation);
        $homeDirectory = "";
        $new_contents = str_replace("{{HOME_DIR}}", $homeDirectory, $contents);
        if($renderMap!=false){
            foreach (@$renderMap as $key => $value) {
                $key="{{".$key."}}";
                $new_contents = str_replace($key, $value, $new_contents);
            }
        }
        return $new_contents;
    }
}

?>