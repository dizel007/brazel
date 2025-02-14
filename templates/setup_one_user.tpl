
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

              <form action="pdo_connect_db/update_user_in_db.php" method="POST" >
                  <br>
                  <label for="" class="form-label">ФИО пользователя</label>

               
                  {* Изменяем количество пользователей*}
                     {$count_users1 = $count_users}
                     {for  $i=0 to $count_users-1}
                                
                               {if $active_user_names_arr_smarty[$i] == $get_responsible}
                                   {$count_users1 = $count_users-1}
                               {/if}
                      {/for}
                  
                  <select name="user_id" class="form-control" size="1">
                                              
                           {for  $i=0 to $count_users1-1}
                            {if isset($arr_update_user)} 

                           {/if}
                                <option value="{$arr_with_all_active_users[$i]['user_id']}">{$arr_with_all_active_users[$i]['user_name']}</option>
                           {/for}
                 </select>
                 
                  <label for="" class="form-label">Телефон</label>
                  <input class="form-control" type="tel" name="user_mobile_phone"  data-phone-pattern>

                  <label for="" class="form-label">Email</label>
                  <input class="form-control" type="email" name="user_email">

                  <label for="" class="form-label">Пароль</label>
                  <input class="form-control"  name="password" type="password">

                  <label for="" class="form-label">Повтор пароля</label>
                  <input class="form-control"  name="repaet_password" type="password">

                  <br>
                  
                  <div class = "center">
                    <input class="btn btn-outline-primary" name="submit" type="submit" value="Обновить данные">
                  </div>
                  

              </form>
         </div>
       </div>
    </div>
</body>
</html>