<?php

include_once "header.php";

$session = new Session();
if($session->isLoggedIn()){
    header("Location: index.php");
}

$errorEmail = "";
$errorPassword = "";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = new DBRepository();

    if(!$db->userExists($email)){

        $errorEmail = "Użytkownik o podanym adresie e-mail nie istnieje";

    }else{

        $row = $db->getUserByEmail($email);
        $result = password_verify($password, $row['password']);

        if ($result) {
            $session = new Session();
            $session->signIn(new User($row['email'], $row['name'], $row['password']));
            header("Location: index.php");
        } else {
            $errorPassword = "Niepoprawne hasło";
        }
    }
}

?>


<div class="container">

    <div class="form">

        <form method="post" action="login.php">

            <div class="form-header">
                <span>Zaloguj się</span>
                <hr>
            </div>

            <div class="form-row">
                <div class="form-field">
                    <label for="email">Adres e-mail</label>
                    <input type="email" name="email" id="email" required placeholder="jkowalski@gmail.com" value="<?php if(isset($email)) echo $email; ?>">
                    <?php
                    if ($errorEmail !== "") {
                        ?>
                        <span class="form-field-error"><?=$errorEmail?></span>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-field">
                    <label for="password">Hasło</label>
                    <input type="password" name="password" id="password" required value="<?php if(isset($password)) echo $password; ?>">
                    <?php
                    if ($errorPassword !== "") {
                        ?>
                        <span class="form-field-error"><?=$errorPassword?></span>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <button type="submit" class="button-primary" id="login" name="login">Logowanie</button>

        </form>

    </div>

    <div class="post-form-info">
        <span>Nie masz konta?</span>
        <a href="registration.php">Zarejestruj się</a>
    </div>

</div>


<?php

include_once "footer.php";

?>


