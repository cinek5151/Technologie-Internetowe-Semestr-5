<?php

include_once "header.php";

$session = new Session();
if($session->isLoggedIn()){
    header("Location: index.php");
}

$error = "";

if (isset($_POST['register'])) {

    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];

    $db = new DBRepository();

    if($db->userExists($email)){

        $error = "Użytkownik o podanym adresie e-mail już istnieje";

    }else{
        $user = new User($email, $name, $password);
        $result = $db->addUser($user);

        if ($result) {
            $session = new Session();
            $session->signIn($user);
            header("Location: index.php");
        } else {
            $error = "Coś poszło nie tak...";
        }
    }
}

?>


<div class="container">

    <div class="form">

        <form method="post" action="registration.php">

            <div class="form-header">
                <span>Zarejestruj się</span>
                <hr>
            </div>

            <div class="form-row">
                <div class="form-field">
                    <label for="email">Adres e-mail</label>
                    <input type="email" name="email" id="email" required placeholder="jkowalski@gmail.com" value="<?php if(isset($email)) echo $email; ?>">
                    <?php
                    if ($error !== "") {
                        ?>
                        <span class="form-field-error"><?=$error?></span>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-field">
                    <label for="name">Imię</label>
                    <input type="text" name="name" id="name" required placeholder="Jan" value="<?php if(isset($name)) echo $name; ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-field">
                    <label for="password">Hasło</label>
                    <input type="password" name="password" id="password" required value="<?php if(isset($password)) echo $password; ?>">
                </div>
            </div>

            <button type="submit" class="button-primary" id="register" name="register">Rejestracja</button>

        </form>

    </div>

    <div class="post-form-info">
        <span>Masz już konto?</span>
        <a href="login.php">Zaloguj się</a>
    </div>

</div>


<?php

include_once "footer.php";

?>


