<?php
    session_start();

    if (isset($_POST['email']))
    {
        // Udana walidacja? Załóżmy, że tak!
        $wszystko_OK=true;

        // Sprawdzenie poprawności nickname'a
        $nick = $_POST['nick'];

        // Sprawdzenie długości nicka
        if ((strlen($nick)<3) || (strlen($nick)>20))
        {
            $wszystko_OK=false;
            $_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
        }

        if (ctype_alnum($nick)==false)
        {
            $wszystko_OK=false;
            $_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
        }

        // Sprawdź poprawność adresu email
        $email = $_POST['email'];
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

        if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
        {
            $wszystko_OK=false;
            $_SESSION['e_email']="Podaj poprawny adres e-mail!";
        }

        // Sprawdź poprawność hasła
        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];

        if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
        {
            $wszystko_OK=false;
            $_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków";
        }

        if ($haslo1!=$haslo2)
        {
            $wszystko_OK=false;
            $_SESSION['e_haslo']="Podane hasła nie są identyczne";
        }

        $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
        // echo $haslo_hash; exit();

        // echo $_POST['regulamin']; exit();

        // Czy zaakceptowano regulamin
        if (!isset($_POST['regulamin']))
        {
            $wszystko_OK=false;
            $_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
        }

        if ($wszystko_OK==true)
        {
            // Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy
            echo "Udana walidacja!"; exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Osadnicy - załóż darmowe konto</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <style>
    .error {
        color: red;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    </style>
</head>

<body>

    <form method="post">
        Nickname: <br /> <input type="text" name="nick" /><br />

        <?php
            if (isset($_SESSION['e_nick']))
            {
                echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
                unset($_SESSION['e_nick']);
            }
        ?>

        E-mail: <br /> <input type="text" name="email" /><br />

        <?php
            if (isset($_SESSION['e_email']))
            {
                echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                unset($_SESSION['e_email']);
            }
        ?>

        Twoje hasło: <br /> <input type="password" name="haslo1" /><br />

        <?php
            if (isset($_SESSION['e_haslo']))
            {
                echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
                unset($_SESSION['e_haslo']);
            }
        ?>


        Powtórz hasło: <br /> <input type="password" name="haslo2" /><br />

        <label for="regulamin">
            <input type="checkbox" id="regulamin" name="regulamin" /> Akceptuję regulamin
        </label>

        <?php
            if (isset($_SESSION['e_regulamin']))
            {
                echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
                unset($_SESSION['e_regulamin']);
            }
        ?>


        <br />

        <div class="g-recaptcha" data-sitekey="6LevzQ4pAAAAAEdScosjHtKkY_vCcuOPauvGz8Fb"></div>

        <input type="submit" value="Zarejestruj się" />

    </form>

</body>

</html>