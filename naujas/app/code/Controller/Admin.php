<?php

namespace Controller;

use Core\AbstractController;
use Helper\FormHelper;
use Helper\Messages;
use Helper\Url;
use Helper\Validator;
use Model\Ad;
use Model\City;
use Model\Manufacturer;
use Model\Model;
use Model\User;
use Core\Interfaces\ControllerInterface;
use Dompdf\Dompdf;

class Admin extends AbstractController implements ControllerInterface
{
    protected $dompdf;

    public function __construct()
    {
        parent::__construct();

        if (!$this->isUserAdmin()) {
            Url::redirect('');
        }
    }

    public function index()
    {
        $this->data["messages"] = Messages::getMessages();
        $this->renderAdmin('index');
    }

    public function users()
    {
        $users = User::getAll();
        $this->data['users'] = $users;

        $this->data["messages"] = Messages::getMessages();

        $this->renderAdmin('users/list');

    }

    public function ads()
    {
        $ads = Ad::getAll(["order_by" => "id", "clause" => "DESC"], true);

        $this->data['ads'] = $ads;

        $this->data["messages"] = Messages::getMessages();

        $this->renderAdmin('ads/list');
    }

    public function adedit($adId)
    {
        if(Ad::exists($adId)) {
            $ad = new Ad();
            $ad->load($adId);

            $form = new FormHelper("admin/adupdate", "POST");

            $form->input([
                'name' => 'title',
                'type' => 'text',
                'placeholder' => 'Title',
                'value' => $ad->getTitle()
            ]);

            $groups = [];
            $manufacturers = Manufacturer::getManufacturers();
            foreach ($manufacturers as $manufacturer) {
                $models = [];
                $modelsObject = Model::getModelsByManufacturerId($manufacturer->getId());

                foreach ($modelsObject as $model) {
                    $models[$model->getId()] = $model->getName();
                }

                $groups[$manufacturer->getName()] = $models;
            }

            $form->selectGroup([
                "name" => "model_id",
                "group" => $groups,
                "selected" => $ad->getModelId()
            ]);

            $form->input([
                'name' => 'ad_id',
                'type' => 'hidden',
                'value' => $ad->getId()
            ]);
            $form->textArea("description", $ad->getDescription());
            $form->input([
                'name' => 'price',
                'type' => 'text',
                'placeholder' => 'Price €',
                'value' => $ad->getPrice()
            ]);
            $form->input([
                'name' => 'image_url',
                'type' => 'text',
                'placeholder' => 'Image url',
                'value' => $ad->getImageUrl()
            ]);
            $form->input([
                'name' => 'vin',
                'type' => 'text',
                'placeholder' => 'Vin kodas',
                'value' => $ad->getVin()
            ]);

            $years = [];
            for ($x = 1990; $x <= date("Y"); $x++) {
                $years[$x] = $x;
            }

            $form->select([
                'name' => 'year',
                'options' => $years,
                'selected' => $ad->getYear()
            ]);
            $form->select([
                'name' => 'active',
                'options' => [1 => "Aktyvus", 0 => "Neaktyvus"],
                'selected' => $ad->getActive()
            ]);
            $form->input([
                'name' => 'submit',
                'type' => 'submit',
                'value' => 'Atnaujinti'
            ]);

            $this->data["form"] = $form->getForm();
            $this->data["ad_title"] = $ad->getTitle();

            $this->data["messages"] = Messages::getMessages();

            $this->renderAdmin("ads/edit");
        } else {
            Url::redirect("admin/ads");
        }
    }

    public function adupdate()
    {
        $adId = $this->request->post("ad_id");
        $ad = new Ad();
        $ad->load($adId);

        $model = new Model();
        $model->load($this->request->post("model_id"));

        $ad->setTitle($this->request->post("title"));
        $ad->setModelId($this->request->post("model_id"));
        $ad->setManufacturerId($model->getManufacturerId());
        $ad->setDescription($this->request->post("description"));
        $ad->setPrice($this->request->post("price"));
        $ad->setYear($this->request->post("year"));
        $ad->setImageUrl($this->request->post("image_url"));
        $ad->setActive($this->request->post("active"));
        $ad->setVin($this->request->post("vin"));

        $ad->save();

        Messages::store("Skelbimo informacija atnaujinta", 2);

        Url::redirect("admin/adedit/" . $ad->getId());
    }

