
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="container shadow-lg">
        <div class="row">
           <div class="col-3 w-30 mx-auto shadow-lg loginform">

              <form action="pdo_connect_db/insert_new_user_in_db.php" method="POST" >
                  <br>
                  <label for="" class="form-label">Логин</label>
                  <input class="form-control"  name="login" type="text" required>
                  
                  <label for="" class="form-label">Имя</label>
                  <input class="form-control"  name="user_first_name" type="text" required>

                  <label for="" class="form-label">Фамилия</label>
                  <input class="form-control"  name="user_last_name" type="text" required>
                  
                  
                  <label for="" class="form-label">Телефон</label>
                  <input class="form-control" type="tel" name="user_mobile_phone"  data-phone-pattern required>

                  <label for="" class="form-label">Email</label>
                  <input class="form-control" type="email" name="user_email" required>

                  <label for="" class="form-label">Пароль</label>
                  <input class="form-control"  name="password" type="password" required>

                  <label for="" class="form-label">Повтор пароля</label>
                  <input class="form-control"  name="repaet_password" type="password" required>

                  <br>
                  
                  <div class = "center">
                    <input class="btn btn-outline-primary" name="submit" type="submit" value="Зарегистрировать">
                  </div>
                  

              </form>
         </div>
       </div>
    </div>
</body>
</html>