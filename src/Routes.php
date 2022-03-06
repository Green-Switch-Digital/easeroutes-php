<?php
namespace EaseRoutes;


class Routes {
    var $levels = 0;
    var $rootDir = "";
    private $notFound = false;
    public function get($route,$page){
        $request_url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        $request_url = rtrim($request_url, '/');
        $request_url = strtok($request_url, '?');
        $route_parts = explode('/', $route);
        $request_url_parts = explode('/', $request_url);
        array_shift($route_parts);
        array_shift($request_url_parts);
        $ROOT = $_SERVER['DOCUMENT_ROOT']."/$this->rootDir";
        
        
        
        /**
         * Check if levels dont match and return, we dont need to continue from here
         */
        if( count($route_parts) != count($request_url_parts)-$this->levels ){ 
            // echo "Dont mind $route <br>";            
            return; 
        }  else{
            
        }
            
        $variables         =   array();//parameters passed to the app through url
        
        for($i=$this->levels; $i<count($request_url_parts);$i++){
            $isVariable    =   count(explode(":",$request_url_parts[$i]));
            // echo $request_url_parts[$i];
            if($route_parts[$i-$this->levels]!=$request_url_parts[$i] ){
                if($isVariable>1){
                    $variableName   =   explode(":",$route_parts[$i-$this->levels])[1];
                    // $par    =   array("".$variableName.""=>$request_url_parts[$i]);
                    $variables["".$variableName.""] = $request_url_parts[$i];//adding variables to our page from url
                }else{
                    return;
                }
            }
        }

        //i have just re-written this code so lets not runi it again
        // $parameters = [];
        // for( $__i__ = $this->levels; $__i__ < count($route_parts); $__i__++ ){
        //     $route_part = $route_parts[$__i__];
        //     if( preg_match("/^[$]/", $route_part) ){
        //     $route_part = ltrim($route_part, '$');
        //     array_push($parameters, $request_url_parts[$__i__]);
        //     $$route_part=$request_url_parts[$__i__];
        //     }
        //     // else if( $route_parts[$__i__] != $request_url_parts[$__i__] ){
        //     //     echo "returning";
        //     // return;
        //     // } 
        // }
        // echo json_encode($variables);
        
        // include_once("$ROOT/$page");

        $this->loadWithVariables("$ROOT/$page",$variables);
        $this->notFound = false;
        die();
        exit();
    }

    private function loadWithVariables($page,$variables){
        $output = NULL;
        extract($variables);
        ob_start();
        if (file_exists($page)) {
            include $page;

            $output = ob_get_clean();

            print($output);

            return $output;
        }else{
            echo "File <a href='#'>$page</a> was not found";
        }
    }

    public function post($url,$pageToLoad){
        return $this->get($url,$pageToLoad);
    }

    public function load404($pageToLoad=false){
        if (!$this->notFound) {
                $outputVariables = array("errorCode"=>404,"message"=>"Page not found");
                $this->loadWithVariables($pageToLoad, $outputVariables);
        }
    }
}
