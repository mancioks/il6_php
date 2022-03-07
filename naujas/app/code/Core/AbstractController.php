<?php

namespace Core;

use Helper\Url;
use Model\Message;
use Model\Request;
use Model\Session;
use Model\User;

class AbstractController
{
    protected $data;
    protected $request;
    protected $session;

    public function __construct() {
        $this->request = new Request();
        $this->session = new Session();

        $this->data = [];
        $this->data["title"] = "Autoplius";
        $this->data["meta_description"] = '';
        if($this->isUserLogged()) {
            $this->data["new_messages"] = Message::newMessagesCount($this->session->get("user_id"));
        }
    }

    protected function render($template)
    {
        include_once PROJECT_ROOT_DIR . '/app/design/parts/header.php';

        include_once PROJECT_ROOT_DIR . '/app/design/' . $template . '.php';

        include_once PROJECT_ROOT_DIR . '/app/design/parts/footer.php';
    }

    protected function renderAdmin($template)
    {
        include_once PROJECT_ROOT_DIR . '/app/design/admin/parts/header.php';

        include_once PROJECT_ROOT_DIR . '/app/design/admin/' . $template . '.php';

        include_once PROJECT_ROOT_DIR . '/app/design/admin/parts/footer.php';
    }

    protected function isUserLogged()
    {
        return !empty($this->session->get("user_id"));
    }

    public function url($path, $param = null) {
        return Url::link($path, $param);
    }

    public function index()
    {

    }

    protected function isUserAdmin()
    {
        if($this->isUserLogged()){
            $user = new User();
            $user->load($this->session->get("user_id"));
            if($user->getRoleId() == 1) {
                return true;
            }
        }

        return false;
    }
}