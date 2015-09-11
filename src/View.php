<?php
namespace thom855j\PHPMvcFramework;

/**
 * Class View
 * The part that handles all the output
 */
class View
{

    /**
     * simply includes (=shows) the view. this is done from the controller. In the controller, you usually say
     * $this->view->render('help/index'); to show (in this example) the view index.php in the folder help.
     * Usually the Class and the method are the same like the view, but sometimes you need to show different views.
     * @param string $filename Path of the to-be-rendered view, usually folder/file(.php)
     * @param array $data Data to be used in the view
     */
    public
            function render($filenames = array(), $data = null)
    {

        foreach ($filenames as $filename)
        {
            require_once $filename . '.php';
        }
     
    }

    /**
     * Renders pure JSON to the browser, useful for API construction
     * @param $data
     */
    public
            function renderJson($data)
    {
        echo json_encode($data);
    }

    /**
     * renders the feedback messages into the view
     */
    public
            function renderFeedback($path)
    {
        // echo out the feedback messages (errors and success messages etc.),
        // they are in $_SESSION["feedback_positive"] and $_SESSION["feedback_negative"]
        require_once PATH_LIBS . 'common/templates/system/feedback.php';
        // delete these messages (as they are not needed anymore and we want to avoid to show them twice
    }

}