    public function useredit($userId)
    {
        if(User::exists($userId)) {
            $user = new User();
            $user->load($userId);

            $form = new FormHelper('admin/userupdate', 'POST');

            $form->input([
                "name" => "name",
                "type" => "text",
                "placeholder" => "Vardas",
                "value" => $user->getName()
            ]);
            $form->input([
                "name" => "user_id",
                "type" => "hidden",
                "value" => $userId
            ]);
            $form->input([
                "name" => "last_name",
                "type" => "text",
                "placeholder" => "Last name",
                "value" => $user->getLastName()
            ]);
            $form->input([
                "name" => "email",
                "type" => "text",
                "placeholder" => "Email",
                "value" => $user->getEmail()
            ]);
            $form->input([
                "name" => "phone",
                "type" => "text",
                "placeholder" => "Telefonas",
                "value" => $user->getPhone()
            ]);
            $form->input([
                "name" => "password",
                "type" => "password",
                "placeholder" => "New password"
            ]);
            $form->input([
                "name" => "password2",
                "type" => "password",
                "placeholder" => "New password"
            ]);

            $cities = City::getCities();

            $options = [];
            foreach ($cities as $city) {
                $options[$city->getId()] = $city->getName();
            }

            $form->select([
                "name" => "city_id",
                "options" => $options,
                "selected" => $user->getCityId()
            ]);

            $form->select([
                "name" => "active",
                "options" => ["0" => "Neaktyvus", "1" => "Aktyvus"],
                "selected" => $user->getActive()
            ]);

            $form->input([
                "name" => "create",
                "type" => "submit",
                "value" => "Pakeisti"
            ]);

            $this->data['form'] = $form->getForm();

            $this->data['messages'] = Messages::getMessages();

            $this->renderAdmin("users/edit");
        } else {
            Url::redirect("admin/users");
        }
    }

    public function reports()
    {
        $this->renderAdmin("reports/index");
    }

    public function adsreport()
    {
        $this->dompdf = new Dompdf();

        $ads = Ad::getAll([], true);

        $viewsCount = 0;
        $priceCount = 0;

        foreach ($ads as $ad) {
            $viewsCount += $ad->getViews();
            $priceCount += $ad->getPrice();
        }

        $this->data["ads"] = $ads;
        $this->data["views_count"] = $viewsCount;
        $this->data["price_count"] = $priceCount;


        $this->dompdf->loadHtml($this->getPdfTemplate("ads"));
        $this->dompdf->render();
        $this->dompdf->stream("adsReport.pdf", array("Attachment" => false));
        exit();
    }

    public function userupdate()
    {
        $userId = $this->request->post("user_id");
        $user = new User();
        $user->load($userId);

        $user->setName($this->request->post("name"));
        $user->setLastName($this->request->post("last_name"));
        $user->setPhone($this->request->post("phone"));
        $user->setCityId($this->request->post("city_id"));
        $user->setActive($this->request->post("active"));

        if (!empty($this->request->post("password")) && Validator::checkPassword($this->request->post("password"), $this->request->post("password2"))) {
            $user->setPassword(md5($this->request->post("password")));
        }

        if ($user->getEmail() != $this->request->post("email")) {
            if (Validator::checkEmail($this->request->post("email")) && User::isValueUniq("email", $this->request->post("email"))) {
                $user->setEmail($this->request->post("email"));
            }
        }

        $user->save();

        Messages::store("Vartotojo informacija atnaujinta", 2);

        Url::redirect('admin/useredit/' . $userId);
    }

    public function editselectedads()
    {
        $checkedAds = [];
        if($this->request->post("checked_ads")) {
            $checkedAds = $this->request->post("checked_ads");
        }

        $withSelected = $this->request->post("with_selected");

        $selectedAds = Ad::getCollection($checkedAds);

        /**
         * @var \Model\Ad $selectedAd
         */
        foreach ($selectedAds as $selectedAd) {
            switch ($withSelected) {
                case "activate":
                    $selectedAd->setActive(1);
                    break;

                case "deactivate":
                    $selectedAd->setActive(0);
                    break;
            }

            $selectedAd->save();
        }

        Messages::store("Pasirinktų skelbimų informacija atnaujinta", 2);

        Url::redirect("admin/ads");
    }

    public function editselectedusers()
    {
        $checkedUsers = [];
        if($this->request->post("checked_users")) {
            $checkedUsers = $this->request->post("checked_users");
        }

        $withSelected = $this->request->post("with_selected");

        $selectedUsers = User::getCollection($checkedUsers);

        /**
         * @var \Model\User $selectedUser
         */
        foreach ($selectedUsers as $selectedUser) {
            switch ($withSelected) {
                case "activate":
                    $selectedUser->setActive(1);
                    break;

                case "deactivate":
                    $selectedUser->setActive(0);
                    break;
            }

            $selectedUser->save();
        }

        Messages::store("Pasirinktų vartotojų informacija atnaujinta", 2);

        Url::redirect("admin/users");
    }
}