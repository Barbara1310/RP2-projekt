<?php

require __SITE_PATH . "/service/UserService.php";

class usersController extends BaseController
{

    public function index()
    {
        $user = $_SESSION["user"];
        $this->registry->template->user = $user;
        $this->registry->template->show("profile");
    }
    // public function add_question()
    // {
    //    //dodajemo novo pitanje u bazu (users_askQuestion.php)
    //    if(!isset($_SESSION["username"]) && !isset($_POST["username"])){
    //      exit("Greška! Username nije postavljen.");
    //    }
    //    $username = $_SESSION["username"];

    //    $ss = new SpomenarService();

    //    if(isset($_POST['question']) && isset($_POST['add_question'])){
    //      $question = $_POST['question'];
    //      if(preg_match('/^[a-zA-Z0-9,-. ?!]+$/',$question))){
    //        echo $_POST['question_type'];
    //        if((int)$_POST['question_type'] === 1) { $question_type = 'text'}
    //        else {$question_type = 'draw'}

    //        $ss->insert_question($question, $question_type);
    //      }
    //    }

    //    $this->registry->template->username = $username;
    // 	   $this->registry->template->title = 'Postavi novo pitanje!';
    //    $this->registry->template->questionList = $ss->get_all_questions();
    // 	   $this->registry->template->show( 'users_askQuestion' );
    // 	   exit;
    // }

    // public function add_privileged_user()
    // {
    //   //korisnik postaje povlašteni
    //   if(!isset($_SESSION["username"]) && !isset($_POST["username"])){
    //      exit("Greška! Username nije postavljen.");

    //   $username = $_SESSION["username"];

    //   $ss = new SpomenarService();

    //   if(isset($_POST['new_privileged']) && isset($_POST['add_privileged']))
    //   {
    //     $user = $_POST['new_privileged'];
    //     if(!($ss->check_user_in_base($user))) {$ss->change_status($user, 'privileged');}
    //   }
    //   $this->registry->template->username = $username;
    //   $this->registry->template->title = 'Postavi novo pitanje!';
    //   $this->registry->template->questionList = $ss->get_all_questions();
    //   $this->registry->template->show( 'users_addPrivileged' );
    //   exit;

    // }


}
