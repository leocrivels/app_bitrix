<?php
 
namespace App;
 
/**
 * Class to make an application view.
 * It loads the general template and add the view.
 */
class View
{
    /**
     * Show a view.
     * Function inspired by Laravel 4. see: http://laravel.com/docs/4.2/responses#views
     *
     * @link http://laravel.com/docs/4.2/responses#views
     * @param  string $viewName   it's the file name in lib/views without ".php"
     * @param  array  $customVars (optional) Array of variables which can customize the view
     */
    public static function make($viewName, array $customVars = array())
    {
        // create variables of $customVars
        extract($customVars);
         
        // add the template that will process the view $viewName
        require_once viewsPath() . 'template.php';
    }
}