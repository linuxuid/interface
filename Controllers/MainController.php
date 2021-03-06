<?php 
namespace Controllers;

use Exceptions\AvailableUsersExceptions;
use \View\View; // use view
use Models\Users\UserAuthService;
use Models\Users\User;

abstract class MainController 
{
    /** @var view */
    protected $view;

    /** @var User|null */
    protected $user;

    public function __construct()
    {

        $this->user = UserAuthService::getUserByToken();
        $this->view = new View(__DIR__ . '/../Templates');
        $this->view->setVariable('user', $this->user);

        /**
         * If user get a ban
         */
        $user = UserAuthService::getUserByToken() ?? null;

        if($user === null){
            return null;
        }

        if($user->getStatus() == 'banned'){
            throw new AvailableUsersExceptions();
        } 
    }

    protected function isCorrect(array $result)
    {
        if($result === null):
            $this->view->renderHtml('error/404.php');
            return;
        endif;
    }
}