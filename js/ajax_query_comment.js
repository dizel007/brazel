// При нажатии кнопки Сохранить
$('document').ready(function(){
  $('.btncommentClass').click(function(){   
// Выгребаем все данные из таблицы
        sel = document.getElementById("js-id");
    var id = sel.options[sel.selectedIndex].value;
        sel = document.getElementById("KpImportance");
    var KpImportance = sel.options[sel.selectedIndex].value;
        sel = document.getElementById("Responsible");
    var Responsible = sel.options[sel.selectedIndex].value;
    var Comment = $('#textarea-Comment').val(); // берем данные из тексарии коментария
        sel = document.getElementById("DateNextCall");
    var DateNextCall = sel.value;
        sel = document.getElementById("KpCondition");
    var KpCondition = sel.options[sel.selectedIndex].value;
        sel = document.getElementById("KpSum");
    var KpSum = sel.value;
        sel = document.getElementById("FinishContract");
    var FinishContract = sel.value;
        sel = document.getElementById("textarea-Adress"); 
   var Adress = sel.value;
       sel = document.getElementById("dateContract");
   var dateContract = sel.value;
   sel = document.getElementById("procent_work");
   var procent_work = sel.value;
   sel = document.getElementById("dateFinishContract");
   var dateFinishContract = sel.value;
//    alert ('00 = ' + procent_work);
   $.ajax({  // отправляем запрос на обновление БД
      url: "pdo_connect_db/update_all_zakup.php",
      method: 'POST',             /* Метод передачи (post или get) */
      dataType: 'html',
      data: {id:id,
        KpImportance:KpImportance,
        Responsible:Responsible,
        Comment:Comment,
        DateNextCall:DateNextCall,
        KpCondition:KpCondition,
        KpSum:KpSum,
        FinishContract:FinishContract,
        Adress:Adress,
        dateContract:dateContract,
        procent_work:procent_work,
        dateFinishContract:dateFinishContract,
      },
      success: function(data){
        //    alert ('ОБНОВЛЕНИЕ ПРОШЛО УСПЕШНО  ' + data);
        getParent('.is-show', '.js-modal');
        
        var obj = jQuery.parseJSON( data ); // парсим объем на переменные
        var id = String(obj['id']);
        var KpImportance = String(obj['KpImportance']);
        var Responsible = String(obj['Responsible']);
        var Comment = String(obj['Comment']);
        var DateNextCall = String(obj['DateNextCall']);
        var KpCondition = String(obj['KpCondition']);
        var KpSum = String(obj['KpSum']);
        var FinishContract = String(obj['FinishContract']);
        var Adress = String(obj['Adress']);
        var dateContract = String(obj['dateContract']);
        var procent_work = String(obj['procent_work']);
        var dateFinishContract = String(obj['dateFinishContract']);
        
        // alert ('01 = ' + procent_work);

        ///////////// ОБНОВЛЕНИЕ ДАННЫХ В НАШЕЙ ТАБЛИЦЕ***********************************
        var find= 'js-KpImportance' + id;
        sel = document.getElementById(find);
        sel.innerHTML = KpImportance;
        sel.style.cssText=`color: red !important;
        font-style: italic;
        font-weight: 700;
        background-color: rgb(218, 185, 179);`;

        find= 'js-Responsible' + id;
        sel = document.getElementById(find);
        sel.innerHTML = Responsible;
        sel.style.cssText=`color: red !important;
        font-style: italic;
        font-weight: 700;
        background-color: rgb(218, 185, 179);`;

        find= 'js-comment' + id;
        sel = document.getElementById(find);
        sel.innerHTML = Comment;
        sel.style.cssText=`color: red !important;
        font-style: italic;
        font-weight: 700;
        background-color: rgb(218, 185, 179);`;
  
        find= 'js-DateNextCall' + id;
        sel = document.getElementById(find);
        sel.innerHTML = DateNextCall;
        sel.style.color="blue";

        find= 'js-KpCondition' + id;
        sel = document.getElementById(find);
        sel.innerHTML = KpCondition;
        sel.style.color="blue";

        find= 'js-KpSum' + id;
        sel = document.getElementById(find);
        sel.innerHTML = KpSum;
        sel.style.color="blue";

        find= 'js-FinishContract' + id;
        sel = document.getElementById(find);
        sel.innerHTML = FinishContract;
        sel.style.color="blue";

        find= 'js-Adress' + id;
        sel = document.getElementById(find);
        sel.innerHTML = Adress;
        sel.style.color="blue";

        find= 'js-procent_work' + id;
        sel = document.getElementById(find);
        sel.innerHTML = procent_work;
        sel.style.color="blue";


        find= 'js-dateContract' + id;
        sel = document.getElementById(find);
        sel.innerHTML = dateContract;
        sel.style.color="blue";

        find= 'js-dateFinishContract' + id;
        sel = document.getElementById(find);
        sel.innerHTML = dateFinishContract;
        sel.style.color="blue";


      }
   });
   });
  });

 