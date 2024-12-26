//// Заполняем модальное окно актуальными значениями 
$(document).ready(function($){
  $('.js-open-modal').on("click",function(event){
// открываем модальное окно
    modalName = $(this).attr('data-modal');
    modal = $('.js-modal[data-modal = "' + modalName + '"]');
    modal.addClass('is-show');
 // вычитываем переменные
    id = event.target.id;
  document.getElementById("textarea-Comment").value=""; // Всегда чистим ТехтАриа в комментах при открытии окна
  // document.getElementById("FinishContract").value="";
  // alert ('ID = '+id);
  $.ajax(  {
          url: "functions/get_one_item.php",
          method: 'POST',             /* Метод передачи (post или get) */
          dataType: 'html',
          cache: false,
          data: {id:id},
         success: function(data){
                      obj = jQuery.parseJSON( data ); // парсим объем на переменные
 
                      KpNumber = String(obj[0].KpNumber); // парсим объем на переменные
                      InnCustomer = String(obj[0].InnCustomer);
                      NameCustomer = String(obj[0].NameCustomer);
                      idKp = String(obj[0].idKp);
                      KpImportance = String(obj[0].KpImportance);
                      Responsible = String(obj[0].Responsible);
                      Comment = String(obj[0].Comment);
                      DateNextCall = String(obj[0].DateNextCall);
                      KpCondition = String(obj[0].KpCondition);
                      KpSum = String(obj[0].KpSum);
                      TenderSum = String(obj[0].TenderSum);
                      FinishContract = String(obj[0].FinishContract);
                      Adress = String(obj[0].adress);
                      dateContract = String(obj[0].dateContract);
                      procent_work = String(obj[0].procent_work);
                      dateFinishContract = String(obj[0].dateFinishContract);

    
// alert ('FIRS = '+FinishContract);
      document.getElementById("js-new-modal-id").innerHTML = id;
      document.getElementById('js-new-modal-id').value = id;
      document.getElementById("js-new-modal-KpNumber").innerHTML = KpNumber;
      document.getElementById("js-new-modal-InnCustomer").innerHTML = InnCustomer;
      document.getElementById("js-new-modal-NameCustomer").innerHTML = NameCustomer;
      document.getElementById("js-new-modal-idKp").innerHTML = idKp;
      document.getElementById("js-new-modal-Comment").innerHTML = Comment; // отображаемое значение
      document.getElementById('js-new-modal-Comment').value = Comment; // value  -  коде
      document.getElementById("DateNextCall").innerHTML = DateNextCall; // отображаемое значение
      document.getElementById("DateNextCall").value = DateNextCall; // value  - коде
      document.getElementById("procent_work").innerHTML = procent_work;
               
     // В зависимости от значения KpImportance выбираем какой опшинс сделать активным
  select = document.getElementById('KpCondition').getElementsByTagName('option');
  for (i=0; i<select.length; i++) {
     if (select[i].value == KpCondition) select[i].selected = true;
      }
     
     
      document.getElementById('KpSum').value = KpSum; // value  - коде
      document.getElementById("js-new-modal-TenderSum").innerHTML = TenderSum;

      // В зависимости от значения FinishContract выбираем какой опшинс сделать активным
      select = document.getElementById('FinishContract').getElementsByTagName('option');
            if (FinishContract == 1) select[1].selected = true;
            if (FinishContract == 0) select[0].selected = true;
      

      document.getElementById("textarea-Adress").innerHTML = Adress; // отображаемое значение
      document.getElementById('textarea-Adress').value = Adress; // value  -  коде
      
      document.getElementById("procent_work").innerHTML = procent_work; // отображаемое значение
      document.getElementById('procent_work').value = procent_work; // value  -  коде

      document.getElementById("dateContract").innerHTML = dateContract; // отображаемое значение
      document.getElementById("dateContract").value = dateContract; // value  - коде

      document.getElementById("dateFinishContract").innerHTML = dateFinishContract; // отображаемое значение
      document.getElementById("dateFinishContract").value = dateFinishContract; // value  - коде
      
  // В зависимости от значения Responsible выбираем какой опшинс сделать активным
      select = document.getElementById('Responsible').getElementsByTagName('option');
      for (i=0; i<select.length; i++) {
        if (select[i].value == Responsible) select[i].selected = true;
      }
// В зависимости от значения KpImportance выбираем какой опшинс сделать активным
  select = document.getElementById('KpImportance').getElementsByTagName('option');
  for (i=0; i<select.length; i++) {
     if (select[i].value == KpImportance) select[i].selected = true;
      }

   }

   });

});
});

  
/// Закрываем модальное окно
$('.js-modal-close').click(function() {
getParent('.is-show', '.js-modal');
});
function getParent(elemSelector, parentSelector) {
  var elem = document.querySelector(elemSelector);
  var parents = document.querySelectorAll(parentSelector);
  
  for (var i = 0; i < parents.length; i++) {
    var parent = parents[i];
    
    if (parent.contains(elem)) {
      var attr = parent.getAttribute('data-modal');
      var modal = $('.js-modal[data-modal = "' + attr + '"]');
      modal.removeClass('is-show');
      
    }
  }
  return null;
} 