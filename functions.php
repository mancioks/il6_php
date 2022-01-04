<?php
//
//$userEmail = "belekas@beleka.lt";
//
//if(isEmailValid($userEmail)){
//    echo clearEmail($userEmail);
//}else{
//    echo 'Emailas nevalidus';
//}
//
//function isEmailValid($email){
//    if (str_contains($email, '@') && str_contains($email, '.')) {
//        return true;
//    }
//    return false;
//}
//
//

/**
 * @param $email
 * @return string
 */
function clearEmail($email){
    $emailLowercases = strtolower($email);
    return trim($emailLowercases);
}
//
//$name = "Mantas";
//$surname = "Kryževičius";
//
//function getNickName($name, $surName) {
//    return strtolower(substr($name, 0, 3).substr($surName, 0, 3)).mt_rand(1, 100);
//}
//
//echo getNickName($name, $surname);
//


//$title = "Musu kazkokia tai antraste";
//echo getSlug($title);
/**
 * @param $title //generate slug from title
 * @return string //return slug
 */
function getSlug($title) {
    return strtolower(str_replace(" ", "-", $title));
}